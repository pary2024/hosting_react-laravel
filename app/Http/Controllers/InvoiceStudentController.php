<?php

namespace App\Http\Controllers;

use App\Models\InvoiceStudent;
use Carbon\Cli\Invoker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InvoiceStudentController extends Controller
{
   public function index()
{
    $user = Auth::user();

    $invoiceS = InvoiceStudent::with([
        'user:id,name',
        'student:id,name',
        'treat:id,name',
        'pay:id,name'
    ])
    ->where('company_id', $user->company_id) 
    ->get();

    return response()->json([
        'invoiceStudent' => $invoiceS
    ], 200); 
}

    public function store(Request $request){
        $user = Auth::user();
       $validate = Validator::make($request->all(), [
        'student_id' => 'required|exists:students,id',
        'treat_id' => 'required|exists:treats,id',
        'pay_id' => 'required|exists:payments,id', // adjust if "payments" table is named differently
        'total' => 'required|numeric|min:0',
        'status' => 'required|in:paid,unpaid,pending', // or boolean/integer if using 0/1
    ]);

    if ($validate->fails()) {
        return response()->json(['errors' => $validate->errors()], 422);
    }
        $invoiceS = new InvoiceStudent();
        $invoiceS->user_id = $user->id;
        $invoiceS->company_id = $user-> company_id;
        $invoiceS ->student_id = $request->student_id;
        $invoiceS->treat_id = $request->treat_id;
        $invoiceS->status = $request->status;
        $invoiceS->total = $request->total;
        $invoiceS ->pay_id = $request->pay_id;
        $invoiceS->save();
        return response()->json([
            'invoiceStudent'=> $invoiceS
        ],201);
        
        
    
    }
}