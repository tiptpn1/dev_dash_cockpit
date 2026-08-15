<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class LogViewerController extends Controller
{
    /**
     * Detect log file locations
     */
    private function detectLogPaths()
    {
        $possiblePaths = [
            storage_path('logs/laravel.log'),
            storage_path('logs/laravel-' . date('Y-m-d') . '.log'),
            base_path('storage/logs/laravel.log'),
            '/var/log/nginx/error.log',
            '/var/log/apache2/error.log',
            'C:/xampp/apache/logs/error.log',
            'C:/wamp/logs/apache_error.log',
        ];

        $foundLogs = [];

        foreach ($possiblePaths as $path) {
            if (File::exists($path) && File::isReadable($path)) {
                $foundLogs[] = [
                    'path' => $path,
                    'name' => basename($path),
                    'size' => File::size($path),
                    'modified' => File::lastModified($path),
                    'readable' => true,
                ];
            }
        }

        // Auto-detect daily logs
        $logDir = storage_path('logs');
        if (File::isDirectory($logDir)) {
            $files = File::files($logDir);
            foreach ($files as $file) {
                $path = $file->getPathname();
                if (!in_array($path, array_column($foundLogs, 'path'))) {
                    if (preg_match('/\.(log|txt)$/i', $path)) {
                        $foundLogs[] = [
                            'path' => $path,
                            'name' => $file->getFilename(),
                            'size' => $file->getSize(),
                            'modified' => $file->getMTime(),
                            'readable' => $file->isReadable(),
                        ];
                    }
                }
            }
        }

        // Sort by modified time (newest first)
        usort($foundLogs, function($a, $b) {
            return $b['modified'] - $a['modified'];
        });

        return $foundLogs;
    }

    /**
     * Get log viewer page
     */
    public function index()
    {
        // Security check - hanya untuk development atau admin
        if (!app()->environment('local') && !auth()->check()) {
            abort(403, 'Unauthorized access to log viewer');
        }

        $logs = $this->detectLogPaths();

        return view('admin.log-viewer-enhanced', [
            'logs' => $logs,
            'selectedLog' => $logs[0]['path'] ?? null,
        ]);
    }

    /**
     * Get log content via AJAX
     */
    public function getLog(Request $request)
    {
        // Security check
        if (!app()->environment('local') && !auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $logPath = $request->input('path');
        $lines = $request->input('lines', 100);
        $filter = $request->input('filter', '');
        $level = $request->input('level', 'all');

        // Validate path (must be in storage/logs)
        $allowedDir = storage_path('logs');
        $realPath = realpath($logPath);

        if (!$realPath || strpos($realPath, $allowedDir) !== 0) {
            return response()->json(['error' => 'Invalid log path'], 400);
        }

        if (!File::exists($logPath) || !File::isReadable($logPath)) {
            return response()->json(['error' => 'Log file not found or not readable'], 404);
        }

        try {
            // Read file from bottom (last N lines)
            $content = $this->tailFile($logPath, $lines);
            
            // Parse log entries
            $entries = $this->parseLogEntries($content);
            
            // Filter by level
            if ($level !== 'all') {
                $entries = array_filter($entries, function($entry) use ($level) {
                    return strtolower($entry['level']) === strtolower($level);
                });
            }
            
            // Filter by text
            if ($filter) {
                $entries = array_filter($entries, function($entry) use ($filter) {
                    return stripos($entry['message'], $filter) !== false ||
                           stripos($entry['context'], $filter) !== false;
                });
            }

            return response()->json([
                'success' => true,
                'path' => $logPath,
                'name' => basename($logPath),
                'size' => File::size($logPath),
                'modified' => date('Y-m-d H:i:s', File::lastModified($logPath)),
                'entries' => array_values($entries),
                'total' => count($entries),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to read log: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear log file
     */
    public function clearLog(Request $request)
    {
        // Security check - extra strict for clear action
        if (!app()->environment('local') || !auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $logPath = $request->input('path');
        
        // Validate path
        $allowedDir = storage_path('logs');
        $realPath = realpath($logPath);

        if (!$realPath || strpos($realPath, $allowedDir) !== 0) {
            return response()->json(['error' => 'Invalid log path'], 400);
        }

        try {
            File::put($logPath, '');
            Log::info('Log file cleared', ['path' => $logPath, 'user' => auth()->user()->username ?? 'unknown']);
            
            return response()->json([
                'success' => true,
                'message' => 'Log cleared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to clear log: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Execute cURL request for debugging
     */
    public function executeCurl(Request $request)
    {
        // Security check
        if (!app()->environment('local') && !auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'url' => 'required|string',
            'method' => 'required|in:GET,POST,PUT,DELETE,PATCH',
            'headers' => 'nullable|array',
            'body' => 'nullable|string',
            'timeout' => 'nullable|integer|min:1|max:120',
        ]);

        $url = $validated['url'];
        $method = $validated['method'];
        $headers = $validated['headers'] ?? [];
        $body = $validated['body'] ?? '';
        $timeout = $validated['timeout'] ?? 30;

        $startTime = microtime(true);

        try {
            $ch = curl_init($url);
            
            // Set method
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            
            // Set headers
            $curlHeaders = [];
            foreach ($headers as $key => $value) {
                $curlHeaders[] = "$key: $value";
            }
            if (!empty($curlHeaders)) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeaders);
            }
            
            // Set body for POST/PUT/PATCH
            if (in_array($method, ['POST', 'PUT', 'PATCH']) && !empty($body)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            }
            
            // Options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            
            // Capture verbose output
            $verbose = fopen('php://temp', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $verbose);
            
            // Execute
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            $info = curl_getinfo($ch);
            
            // Get verbose output
            rewind($verbose);
            $verboseLog = stream_get_contents($verbose);
            fclose($verbose);
            
            curl_close($ch);
            
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            
            // Separate headers and body
            $headerSize = $info['header_size'];
            $responseHeaders = substr($response, 0, $headerSize);
            $responseBody = substr($response, $headerSize);
            
            return response()->json([
                'success' => empty($error),
                'request' => [
                    'url' => $url,
                    'method' => $method,
                    'headers' => $headers,
                    'body' => $body,
                ],
                'response' => [
                    'status_code' => $httpCode,
                    'headers' => $responseHeaders,
                    'body' => $responseBody,
                    'size' => strlen($responseBody),
                ],
                'timing' => [
                    'duration_ms' => $duration,
                    'total_time' => $info['total_time'],
                    'connect_time' => $info['connect_time'],
                    'namelookup_time' => $info['namelookup_time'],
                ],
                'info' => $info,
                'verbose' => $verboseLog,
                'error' => $error,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get system information for debugging
     */
    public function getSystemInfo()
    {
        // Security check
        if (!app()->environment('local') && !auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'php_version'       => PHP_VERSION,
            'memory_limit'      => ini_get('memory_limit'),
            'max_execution_time'=> ini_get('max_execution_time'),
            'upload_max_filesize'=> ini_get('upload_max_filesize'),
            'laravel_version'   => app()->version(),
            'environment'       => app()->environment(),
            'debug_mode'        => config('app.debug'),
            'timezone'          => config('app.timezone'),
            'cache_driver'      => config('cache.default'),
            'session_driver'    => config('session.driver'),
            'queue_driver'      => config('queue.default'),
            'disk_free_space'   => round(disk_free_space(storage_path()) / (1024 ** 3), 2) . ' GB',

            // Provider 1: agrinav_agent (be.ptpn1.co.id - Active)
            'ai_backend_url'    => env('AI_BACKEND_URL', 'Not configured'),
            'ai_backend_agent'  => env('AI_BACKEND_AGENT', 'Not configured'),
            'ai_backend_base'   => env('AI_BACKEND_BASE_URL', 'Not configured'),
            'ai_backend_user'   => env('AI_BACKEND_USERNAME', 'Not configured'),
            'ai_timeout'        => env('AI_BACKEND_TIMEOUT', 120),

            // Provider 2: aigr1_assistant (workflow.ptpn1.co.id - Legacy)
            'ai_workflow_url'   => env('WORKFLOW_WEBHOOK_URL', 'Not configured'),
        ]);
    }

    /**
     * Test AI backend connection
     */
    public function testAiBackend()
    {
        // Security check
        if (!app()->environment('local') && !auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $baseUrl = env('AI_BACKEND_BASE_URL', 'https://be.ptpn1.co.id');
        $username = env('AI_BACKEND_USERNAME', 'agent_test');
        $password = env('AI_BACKEND_PASSWORD', 'agent123');
        
        $results = [];
        
        // Test 1: Health check
        try {
            $start = microtime(true);
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                ->timeout(10)
                ->get("$baseUrl/api/health");
            $duration = round((microtime(true) - $start) * 1000, 2);
            
            $results['health'] = [
                'success' => $response->successful(),
                'status' => $response->status(),
                'duration_ms' => $duration,
                'response' => $response->json(),
            ];
        } catch (\Exception $e) {
            $results['health'] = [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
        
        // Test 2: Login
        try {
            $start = microtime(true);
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                ->timeout(20)
                ->post("$baseUrl/api/auth/login", [
                    'username' => $username,
                    'password' => $password,
                ]);
            $duration = round((microtime(true) - $start) * 1000, 2);
            
            $data = $response->json();
            $token = $data['data']['webChatToken'] ?? null;
            
            $results['login'] = [
                'success' => $response->successful() && $token !== null,
                'status' => $response->status(),
                'duration_ms' => $duration,
                'has_token' => $token !== null,
                'token_preview' => $token ? substr($token, 0, 20) . '...' : null,
            ];
            
            // Test 3: Chat request (if login successful)
            if ($token) {
                try {
                    $start = microtime(true);
                    $chatResponse = \Illuminate\Support\Facades\Http::withoutVerifying()
                        ->timeout(30)
                        ->withHeaders([
                            'Authorization' => 'Bearer ' . $token,
                        ])
                        ->post("$baseUrl/api/ai/chat", [
                            'message' => 'Test connection',
                            'stream' => false,
                            'agent' => ['name' => env('AI_BACKEND_AGENT', 'agrinav_agent')],
                            'token' => $token,
                            'source' => 'web',
                        ]);
                    $duration = round((microtime(true) - $start) * 1000, 2);
                    
                    $results['chat'] = [
                        'success' => $chatResponse->successful(),
                        'status' => $chatResponse->status(),
                        'duration_ms' => $duration,
                        'response_preview' => substr(json_encode($chatResponse->json()), 0, 200) . '...',
                    ];
                } catch (\Exception $e) {
                    $results['chat'] = [
                        'success' => false,
                        'error' => $e->getMessage(),
                    ];
                }
            }
            
        } catch (\Exception $e) {
            $results['login'] = [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
        
        return response()->json($results);
    }

    /**
     * Test API endpoint (cURL)
     */
    public function testApi(Request $request)
    {
        // Security check
        if (!app()->environment('local') && !auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $url = $request->input('url');
        $method = strtoupper($request->input('method', 'GET'));
        $headers = $request->input('headers', []);
        $body = $request->input('body', '');
        $timeout = $request->input('timeout', 30);

        try {
            $startTime = microtime(true);
            
            $ch = curl_init($url);
            
            // Set method
            if ($method === 'POST') {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            } elseif ($method === 'PUT') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            } elseif ($method === 'DELETE') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            }
            
            // Set headers
            $curlHeaders = [];
            foreach ($headers as $key => $value) {
                $curlHeaders[] = "$key: $value";
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeaders);
            
            // Common options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_HEADER, true);
            
            // Execute
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $totalTime = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
            $error = curl_error($ch);
            
            // Get response headers
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $responseHeaders = substr($response, 0, $headerSize);
            $responseBody = substr($response, $headerSize);
            
            curl_close($ch);
            
            $endTime = microtime(true);
            $executionTime = round(($endTime - $startTime) * 1000, 2);
            
            return response()->json([
                'success' => empty($error),
                'status_code' => $httpCode,
                'execution_time' => $executionTime . ' ms',
                'response_headers' => $responseHeaders,
                'response_body' => $responseBody,
                'error' => $error ?: null,
                'curl_info' => [
                    'total_time' => $totalTime,
                    'url' => $url,
                    'method' => $method,
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test chatbot endpoint — support dua provider:
     *   provider=agrinav  → be.ptpn1.co.id (JSON, webChatToken)
     *   provider=workflow  → workflow.ptpn1.co.id (form-urlencoded, tanpa token)
     */
    public function testChatbot(Request $request)
    {
        // Security check
        if (!app()->environment('local') && !auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message  = $request->input('message', 'Test message');
        $stream   = filter_var($request->input('stream', false), FILTER_VALIDATE_BOOLEAN);
        $provider = $request->input('provider', 'agrinav'); // 'agrinav' | 'workflow'

        try {
            $startTime = microtime(true);

            // ── PROVIDER: workflow (aigr1_assistant) ──────────────────────────
            if ($provider === 'workflow') {
                $url = env('WORKFLOW_WEBHOOK_URL', '');
                if (empty($url)) {
                    return response()->json([
                        'success' => false,
                        'error'   => 'WORKFLOW_WEBHOOK_URL belum dikonfigurasi di .env',
                    ], 400);
                }

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                    'query'        => $message,
                    'id_user_chat' => 'admin-test',
                    'thread_id'    => '',
                    'agent'        => json_encode(['name' => 'aigr1_assistant']),
                ]));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_HEADER, true);

                $response   = curl_exec($ch);
                $httpCode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $error      = curl_error($ch);
                curl_close($ch);

                $executionTime  = round((microtime(true) - $startTime) * 1000, 2);
                $responseBody   = substr($response, $headerSize);

                return response()->json([
                    'success'        => empty($error) && $httpCode === 200,
                    'provider'       => 'workflow',
                    'agent'          => 'aigr1_assistant',
                    'status_code'    => $httpCode,
                    'execution_time' => $executionTime . ' ms',
                    'request'        => [
                        'url'     => $url,
                        'format'  => 'application/x-www-form-urlencoded',
                        'payload' => ['query' => $message, 'id_user_chat' => 'admin-test'],
                    ],
                    'response_body'  => $responseBody,
                    'error'          => $error ?: null,
                ]);
            }

            // ── PROVIDER: agrinav (agrinav_agent via be.ptpn1.co.id) ──────────
            $token = $this->getChatbotToken();

            if (!$token) {
                return response()->json([
                    'success' => false,
                    'error'   => 'Gagal mendapatkan webChatToken dari be.ptpn1.co.id. ' .
                                 'Periksa AI_BACKEND_USERNAME/PASSWORD di .env.',
                ], 500);
            }

            $url     = env('AI_BACKEND_URL', 'https://be.ptpn1.co.id/api/ai/chat');
            $agent   = env('AI_BACKEND_AGENT', 'agrinav_agent');

            $payload = [
                'message' => $message,
                'stream'  => $stream,
                'agent'   => ['name' => $agent],
                'token'   => $token,
                'source'  => 'web',
            ];

            if ($stream) {
                return $this->testChatbotStreaming($url, $payload, $token, $startTime);
            }

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HEADER, true);

            $response   = curl_exec($ch);
            $httpCode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $error      = curl_error($ch);
            curl_close($ch);

            $executionTime = round((microtime(true) - $startTime) * 1000, 2);

            return response()->json([
                'success'        => empty($error) && $httpCode === 200,
                'provider'       => 'agrinav',
                'agent'          => $agent,
                'status_code'    => $httpCode,
                'execution_time' => $executionTime . ' ms',
                'request'        => [
                    'url'     => $url,
                    'format'  => 'application/json',
                    'payload' => array_merge($payload, ['token' => substr($token, 0, 20) . '...']),
                ],
                'response_body'  => substr($response, $headerSize),
                'error'          => $error ?: null,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Test chatbot with streaming (SSE) - Return as SSE stream
     */
    private function testChatbotStreaming($url, $payload, $token, $startTime)
    {
        // Return SSE stream response
        return response()->stream(function () use ($url, $payload, $token) {
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');
            header('X-Accel-Buffering: no');
            
            ob_implicit_flush(true);
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
                'Accept: text/event-stream'
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            
            // Forward stream directly to client
            curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($curl, $data) {
                echo $data;
                if (ob_get_level() > 0) {
                    @ob_flush();
                }
                flush();
                return strlen($data);
            });
            
            curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            
            if ($error) {
                echo "data: " . json_encode(['type' => 'error', 'error' => $error]) . "\n\n";
                flush();
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    /**
     * Get chatbot token (copied from AiResponseController)
     */
    private function getChatbotToken()
    {
        $cacheKey = 'ai_backend_webchat_token';
        $cached = \Cache::get($cacheKey);
        if ($cached) {
            return $cached;
        }

        $baseUrl = env('AI_BACKEND_BASE_URL', 'https://be.ptpn1.co.id');
        $username = env('AI_BACKEND_USERNAME', 'agent_test');
        $password = env('AI_BACKEND_PASSWORD', 'agent123');

        try {
            $response = \Http::withoutVerifying()
                ->timeout(20)
                ->post($baseUrl . '/api/auth/login', [
                    'username' => $username,
                    'password' => $password,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $token = $data['data']['webChatToken'] ?? null;
                
                if ($token) {
                    \Cache::put($cacheKey, $token, now()->addHours(12));
                    return $token;
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to get chatbot token: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Download log file
     */
    public function downloadLog(Request $request)
    {
        // Security check
        if (!app()->environment('local') && !auth()->check()) {
            abort(403);
        }

        $logPath = $request->input('path');
        
        // Validate path
        $allowedDir = storage_path('logs');
        $realPath = realpath($logPath);

        if (!$realPath || strpos($realPath, $allowedDir) !== 0) {
            abort(400, 'Invalid log path');
        }

        if (!File::exists($logPath)) {
            abort(404, 'Log file not found');
        }

        return response()->download($logPath);
    }

    /**
     * Get last N lines from file (tail equivalent)
     */
    private function tailFile($filepath, $lines = 100)
    {
        $handle = fopen($filepath, 'r');
        $linecounter = $lines;
        $pos = -2;
        $beginning = false;
        $text = [];

        while ($linecounter > 0) {
            $t = ' ';
            while ($t != "\n") {
                if (fseek($handle, $pos, SEEK_END) == -1) {
                    $beginning = true;
                    break;
                }
                $t = fgetc($handle);
                $pos--;
            }
            $linecounter--;
            if ($beginning) {
                rewind($handle);
            }
            $text[$lines - $linecounter - 1] = fgets($handle);
            if ($beginning) break;
        }
        fclose($handle);

        return array_reverse($text);
    }

    /**
     * Parse Laravel log entries
     */
    private function parseLogEntries($lines)
    {
        $entries = [];
        $currentEntry = null;

        foreach ($lines as $line) {
            // Match Laravel log pattern: [2024-01-01 12:00:00] local.ERROR: Message
            if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.*)$/', $line, $matches)) {
                // Save previous entry
                if ($currentEntry) {
                    $entries[] = $currentEntry;
                }

                // Start new entry
                $currentEntry = [
                    'timestamp' => $matches[1],
                    'environment' => $matches[2],
                    'level' => strtoupper($matches[3]),
                    'message' => $matches[4],
                    'context' => '',
                ];
            } else {
                // Continuation of previous entry (stack trace, context, etc.)
                if ($currentEntry) {
                    $currentEntry['context'] .= $line . "\n";
                }
            }
        }

        // Save last entry
        if ($currentEntry) {
            $entries[] = $currentEntry;
        }

        return array_reverse($entries); // Newest first
    }
}
