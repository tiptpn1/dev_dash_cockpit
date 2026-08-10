<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

error_reporting(0);

class AiResponseController extends Controller
{
    /**
     * Format page context menjadi system message untuk AI.
     * Context akan diinjeksi sebagai system prompt atau metadata.
     *
     * @param array $pageContext
     * @param string $userMessage
     * @return string
     */
    private function formatContextForAI($pageContext, $userMessage)
    {
        if (empty($pageContext)) {
            return $userMessage;
        }

        $contextParts = [];
        
        // Informasi halaman
        if (!empty($pageContext['summary']['page'])) {
            $contextParts[] = "📍 Halaman: {$pageContext['summary']['page']}";
        }
        
        // User info
        if (!empty($pageContext['summary']['user'])) {
            $contextParts[] = "👤 User: {$pageContext['summary']['user']}";
        }

        // Data yang tersedia
        if (!empty($pageContext['summary']['dataAvailable'])) {
            $contextParts[] = "📊 Data tersedia: " . implode(', ', $pageContext['summary']['dataAvailable']);
        }

        // Tabel data (summary)
        if (!empty($pageContext['summary']['tables'])) {
            $contextParts[] = "\n📋 Detail Tabel:";
            foreach ($pageContext['summary']['tables'] as $index => $tableDesc) {
                $contextParts[] = "  - " . $tableDesc;
            }
            
            // Include sample data dari tabel pertama (jika ada)
            if (!empty($pageContext['full']['data']['tables'][0]['visibleRows'])) {
                $firstTable = $pageContext['full']['data']['tables'][0];
                $sampleRows = array_slice($firstTable['visibleRows'], 0, 3);
                $contextParts[] = "\n📄 Sample data (3 baris pertama):";
                // Tanpa JSON_PRETTY_PRINT: hemat token (whitespace) yang dikirim ke LLM,
                // sehingga time-to-first-token lebih cepat & meminimalkan data yang keluar.
                $contextParts[] = json_encode($sampleRows, JSON_UNESCAPED_UNICODE);
            }
        }

        // Chart data
        if (!empty($pageContext['summary']['charts'])) {
            $contextParts[] = "\n📈 Chart/Grafik:";
            foreach ($pageContext['summary']['charts'] as $chartDesc) {
                $contextParts[] = "  - " . $chartDesc;
            }
        }

        // Statistics
        if (!empty($pageContext['summary']['statistics'])) {
            $contextParts[] = "\n📊 Statistik/Metrik:";
            foreach ($pageContext['summary']['statistics'] as $stat) {
                $contextParts[] = "  - {$stat['label']}: {$stat['value']}";
            }
        }

        // Active filters
        if (!empty($pageContext['summary']['filters'])) {
            $contextParts[] = "\n🔍 Filter Aktif:";
            foreach ($pageContext['summary']['filters'] as $filter) {
                $contextParts[] = "  - " . $filter;
            }
        }

        // Gabungkan context + user message
        $fullMessage = implode("\n", $contextParts);
        $fullMessage .= "\n\n---\n\n";
        $fullMessage .= "Pertanyaan User: " . $userMessage;
        $fullMessage .= "\n\n[INSTRUKSI UNTUK AI: Gunakan data context di atas sebagai referensi untuk menjawab pertanyaan user. Jika user bertanya tentang data, chart, atau informasi di halaman ini, gunakan informasi yang tersedia di context. Jawab dalam Bahasa Indonesia.]";

        return $fullMessage;
    }

    /**
     * Ambil webChatToken dari AI Backend via login.
     * Token di-cache karena webChatToken tidak expire (static token).
     *
     * @param bool $forceRefresh Paksa login ulang (misal token ditolak)
     * @return string|null
     */
    private function getWebChatToken($forceRefresh = false)
    {
        $cacheKey = 'ai_backend_webchat_token';

        if (!$forceRefresh) {
            $cached = Cache::get($cacheKey);
            if ($cached) {
                return $cached;
            }
        }

        $baseUrl = env('AI_BACKEND_BASE_URL', 'https://be.ptpn1.co.id');
        $username = env('AI_BACKEND_USERNAME', 'agent_test');
        $password = env('AI_BACKEND_PASSWORD', 'agent123');

        try {
            $response = Http::withoutVerifying()
                ->timeout(20)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($baseUrl . '/api/auth/login', [
                    'username' => $username,
                    'password' => $password,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $webChatToken = $data['data']['webChatToken'] ?? null;

                if ($webChatToken) {
                    // Cache 12 jam (webChatToken tidak expire, tapi refresh berkala aman)
                    Cache::put($cacheKey, $webChatToken, now()->addHours(12));
                    return $webChatToken;
                }
            }

            Log::warning('AI Backend login gagal mendapatkan webChatToken', [
                'status' => $response->status(),
                'body' => substr($response->body(), 0, 300),
            ]);
        } catch (\Exception $e) {
            Log::error('AI Backend login error: ' . $e->getMessage());
        }

        return null;
    }

    public function aiResponse(Request $request)
    {
        $message = $request->input('message');
        $stream = $request->input('stream', false);

        // sessionId adalah kunci percakapan berkelanjutan (bukan thread_id).
        // Terima sessionId, fallback ke thread_id untuk kompatibilitas mundur.
        $sessionId = $request->input('sessionId', $request->input('thread_id', ''));

        // Nama agent yang benar: agrinav_agent
        $agent = $request->input('agent');
        if (empty($agent) || empty($agent['name'])) {
            $agent = ['name' => env('AI_BACKEND_AGENT', 'agrinav_agent')];
        }

        // source platform (web) sesuai panduan.
        $source = $request->input('source', 'web');
        
        // Page Context dari frontend (NEW!)
        $pageContext = $request->input('pageContext', []);
        
        // Format context untuk AI
        $contextMessage = $this->formatContextForAI($pageContext, $message);

        // CATATAN (Panduan 4A): JANGAN kirim userId manual — diabaikan backend.
        // Identitas user diturunkan otomatis oleh backend dari token (webChatToken).

        // Ambil webChatToken (metode auth yang valid)
        $token = $this->getWebChatToken();

        try {
            // ============ STREAMING ============
            if ($stream) {
                return response()->stream(function () use ($contextMessage, $sessionId, $agent, $token, $source) {
                    header('Content-Type: text/event-stream');
                    header('Cache-Control: no-cache');
                    header('Connection: keep-alive');
                    header('X-Accel-Buffering: no');

                    // Pastikan streaming benar-benar real-time: matikan kompresi output
                    // yang dapat menahan (buffer) potongan SSE hingga menumpuk lalu dikirim
                    // sekaligus. Membuat token pertama terasa lebih cepat muncul.
                    @ini_set('zlib.output_compression', '0');

                    ob_implicit_flush(true);

                    // Kalau token gagal didapat, kirim error langsung
                    if (empty($token)) {
                        $this->sendSSE([
                            'type' => 'error',
                            'error' => 'Gagal autentikasi ke AI Backend. Periksa kredensial AI_BACKEND_USERNAME/PASSWORD.'
                        ]);
                        return;
                    }

                    $url = env('AI_BACKEND_URL', 'https://be.ptpn1.co.id/api/ai/chat');

                    $requestData = [
                        'message' => $contextMessage,  // Message dengan context
                        'stream'  => true,
                        'agent'   => $agent,
                        'token'   => $token,        // webChatToken (identitas diturunkan dari sini)
                        'source'  => $source,       // platform: web
                    ];

                    // Kirim sessionId hanya jika ada (biar backend generate baru saat kosong)
                    if (!empty($sessionId)) {
                        $requestData['sessionId'] = $sessionId;
                    }

                    Log::info('AI Streaming Request', [
                        'url'       => $url,
                        'agent'     => $agent['name'] ?? 'n/a',
                        'sessionId' => $sessionId ?: '(new)',
                        'token'     => 'PRESENT',
                    ]);

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'Accept: text/event-stream',
                        'Authorization: Bearer ' . $token,   // webChatToken sebagai Bearer
                    ]);
                    curl_setopt($ch, CURLOPT_TIMEOUT, env('AI_BACKEND_TIMEOUT', 120));

                    // Forward stream ke client apa adanya, SEKALIGUS tangkap isinya
                    // untuk keperluan logging (raw stream dari AI Backend).
                    $rawStream = '';
                    curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($curl, $data) use (&$rawStream) {
                        $rawStream .= $data;
                        echo $data;
                        if (ob_get_level() > 0) {
                            @ob_flush();
                        }
                        flush();
                        return strlen($data);
                    });

                    curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $error = curl_error($ch);
                    curl_close($ch);

                    // Catat respons AI Backend ke log Laravel (channel default).
                    // Ekstrak jawaban final dari event SSE 'done' bila ada, plus simpan
                    // potongan raw untuk debugging (dibatasi agar log tidak membengkak).
                    $finalAnswer = $this->extractFinalAnswerFromStream($rawStream);
                    Log::info('AI Streaming Response', [
                        'sessionId'    => $sessionId ?: '(new)',
                        'http_code'    => $httpCode,
                        'curl_error'   => $error ?: null,
                        'answer'       => $finalAnswer !== null ? mb_substr($finalAnswer, 0, 2000) : null,
                        'raw_length'   => strlen($rawStream),
                        'raw_preview'  => mb_substr($rawStream, 0, 2000),
                    ]);

                    if ($error) {
                        $this->sendSSE([
                            'type' => 'error',
                            'error' => "cURL Error: {$error}"
                        ]);
                    } elseif ($httpCode !== 200) {
                        $this->sendSSE([
                            'type' => 'error',
                            'error' => 'Backend error',
                            'status_code' => $httpCode,
                        ]);
                    }
                }, 200, [
                    'Content-Type'      => 'text/event-stream',
                    'Cache-Control'     => 'no-cache',
                    'Connection'        => 'keep-alive',
                    'X-Accel-Buffering' => 'no',
                ]);
            }

            // ============ NON-STREAMING ============
            if (empty($token)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal autentikasi ke AI Backend.',
                ], 500);
            }

            $url = env('AI_BACKEND_URL', 'https://be.ptpn1.co.id/api/ai/chat');

            $payload = [
                'message' => $contextMessage,  // Message dengan context
                'stream'  => false,
                'agent'   => $agent,
                'token'   => $token,
                'source'  => $source,
            ];
            if (!empty($sessionId)) {
                $payload['sessionId'] = $sessionId;
            }

            $httpResponse = Http::withoutVerifying()
                ->timeout(env('AI_BACKEND_TIMEOUT', 60))
                ->withHeaders([
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ])
                ->post($url, $payload);

            if (!$httpResponse->successful()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mendapatkan respons dari API eksternal.',
                    'status_code' => $httpResponse->status(),
                    'response' => $httpResponse->body(),
                ], 500);
            }

            $responseData = $httpResponse->json();

            // Jika auth ditolak, coba refresh token sekali
            $content = $responseData['message']['content'] ?? '';
            $success = $responseData['success'] ?? false;
            if (!$success && str_contains($content, 'autentikasi')) {
                $token = $this->getWebChatToken(true); // force refresh
                if ($token) {
                    $payload['token'] = $token;
                    $httpResponse = Http::withoutVerifying()
                        ->timeout(env('AI_BACKEND_TIMEOUT', 60))
                        ->withHeaders([
                            'Content-Type'  => 'application/json',
                            'Authorization' => 'Bearer ' . $token,
                        ])
                        ->post($url, $payload);
                    $responseData = $httpResponse->json();
                }
            }

            $responseText = $responseData['message']['content']
                ?? ($responseData['response'] ?? null);

            $responseSessionId = $responseData['sessionId'] ?? $sessionId;

            if ($responseText === null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Format respons tidak valid dari API eksternal.',
                    'response' => $responseData,
                ], 500);
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'response'  => $responseText,
                    'sessionId' => $responseSessionId,
                ],
                'sessionId' => $responseSessionId,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Helper untuk mengirim Server-Sent Event.
     */
    private function sendSSE($data)
    {
        echo "data: " . json_encode($data) . "\n\n";
        if (ob_get_level() > 0) {
            @ob_flush();
        }
        flush();
    }

    /**
     * Ekstrak jawaban final (message.content) dari raw stream SSE AI Backend.
     * Mencari event 'done' / baris data terakhir yang mengandung message.content.
     *
     * @param string $rawStream
     * @return string|null
     */
    private function extractFinalAnswerFromStream($rawStream)
    {
        if (empty($rawStream)) {
            return null;
        }

        $finalAnswer = null;
        $lines = preg_split('/\r\n|\r|\n/', $rawStream);

        foreach ($lines as $line) {
            $line = trim($line);
            if (strpos($line, 'data:') !== 0) {
                continue;
            }

            $json = trim(substr($line, 5));
            if ($json === '' || $json === '[DONE]') {
                continue;
            }

            $obj = json_decode($json, true);
            if (!is_array($obj)) {
                continue;
            }

            // Struktur umum: {"response":{"message":{"content":"..."}}}
            $content = $obj['response']['message']['content']
                ?? $obj['message']['content']
                ?? $obj['content']
                ?? null;

            if (is_string($content) && $content !== '') {
                $finalAnswer = $content;
            }
        }

        return $finalAnswer;
    }
}
