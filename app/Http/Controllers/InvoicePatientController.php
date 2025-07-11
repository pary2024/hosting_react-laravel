<?php

namespace App\Http\Controllers;

use App\Models\InvoicePatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InvoicePatientController extends Controller
{
    public function index()
{
    $user = Auth::user();

    $invoiceP = InvoicePatient::with([
        'user:id,name',
        'patient:id,name,phone',
        'pay:id,name',
        'doctor:id,name',
        'company:id,name,phone,address,email'
    ])
    ->where('company_id', $user->company_id)
    ->get();

    return response()->json([
        'invoicePatients' => $invoiceP
    ], 200); 
}
    public function store(Request $request){
        $user = Auth::user();
       $validate = Validator::make($request->all(), [
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'pay_id' => 'required', // change `payments` to correct table name if different
            'price'=>'required',
            'deposit'=>'required',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:paid,unpaid,pending', // adjust values as needed
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }
         $debt = $request->total - $request->deposit;
        if ($debt < 0) {
            return response()->json(['error' => 'Deposit cannot be greater than total.'], 422);
        }
        $invoiceP = new InvoicePatient();
        $invoiceP->user_id = $user->id;
        $invoiceP->company_id = $user->company_id;
        $invoiceP->patient_id = $request->patient_id;
        $invoiceP->doctor_id = $request-> doctor_id;
        $invoiceP->status = $request->status;
        $invoiceP->pay_id = $request->pay_id;
        $invoiceP->total = $request->total;
        $invoiceP->price = $request->price;
        $invoiceP->deposit = $request->deposit;
        $invoiceP->debt = $debt;
        $invoiceP->save();
        return response()->json([
            'invoicePatient'=> $invoiceP
        ],201);
    }
    public function show($id){
        $user = Auth::user();
        $invoiceP = InvoicePatient::with('patient:id,name,phone',
        'pay:id,name',
        'doctor:id,name',)->where('id',$id)->where('company_id',$user->company_id)->first();
        return response()-> json([
            'invoicePatient' => $invoiceP
            
        ],200);
    
    }
    public function update(Request $request, $id){
        $user = Auth::user();
        $invoiceP = InvoicePatient::find($id);
        $validate = Validator::make($request->all(), [
            'patient_id' => 'nullable',
            'doctor_id' => 'nullable',
            'pay_id' => 'nullable', 
            'price'=>'required',
            'deposit'=>'required',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:paid,unpaid,pending',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }
         $debt = $request->total - $request->deposit;
        if ($debt < 0) {
            return response()->json(['error' => 'Deposit cannot be greater than total.'], 422);
        }
        try{
            if ($request->has('doctor_id')&& $request->doctor_id !==null){
                $invoiceP->doctor_id = $request-> doctor_id;
            }
            if ($request->has('patient_id')&& $request->patient_id !==null){
                $invoiceP->patient_id = $request->patient_id;
                
            }
            if ($request->has('pay_id')&& $request->pay_id !==null){
                $invoiceP->pay_id = $request->pay_id;
                
            }
            $invoiceP->user_id = $user->id;
            $invoiceP->company_id = $user->company_id;
            $invoiceP->status = $request->status;
            $invoiceP->total = $request->total;
            $invoiceP->price = $request->price;
            $invoiceP->deposit = $request->deposit;
            $invoiceP->debt = $debt;
            $invoiceP->save();
            return response()->json([
                'invoicePatient'=> $invoiceP   
            ],201);
        }catch(\Exception $e){
            return response()->json([
                'error'=>$e->getMessage()  
            ],500); 
        }   
        
    }
}