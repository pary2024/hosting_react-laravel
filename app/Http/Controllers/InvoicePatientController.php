<?php

namespace App\Http\Controllers;

use App\Models\InvoicePatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InvoicePatientController extends Controller
{
    public function index(){
        $invoiceP = InvoicePatient::with([
            'user:id,name',
            'patient:id,name,phone',
            'treat:id,name',
            'pay:id,name'
        ])->get();
        return response()->json([
            'invoicePatients'=> $invoiceP
        ],201);
    }
    public function store(Request $request){
       $validate = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'treat_id' => 'required|exists:treats,id',
            'pay_id' => 'required', // change `payments` to correct table name if different
            'price'=>'required',
            'deposit'=>'required',
            'debt'=>'nullable',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:paid,unpaid,pending', // adjust values as needed
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }
        $invoiceP = new InvoicePatient();
        $invoiceP->user_id = Auth::user()->id;
        $invoiceP->patient_id = $request->patient_id;
        $invoiceP->status = $request->status;
        $invoiceP->treat_id = $request->treat_id;
        $invoiceP->pay_id = $request->pay_id;
        $invoiceP->total = $request->total;
        $invoiceP->price = $request->price;
        $invoiceP->deposit = $request->deposit;
        $invoiceP->debt = $request->debt;
        $invoiceP->save();
        return response()->json([
            'invoicePatient'=> $invoiceP
        ],201);
    }
}