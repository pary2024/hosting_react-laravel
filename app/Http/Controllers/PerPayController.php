<?php

namespace App\Http\Controllers;

use App\Models\PerPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PerPayController extends Controller
{
    //
   public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $companyId = $user->company_id;

        $pays = PerPay::where('company_id', $companyId)->get();

        return response()->json([
            'pays' => $pays,
        ], 200); // ✅ 200 is correct for GET requests
    }

    public function store(Request $request){
        $user = Auth::user();
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
        $pay->user_id =$user->id;
        $pay->company_id=  $user-> company_id;
        $pay->save();
        return response()->json([
            'pays'=> $pay,
            'status'=> 201
            
        ],201);
    }
}