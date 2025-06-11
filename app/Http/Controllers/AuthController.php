<?php

namespace App\Http\Controllers;

use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
     public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        if ($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $credentials = $request->only('email','password');
        if (Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('Beare token')->plainTextToken;
            return response()->json([
                'status' =>200,
                'token'=> $token,
                'user' => [
                    'roles' => $user->getRoleNames()->first()
                    
                ],
            ],200);
        }else{
            return response()->json([
                'status'=> 401,
                'message'=>'error'
            ],401);
        }

      
    }

    /**
     * Logout (Revoke current token)
     */
    public function logout(Request $request)
    {
        $user = $request->user(); // Get authenticated user
        $user->currentAccessToken()->delete(); // Revoke current token

        return response()->json([
            'status'  => 200,
            'message' => 'Logout successful',
        ], 200);
    }

}   
    