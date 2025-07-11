<?php

namespace App\Http\Controllers;

use App\Models\AppointmentPatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppointmentPatientController extends Controller
{
    public function index()
{
    $user = Auth::user();

    $appointmentPatients = AppointmentPatient::with([
        'user:id,name',
        'patient:id,name',
        'doctor:id,name'
    ])
    ->where('company_id', $user->company_id) // 👈 Ensure data isolation per company
    ->get();

    return response()->json([
        'appointmentPatients' => $appointmentPatients
    ], 200); // 200 is the correct status for GET
}

    public function store(Request $request){
        $user = Auth::user();
        $validate = Validator::make($request->all(), [
                'patient_id' => 'required|exists:patients,id',
                'doctor_id' => 'required|exists:doctors,id',
                'date' => 'required|date',
                'time_in' => 'required|date_format:H:i',
                'time_out' => 'nullable|date_format:H:i|after:time_in',
                'status' => 'required|in:scheduled,pending,comfirmed'

            ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }
        $apptPatient  = new AppointmentPatient();
        $apptPatient->patient_id = $request->patient_id;
        $apptPatient->date = $request->date;
        $apptPatient->status = $request->status;
        $apptPatient->doctor_id = $request->doctor_id;
        $apptPatient->time_in = $request->time_in;
        $apptPatient->time_out = $request->time_out;
        $apptPatient->user_id = $user->id;
        $apptPatient->company_id = $user-> company_id;
        $apptPatient->save();
        return response()->json([
            'appointmentPatient'=> $apptPatient
        ],201);
    }
}