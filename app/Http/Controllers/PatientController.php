<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
        public function index(){
            $patients = Patient::with([
                'user:id,name',
                'province:id,name',
                'treat:id,name'
            ])->orderBy('id', 'desc')->get();
            return response()->json([
                "patients"=> $patients
            ],201);
        }
        public function store(Request $request){
           $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'treat_id' => 'required|exists:treats,id',
            'age' => 'required|integer|min:0|max:150',
            'gender' => 'required|in:male,female,other', // adjust as needed
            'phone' => 'required|string|max:20', // or use regex for format
            'career' => 'nullable|string|max:255',
            'status' => 'required|in:active,recovered,chronic', // or boolean if appropriate
         ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }
        $patients = new Patient();
        $patients->name = $request->name;
        $patients->user_id = Auth::user()->id;
        $patients->province_id =  $request-> province_id;
        $patients->treat_id = $request->treat_id;
        $patients->gender = $request->gender;
        $patients->phone = $request->phone;
        $patients->status = $request->status;
        $patients->career = $request->career;
        $patients->age = $request->age;
        $patients->save();
        return response()->json([
            'patients'=> $patients
        ],201);
        }
        public function delete ($id){
            $patients = Patient::find($id);
            if (!$patients) {
                return response()->json([
                    'message' => 'Patient not found'
                ],404);
            }
            $patients-> delete();
            return response()->json([
                'message' => 'patient delete success'
            ],201);
            
            
        }
}