<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use finfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    //
    public function index(){
        $doctors = Doctor::with(['user'=> function($q){
            $q->select('id','name');
        }])->get()->map(function ($d) {
        if ($d->image) {
            $d->image = url('doctor/' . $d->image);
        } else {
            $d->image = null; 
        }
        return $d;
    });;
        
        return response()->json([
            "doctors"=> $doctors,
            "status"=> "success",
        ],201);
    }


   public function store(Request $request)
    {
       $validate = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'speciatly' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'image' => 'nullable',
            'status' => 'required|in:available,on leave',
       ]);
       if ($validate->fails()) {
        return response()->json([
            'status'=>422,
            'message'=> $validate->errors()->first(),
        ]);
       }

        $doctor = new Doctor();
        $doctor->name = $request->name;
        $doctor->user_id = Auth::user()->id; 
        $doctor->speciatly = $request->speciatly;
        $doctor->email = $request->email;
        $doctor->status = $request->status;

        
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $imageName = rand(111, 999999) . '.' . $file->getClientOriginalExtension();
            $imagePath = public_path('doctor');
            $file->move($imagePath, $imageName);
            $doctor->image =$imageName;
        }

        $doctor->save(); 

        return response()->json([
            'message' => 'Doctor created successfully',
            'doctor' => $doctor,
        ], 201);
    }
   public function destroy($id)
{
    $doctor = Doctor::find($id);

    if (!$doctor) {
        return response()->json([
            'message' => 'Doctor not found',
            'status' => 404
        ], 404);
    }

    if ($doctor->image && file_exists(public_path('doctor/' . $doctor->image))) {
        unlink(public_path('doctor/' . $doctor->image));
    }

    $doctor->delete();

    return response()->json([
        'message' => 'Delete doctor success',
        'status' => 201
    ], 201);
}

}