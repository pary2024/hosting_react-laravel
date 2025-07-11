<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
        public function index() {
    $user = Auth::user();

    $patients = Patient::with([
            'user:id,name',
            'province:id,name',
            
        ])
        ->where('company_id', $user->company_id) 
        ->get();

    return response()->json([
        "patients" => $patients
    ], 200); 
}

       public function store(Request $request){
                $user = Auth::user();

                $validate = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'province_id' => 'required|exists:provinces,id',
                    'age' => 'nullable|integer|min:0|max:150',
                    'gender' => 'required|in:male,female,other',
                    'phone' => 'required|string|max:20',
                    'career' => 'nullable|string|max:255',
                    'status' => 'required|in:active,recovered,chronic',
                ]);

                if ($validate->fails()) {
                    return response()->json(['errors' => $validate->errors()], 422);
                }

                // Calculate daily number
                $today = now()->startOfDay();
                $countToday = Patient::whereDate('created_at', $today)->count();
                $dailyNumber = $countToday + 1;

                $patient = new Patient();
                $patient->name = $request->name;
                $patient->user_id = $user->id;
                $patient->company_id = $user->company_id;
                $patient->province_id = $request->province_id;
                $patient->gender = $request->gender;
                $patient->phone = $request->phone;
                $patient->status = $request->status;
                $patient->career = $request->career;
                $patient->age = $request->age;
                $patient->daily_number = $dailyNumber;
                $patient->save();

                return response()->json([
                    'patients' => $patient
                ], 201);
            }

}