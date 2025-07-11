<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $materails = Material::with(['user:id,name', 'company:id,name'])->where('company_id', $user->company_id)->get();
        return response()->json([
            'materials'=>$materails
        ],201);
    }
 public function store(Request $request)
{
    $user = Auth::user();

    // Validate single material input
    $request->validate([
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
        'qty'         => 'required|integer|min:1',
        'date'        =>  'required'
        
    ]);

    $price  = $request->price;
    $qty    = $request->qty;
    $amount = $price * $qty;

    // For a single item, total = amount
   $total = $amount;


    $material = Material::create([
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
        'message' => 'Material saved successfully.',
        'data'    => $material,
        'total'   => number_format($total, 2),
    ]);
}


}