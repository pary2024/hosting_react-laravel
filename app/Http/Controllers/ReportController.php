<?php

namespace App\Http\Controllers;

use App\Models\AppointmentPatient;
use App\Models\Company;
use App\Models\InvoicePatient;
use App\Models\Lab;
use App\Models\Material;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function report()
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $companyId = $user->company_id;

    $data = [
        'invoices'  => InvoicePatient::where('company_id', $companyId)->get(),
        'labs'      => Lab::where('company_id', $companyId)->get(),
        'materials' => Material::where('company_id', $companyId)->get(),
    ];

    return response()->json($data, 200);
}

}