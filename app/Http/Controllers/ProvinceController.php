<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends Controller
{
    public function index() {
    $user = Auth::user();

    $provinces = Province::with([
        'user:id,name'
    ])
    ->where('company_id', $user->company_id) // 🔒 Filter by company
    ->get();

    return response()->json([
        "provinces" => $provinces,
        "status" => 200
    ], 200); // ✅ 200 is correct status for successful GET
}

    public function store(Request $request){
        $user = Auth::user();
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
        $province->user_id = $user->id;
        $province->company_id = $user-> company_id;
        $province->save();
            return response()->json([
                'message'=> 'province created successfully',
                'status'=> 200
            ],200);
    }
    public function delete ($id){
        $province = Province::find($id);
        if (!$province) {
            return response()-> json([
                'message'=> 'province not found',
        
            ],404);
        }
        $province->delete();
        return response()->json([
            'message'=> 'province deleted successfully',
        ],201);
    }
}