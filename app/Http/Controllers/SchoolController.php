<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    //
   public function index()
{
    $schools = School::with([
        'user:id,name',
        'province:id,name',
    ])->get()->map(function ($school) {
        if ($school->image) {
            $school->image = url('school/' . $school->image);
        } else {
            $school->image = null; // Or a default image URL if needed
        }
        return $school;
    });

    return response()->json([
        'schools' => $schools,
        'status' => 201
    ], 201);
}
    public function store(Request $request){
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'tabLine' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
       ]);
       if($validate->fails()){
        return response()->json([
            'message'=> $validate->errors()->first(),
        ],422);
       }
       $school = new School();
       $school->name = $request->name;
       $school->user_id = Auth::user()->id;
       $school->province_id = $request->province_id;
       $school->tabLine = $request->tabLine;
       $school->location = $request->location;
       if ($request->hasFile('image')){
        $image = $request->file('image');
        $schoolName = rand(11,99999) .'.'. $image->getClientOriginalExtension();
        $schoolPath = public_path('school');
        $image->move($schoolPath, $schoolName);
        $school->image = $schoolName;
       }
       $school->save();
       return response()->json([
        'message'=> ' School created successfully',
       ],200);
    }
}