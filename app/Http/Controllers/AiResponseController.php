<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

error_reporting(0);

class AiResponseController extends Controller
{
    public function aiResponse(Request $request)
    {
        $message = $request->input('message');
        try {
            $url = "https://aset-dives-dev.ptpn1.co.id/map_ai/ai_response";
            if ($request->input('thread_id')) {
                $thread_id = $request->input('thread_id');
            } else {
                $thread_id = "";
            }
            
            $response = Http::asForm()->post($url, [
                'tanya' => $message,
                'thread_id' => $thread_id
            ]);

            $data = $response->object();

            if ($response->successful() && isset($data->status) && $data->status == "success") {
                return response()->json([
                    'status' => 'success',
                    'data' => $data,
                    'thread_id' => $thread_id
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mendapatkan respons dari API eksternal.',
                    'status_code' => $response->status(),
                    'response' => $data
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}