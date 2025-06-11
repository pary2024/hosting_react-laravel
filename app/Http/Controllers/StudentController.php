<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        $students = Student::with([
            'user:id,name',
            'school:id,name'
        ])->get();
        return response()->json([
            "students"=> $students
        ],201);
    }
    public function store(Request $request){
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'school_id' => 'required|exists:schools,id',
            'age' => 'required|integer|min:1',
            'birth_day' => 'required|date',
            'gender' => 'required|in:male,female,other', // adjust as needed
            'grade' => 'required|string|max:50',
            'parents' => 'required|string|max:255',
            'status' => 'required|in:active,inactive', // or boolean or other statuses
    ]);

    if ($validate->fails()) {
    return response()->json(['errors' => $validate->errors()], 422);
    }
    $students = new Student();
    $students->name = $request->name;
    $students->school_id= $request->school_id;
    $students->user_id = Auth::user()->id;
    $students->gender = $request->gender;
    $students->age = $request->age;
    $students->status = $request->status;
    $students->parents = $request->parents;
    $students->grade = $request->grade;
    $students->save();
    return response()->json([
            'students'=> $students
    ],201);
    
    
    
    }
}