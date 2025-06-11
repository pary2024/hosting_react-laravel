<?php

use App\Http\Controllers\AppointmentPatientController;
use App\Http\Controllers\AppointmentStudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\InvoicePatientController;
use App\Http\Controllers\InvoiceStudentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PerPayController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TreatController;
use App\Http\Controllers\UserController;
use App\Models\AppointmentPatient;
use App\Models\AppointmentStudent;
use App\Models\InvoicePatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',[AuthController::class,'login']);
// ✅ Group all authenticated routes with sanctum
Route::middleware('auth:sanctum')->group(function () {

    // 🛡️ Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::get('/user', [UserController::class, 'index']);
        Route::post('/user', [UserController::class, 'store']);
        Route::delete('/user/{id}', [UserController::class,'delete']);
    });

    // 👤 Regular user-only routes
    Route::middleware('user')->group(function () {
        Route::get('/doctor', [DoctorController::class, 'index']);
        Route::post('/doctor', [DoctorController::class, 'store']);
        Route::delete('/doctor/{id}',[DoctorController::class,'destroy']);

        ///province
        Route::get('/province',[ProvinceController::class,'index']);
        Route::post('/province', [ProvinceController::class,'store']);

        ///pays
        Route::get('/pay',[PerPayController::class,'index']);
        Route::post('/pay', [PerPayController::class,'store']);


        //treat
        Route::get('/treat',[TreatController::class,'index']);
        Route::post('/treat', [TreatController::class,'store']);

        //school
        Route::get('/school',[SchoolController::class,'index']);
        Route::post('/school', [SchoolController::class,'store']);

        //sms
        Route::get('/sms',[MessageController::class,'index']);
        Route::post('/sms', [MessageController::class,'store']);

        //students
        Route::get('/student',[StudentController::class,'index']);
        Route::post('/student',[StudentController::class,'store']);

        //patients
        Route::get('/patient',[PatientController::class,'index']);
        Route::post('/patient',[PatientController::class,'store']);
        Route::delete('/patient/{id}',[PatientController::class,'delete']);


        //inviocePatient
        Route::get('/ip',[InvoicePatientController::class,'index']);
        Route::post('/ip',[InvoicePatientController::class,'store']);

        //invoiceStudent
        Route::get('/is',[InvoiceStudentController::class,'index']);
        Route::post('/is',[InvoiceStudentController::class,'store']);


        //appt patient 
        Route::get('/appt/patient',[AppointmentPatientController::class,'index']);
        Route::post('/appt/patient',[AppointmentPatientController::class,'store']);

        //appt student 
        Route::get('/appt/student',[AppointmentStudentController::class,'index']);
        Route::post('/appt/student',[AppointmentStudentController::class,'store']);
       

        
    });

});