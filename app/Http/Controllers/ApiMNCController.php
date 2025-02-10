<?php

namespace App\Http\Controllers;

use App\Models\ApiMNCError;
use App\Models\ApiMNCSuccess;
use Illuminate\Http\Request;

class ApiMNCController extends Controller
{
    
    public function index(Request $request)
    {
        // Mengambil data JSON dari permintaan
        $data = $request->json()->all();
        try{
            // Membuat array untuk json_response
            $jsonResponse = [
                'SourceID' => $data['ReferenceNo'],
                'NoRef' => $data['IssuerReferenceNo'],
                "ErrorCode" => 0,
                "ErrorMessage" => "",
                "NomorPolis" => $data['PolicyNo'],
                "IssueDate" => now()->format('Y-m-d H:i:s') 
            ];

            ApiMNCSuccess::create([
                "ReferenceNo" => $data['ReferenceNo'],
                "IssuerReferenceNo" => $data['IssuerReferenceNo'],
                "PolicyNo" => $data['PolicyNo'],
                "IssueDate" => now()->format('Y-m-d H:i:s') 
            ]);

            return response()->json($jsonResponse, 200);
        }  catch (\Exception $e) {
            if($data){
                // Membuat array untuk json_response
                $jsonResponse = [
                    'SourceID' => $data['ReferenceNo'],
                    'NoRef' => $data['IssuerReferenceNo'],
                    "ErrorCode" => 1,
                    "ErrorMessage" => $e->getMessage(),
                    "NomorPolis" => "",
                    "IssueDate" => now()->format('Y-m-d H:i:s') // Format tanggal dan jam sesuai kebutuhan
                ];

                ApiMNCError::create([
                    "ReferenceNo" => $data['ReferenceNo'],
                    "IssuerReferenceNo" => $data['IssuerReferenceNo'],
                    "ErrorMessage" => $e->getMessage(),
                    "IssueDate" => now()->format('Y-m-d H:i:s') 
                ]);
            } else {
                // Membuat array untuk json_response
                $jsonResponse = [
                    'SourceID' => "",
                    'NoRef' => "",
                    "ErrorCode" => 1,
                    "ErrorMessage" => $e->getMessage(),
                    "NomorPolis" => "",
                    "IssueDate" => now()->format('Y-m-d H:i:s') // Format tanggal dan jam sesuai kebutuhan
                ];

                ApiMNCError::create([
                    "ReferenceNo" => "",
                    "IssuerReferenceNo" => "",
                    "ErrorMessage" => $e->getMessage(),
                    "IssueDate" => now()->format('Y-m-d H:i:s') 
                ]);
            }

            // Mengembalikan respons gagal 
            return response()->json($jsonResponse, 500);
        }        
    }
}
