<?php

namespace App\Http\Controllers;

use App\Models\AppointmentStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppointmentStudentController extends Controller
{
     public function index(){
        $appointmentStudent = AppointmentStudent::with([
            'user:id,name',
            'student:id,name',
            'doctor:id,name'
        ])->get();
        return response()->json([
            'appointmentStudents'=> $appointmentStudent
        ],201);
    }
    public function store(Request $request){
       $validate = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i|after:time_in',
            'status' => 'required|in:scheduled,comfirmed,pending', // adjust as needed
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }
        $apptStudent  = new AppointmentStudent();
        $apptStudent->student_id = $request->student_id;
        $apptStudent->date = $request->date;
        $apptStudent->status = $request->status;
        $apptStudent->doctor_id = $request->doctor_id;
        $apptStudent->time_in = $request->time_in;
        $apptStudent->time_out = $request->time_out;
        $apptStudent->user_id = Auth::user()->id;
        $apptStudent->save();
        return response()->json([
            'appointmentStudent'=> $apptStudent
        ],201);
    }
}