<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
   public function index()
{
    $companies = Company::all()->map(function ($company) {
        $company->image = $company->image
            ? url('company/' . $company->image)  // ឬប្រើ asset() ក៏បាន
            : null;
        return $company;
    });

    return response()->json([
        'companies' => $companies
    ], 200);
}
    public function store (Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name' => 'required',
            'phone'=>'required',
            'address'=>'required',
            'email'=>'required',
            'image'=>'nullable'
        ]);
        if ($validate-> fails()) {
            return response ()-> json([
                'message' => 'validation error',
            ], 422);
        }
        $company = new Company();
        $company->name = $request->name;
        $company-> phone = $request-> phone;
        $company-> address = $request-> address;
        $company-> email = $request-> email;
        
        if ($request->hasFile('image')){
            $image = $request-> image;
            $imageName= rand(111,999999) . '.' . $image-> getClientOriginalExtension();
            $imagePath = public_path('company');
            $image-> move($imagePath, $imageName);
            $company-> image = $imageName;
            
        }
        $company-> save();
        return response()->json([
            'message' => 'company created successfully',
        ],201);
    }
public function Delete($id)
{
    $company = Company::find($id);

    if (!$company) {
        return response()->json(['message' => 'Company not found'], 404);
    }
    if ($company->image !== null) {
        $imagePath = public_path('company/' . $company-> image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }    
    }

    
    $company->users()->delete();

    // Now delete the company
    $company->delete();

    return response()->json(['message' => 'Company and its users deleted successfully'], 200);
}


    
}