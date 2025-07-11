<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LabController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $labs = Lab::with(['user:id,name'])->where('company_id', $user->company_id)->get();
        return response()->json([
            'labs'=>$labs
        ],201);
    }
    public function store(Request $request)
{
    $user = Auth::user();

    $validate = Validator::make($request->all(), [
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
        'qty'         => 'required|integer|min:1',
        'date'        => 'required|date',
    ]);

    if ($validate->fails()) {
        return response()->json([
            'errors' => $validate->errors()
        ], 422);
    }

    // Calculate amount and total
    $price  = $request->price;
    $qty    = $request->qty;
    $amount = $price * $qty;
    $total  = $amount; 

    $lab = Lab::create([
        'user_id'     => $user->id,
        'company_id'  => $user->company_id,
        'description' => $request->description,
        'price'       => $price,
        'qty'         => $qty,
        'amount'      => $amount,
        'total'       => $total,
        'date'        =>  $request->date
    ]);

    return response()->json([
        'message' => 'Data created successfully.',
        'data'    => $lab
    ], 201);
}
     
}