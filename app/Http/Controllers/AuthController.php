<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
public function login(Request $request)
{
    // Step 1: Validate the request
    $validate = Validator::make($request->all(), [
        'email'    => 'required|email',
        'password' => 'required|string',
        'company'  => 'required|string|exists:companies,name',
    ]);

    if ($validate->fails()) {
        return response()->json([
            'success' => false,
            'errors'  => $validate->errors(),
        ], 422);
    }

    // Step 2: Extract credentials from request
    $credentials = $request->only(['email', 'password', 'company']);

    // Step 3: Resolve company_id from name
    $company = Company::where('name', $credentials['company'])->first();

    // Step 4: Now lookup user by email and resolved company_id
    $user = User::where('email', $credentials['email'])
                ->where('company_id', $company->id)
                ->first();

    // Step 5: Check password
    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials or company mismatch.',
        ], 401);
    }

    // Step 6: Create token and return data
    $token = $user->createToken('Bearer Token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Login successful.',
        'token'   => $token,
        'user'    => $user,
        'company'=>  $company,
        'roles'   => $user->getRoleNames(),
    ], 200);
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
    