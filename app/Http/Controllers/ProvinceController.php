<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends Controller
{
    public function index(){
        $provinces = Province::with(['user'=>function($q){
            $q->select('id','name');
        }])->get();
        return response()->json([
            "provinces"=> $provinces,
            'status'=>201
        ],201);
    }
    public function store(Request $request){
        $validate = Validator::make($request->all(), [
            'name'=> 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message'=> $validate->errors()->first(),
            ],422);
        }
        $province = new Province();
        $province->name = $request->name;
        $province->user_id = Auth::user()->id;
        $province->save();
            return response()->json([
                'message'=> 'province created successfully',
                'status'=> 200
            ],200);
    }
}