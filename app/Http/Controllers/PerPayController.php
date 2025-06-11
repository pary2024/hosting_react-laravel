<?php

namespace App\Http\Controllers;

use App\Models\PerPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PerPayController extends Controller
{
    //
    public function index(){
        $pays = PerPay::all();
        return response()->json([
            "pays"=> $pays,
            'status'=>201
        ],201);
    }
    public function store(Request $request){
        $validate = Validator::make($request->all(),[
            'name'=> 'required',
        ]);
        if($validate->fails()){
            return response()->json([
                'message'=> $validate->errors()->first(),
            ]);
        }
        $pay = new PerPay();
        $pay->name = $request->name;
        $pay->user_id = Auth::user()->id;
        $pay->save();
        return response()->json([
            'pays'=> $pay,
            'status'=> 201
            
        ],201);
    }
}