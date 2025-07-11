<?php

namespace App\Http\Controllers;

use App\Models\DutyDoctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DutyDoctorController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $dutyDoctors = DutyDoctor::with([
            'doctor:id,name',  // assuming doctor has a relation to user (name)
            'patient:id,name',
            'treat:id,name',
        ])->where('company_id', $user->company_id)->get();
        return response()->json([
            'dutyDoctors' => $dutyDoctors
        ], 200); // 200 is OK, 201 is usually for create
    }
    public function store(Request $request)
{
    $user = Auth::user();

    $validate = Validator::make($request->all(), [
        'doctor_id'   => 'required|exists:doctors,id',
        'patient_id'  => 'required|exists:patients,id',
        'treat_id'    => 'required|exists:treats,id',
        'status'      => 'required',
        'note'        => 'required'
    ]);

    if ($validate->fails()) {
        return response()->json([
            'errors' => $validate->errors()
        ], 422);
    }

    $dutyDoctor = DutyDoctor::create([
        'doctor_id'   => $request->doctor_id,
        'patient_id'  => $request->patient_id,
        'treat_id'    => $request->treat_id,
        'user_id'     => $user->id,
        'company_id'  => $user->company_id,
        'status'      =>$request-> status,
        'note'        => $request->note
    ]);

    return response()->json([
        'message' => 'Duty doctor record created successfully.',
        'data'    => $dutyDoctor
    ], 201);
}
 public function show($id)
{
    $user = Auth::user();

    $dutyDoctor = DutyDoctor::with( 'doctor:id,name',  // assuming doctor has a relation to user (name)
            'patient:id,name',
            'treat:id,name',)->where('id', $id)
        ->where('company_id', $user->company_id)
        ->first();

    if (!$dutyDoctor) {
        return response()->json([
            'message' => 'Duty doctor record not found.'
        ], 404);
    }

    return response()->json([
        'dutyDoctor' => $dutyDoctor
    ]);
}


    public function update(Request $request, $id)
{
    $user = Auth::user();
    $dutyDoctor = DutyDoctor::find($id);

    if (!$dutyDoctor) {
        return response()->json([
            'message' => 'Duty doctor record not found.'
        ], 500);
    }

    // Validate the request
    $validate = Validator::make($request->all(), [
        'doctor_id'  => 'nullable', // Optional, used only if provided
        'patient_id' => 'nullable', // Optional, used only if provided
        'treat_id'   => 'nullable',
        'status'     => 'required',
        'note'       => 'required'
    ]);

    if ($validate->fails()) {
        return response()->json([
            'errors' => $validate->errors()
        ], 422);
    }

    // Only update doctor_id and patient_id if present in request
    if ($request->has('doctor_id') && $request->doctor_id !== null) {
        $dutyDoctor->doctor_id = $request->doctor_id;
    }

    if ($request->has('patient_id') && $request->patient_id !== null) {
        $dutyDoctor->patient_id = $request->patient_id;
    }

    if ($request->has('treat_id')) {
        $dutyDoctor->treat_id = $request->treat_id;
    }

    $dutyDoctor->status     = $request->status;
    $dutyDoctor->note       = $request->note;
    $dutyDoctor->company_id = $user->company_id;
    $dutyDoctor->user_id    = $user->id;

    $dutyDoctor->save();

    return response()->json([
        'message' => 'Duty doctor record updated successfully.',
        'data'    => $dutyDoctor
    ], 201);
}


}