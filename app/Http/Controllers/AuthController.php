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
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = User::create([
                'name' => $request->name,
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
                'message' => 'Error Login Failed : '.$th,
                'data' => "",
            ], 400);
        }
    }

    public function login(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            $user = User::where('email', $request->email)->first();
    
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
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
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}

