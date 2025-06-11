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
        $treat = Treat::with(['user'=> function($q){
            $q->select('id','name');
        }])->get();
        return response()->json([
            "treats"=> $treat,
            'status'=>201
        ],201);
    }
    public function store(Request $request){
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
        $treat->user_id= Auth::user()->id;
        $treat->save();
        return response()->json([
            'message'=> $treat,
            'status'=> 201
        ],201);
    }
}