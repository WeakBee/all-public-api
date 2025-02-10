<?php

namespace App\Http\Controllers;

use App\Models\ApiMNCError;
use App\Models\ApiMNCSuccess;
use App\Models\ApiTest;
use Illuminate\Http\Request;

class ApiTestController extends Controller
{
    
    public function index(Request $request)
    {
        try {
            // Membuat array untuk json_response
            $jsonResponse = [
                "success" => true,
                "data" => $request->all(), // Mengambil semua data dari request sebagai array
                "status" => 200
            ];
        
            ApiTest::create([
                "json_request" => json_encode($request->all()), // Mengubah array menjadi JSON string
                "json_response" => json_encode($jsonResponse), // Mengubah array menjadi JSON string
            ]);
        
            return response()->json($jsonResponse, 200);
        } catch (\Exception $e) {
            if ($request) {
                // Membuat array untuk json_response
                $jsonResponse = [
                    "success" => false,
                    "data" => $request->all(), // Mengambil semua data dari request
                    "status" => 500
                ];
        
                ApiTest::create([
                    "json_request" => json_encode($request->all()), // Mengubah array menjadi JSON string
                    "json_response" => json_encode($jsonResponse), // Mengubah array menjadi JSON string
                ]);
            } else {
                // Membuat array untuk json_response
                $jsonResponse = [
                    "success" => false,
                    "data" => "",
                    "status" => 404
                ];
        
                ApiTest::create([
                    "json_request" => "",
                    "json_response" => json_encode($jsonResponse), // Mengubah array menjadi JSON string
                ]);
            }
        
            // Mengembalikan respons gagal 
            return response()->json($jsonResponse, 500);
        }        
    }
}
