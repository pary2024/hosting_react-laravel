<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all()->map(function ($company) {
            // If using cloud storage URL
            $company->image = $company->image
                ? Storage::disk('s3')->url($company->image)
                : null;
            return $company;
        });

        return response()->json([
            'companies' => $companies
        ], 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validate->errors(),
            ], 422);
        }

        $company = new Company();
        $company->name = $request->name;
        $company->phone = $request->phone;
        $company->address = $request->address;
        $company->email = $request->email;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'company/' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Upload to cloud (S3)
            Storage::disk('s3')->put($imageName, file_get_contents($image));
            Storage::disk('s3')->setVisibility($imageName, 'public');

            $company->image = $imageName;
        }

        $company->save();

        return response()->json([
            'message' => 'Company created successfully',
            'company' => $company,
        ], 201);
    }

    public function delete($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        // Delete image from cloud
        if ($company->image) {
            Storage::disk('s3')->delete($company->image);
        }

        // Delete related users if relationship exists
        if (method_exists($company, 'users')) {
            $company->users()->delete();
        }

        $company->delete();

        return response()->json(['message' => 'Company and its users deleted successfully'], 200);
    }
}
