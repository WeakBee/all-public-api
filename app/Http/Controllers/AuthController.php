<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        
        try{
            $validator = \Validator::make($request->all(), [
                'username' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:6',
            ]);
            if ($validator->fails()){
                return response()->json([
                    'status' => 'Error',
                    'success' => 0,
                    'message' => 'Data tidak lengkap',
                    'data' => $validator->errors()->all(),
                ], 400);
            }

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;            

            $data = [
                'user' => $user,
                'token' => $token,
            ];
    
            return response()->json([
                'status' => 'Success',
                'success' => 1,
                'message' => 'Register successful',
                'data' => $data,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'success' => 0,
                'message' => 'Error Register Failed',
                'data' => $th,
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if ($validator->fails()){
                return response()->json([
                    'status' => 'Error',
                    'success' => 0,
                    'message' => 'Data tidak lengkap',
                    'data' => $validator->errors()->all(),
                ], 400);
            }
    
            $user = User::where('email', $request->email)->first();
    
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'Error',
                    'success' => 0,
                    'message' => 'Wrong Email or Password',
                    'data' => 'Wrong Email or Password',
                ], 400);
            }
    
            $token = $user->createToken('auth_token')->plainTextToken;
            
            User::where('email', $request->email)->update([
                'remember_token' => $token,
            ]);

            $data = [
                'user' => $user,
                'token' => $token,
            ];
    
            return response()->json([
                'status' => 'Success',
                'success' => 1,
                'message' => 'Login berhasil',
                'data' => $data,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'success' => 0,
                'message' => 'Error Login Failed : '.$th,
                'data' => "",
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}

