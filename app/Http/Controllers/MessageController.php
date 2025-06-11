<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index(){
        $sms = Message::with([
            'user:id,name',
            'patient:id,name'
        ])->get();
        return response()->json([
            "messages"=> $sms,
            
        ], 200);
    }
    public function store(Request $request){
       $validate = Validator::make($request->all(), [
        'patient_id' => 'required|exists:patients,id',
        'phone' => 'required|string|max:20',
        'note' => 'nullable|string|max:1000',
    ]);
    if($validate->fails()){
        return response()->json([
            'message'=> $validate->errors()->first(),
        ],422);
    }
    $sms = new Message();
    $sms->phone = $request->phone;
    $sms->note = $request->note;
    $sms->patient_id = $request->patient_id;
    $sms->user_id = Auth::user()->id;
    $sms ->save();
    return response()->json([
        'message'=> $sms,
        
    ],200);
    }
}