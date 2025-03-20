<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiResponseController extends Controller
{
    public function aiResponse(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            // Make the API call to the external service
            $response = Http::timeout(180)  // 3 minutes timeout
                ->withOptions([
                    'verify' => false,  // Jika ada masalah SSL
                ])
                ->post('https://aset-dives-dev.ptpn1.co.id/weather/ai_response', [
                    'tanya' => $validated['message']
                ]);

            // Check if the API response is successful
            if (!$response->successful()) {
                return response()->json([
                    'error' => 'External API error',
                    'status' => $response->status(),
                    'message' => $response->body() ?: 'No response from external API'
                ], $response->status());
            }

            // Decode and simplify the response
            $responseBody = json_decode($response->body());
            if (json_last_error() !== JSON_ERROR_NONE || empty($response->body())) {
                return response()->json([
                    'error' => 'Invalid response format',
                    'message' => 'The API returned an empty or invalid response'
                ], 500);
            }

            return response()->json([
                'status' => 'success',
                'response' => $responseBody->response ?? $responseBody->data->data[0]->content[0]->text->value ?? 'No response content'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing your request.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 