<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiResponseController extends Controller
{
    public function aiResponse(Request $request)
    {
        $message = $request->input('message');
        try {

            $url = "https://aset-dives-dev.ptpn1.co.id/weather/ai_response"; // API endpoint
            $data = ['tanya' => $message];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_VERBOSE, true); // Debug mode
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            
            $response = json_decode($response,false);
            
            if ($response->status=="success") {
                return response()->json([
                    'status' => 'success',
                    'data' => $response
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mendapatkan respons dari API eksternal.',
                    'status_code' => $httpCode,
                    'response' => $response
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
} 