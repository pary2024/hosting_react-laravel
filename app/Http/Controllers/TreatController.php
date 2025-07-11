<?php

namespace App\Http\Controllers;

use App\Models\Treat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TreatController extends Controller
{
    //
    public function index(){
    $user = Auth::user();
    $treat = Treat::with(['user' => function($q){
        $q->select('id', 'name');
    }])
    ->where('company_id', $user->company_id)  // filter by company
    ->get();

    return response()->json([
        "treats" => $treat,
        'status' => 200
    ], 200);
}

    public function store(Request $request){
        $user = Auth::user();
        $validate = Validator::make($request->all(), [
            'name'=> 'required',
        ]);
        if($validate->fails()){
            return response()->json([
                'message'=> $validate->errors()->first(),
            ]);
        }
        $treat = new Treat();
        $treat->name = $request->name;
        $treat->user_id= $user->id;
        $treat-> company_id = $user-> company_id;
        $treat->save();
        return response()->json([
            'message'=> $treat,
            'status'=> 201
        ],201);
    }
}