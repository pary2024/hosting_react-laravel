<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
        public function index()
    {
        $user = Auth::user();
    
        $doctors = Doctor::with(['user:id,name'])
            ->where('company_id', $user->company_id)
            ->get()
            ->map(function ($d) {
                $d->image = $d->image ? Storage::url($d->image) : null;
                return $d;
            });
    
        return response()->json([
            "doctors" => $doctors,
            "status" => "success",
        ], 200);
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'speciatly' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:available,on leave',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validate->errors()->first(),
            ], 422);
        }

        $doctor = new Doctor();
        $doctor->name = $request->name;
        $doctor->user_id = $user->id;
        $doctor->company_id = $user->company_id;
        $doctor->speciatly = $request->speciatly;
        $doctor->email = $request->email;
        $doctor->status = $request->status;

        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $imageName = 'doctor/' . uniqid() . '.' . $file->getClientOriginalExtension();
        
                Storage::disk('s3')->put($imageName, file_get_contents($file));
                Storage::disk('s3')->setVisibility($imageName, 'public');
        
                $doctor->image = $imageName;
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage());
                return response()->json([
                    'message' => 'Image upload failed',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

        $doctor->save();

        return response()->json([
            'message' => 'Doctor created successfully',
            'doctor' => $doctor,
        ], 201);
    }

    public function destroy($id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json([
                'message' => 'Doctor not found',
                'status' => 404
            ], 404);
        }

        // Delete image from S3
        if ($doctor->image && Storage::disk('s3')->exists($doctor->image)) {
            Storage::disk('s3')->delete($doctor->image);
        }

        $doctor->delete();

        return response()->json([
            'message' => 'Delete doctor success',
            'status' => 200
        ], 200);
    }
}
