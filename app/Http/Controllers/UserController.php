<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
   public function index()
{
    $users = User::with('roles')->get()->map(function ($user) {
        return [
            'id'       => $user->id,
            'name'     => $user->name,
            'email'    => $user->email,
            'phone'    => $user->phone,
            'status'   => $user->status,
            'role'     => $user->getRoleNames()->first(), // get first role name
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    });

    return response()->json([
        "users" => $users,
    ], 200);
}

   public function store(Request $request)
{
    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'phone'    => 'nullable|string|max:20',
        'role' => 'required|string|exists:roles,name',
        'status'   => 'nullable|in:active,inactive', // or adjust based on your app logic
    ]);

    $user = User::create([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'password' => Hash::make($validated['password']),
        'phone'    => $validated['phone'] ?? null,
        'status'   => $validated['status'] ?? 'active', // default to 'active' if not provided
    ]);
    $user->assignRole($validated['role']);
    $user->load('roles');
    return response()->json([
        'message' => 'User created successfully',
        'user'    => $user,
    ], 201);
}
public function delete ($id){
    
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'message'=> 'delete success',
        ],201);
}

}