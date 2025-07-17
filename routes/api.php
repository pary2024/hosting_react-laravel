<?php

use App\Http\Controllers\AppointmentPatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DutyDoctorController;
use App\Http\Controllers\InvoicePatientController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PerPayController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TreatController;
use App\Http\Controllers\UserController;
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
            Route::get('/treat',[TreatController::class,'index']);
            Route::post('/treat', [TreatController::class,'store']);

            Route::get('/doctor', [DoctorController::class, 'index']);
            Route::post('/doctor', [DoctorController::class, 'store']);
            Route::delete('/doctor/{id}',[DoctorController::class,'destroy']);

            Route::get('/report', [ReportController::class, 'report']);

            Route::delete('/patient/{id}',[PatientController::class,'delete']);
        });
        Route::middleware('super admin')->group(function(){
          Route::get('/company',[CompanyController::class,'index']);
          Route::post('/company',[CompanyController::class,'store']);
          Route::delete('/company/{id}',[CompanyController::class,'delete']);

          Route::get('/user', [UserController::class, 'index']);
          Route::post('/user', [UserController::class, 'store']);
          Route::delete('/user/{id}', [UserController::class,'delete']);

                  //school
        // Route::get('/school',[SchoolController::class,'index']);
        // Route::post('/school', [SchoolController::class,'store']);

        // //sms
        // Route::get('/sms',[MessageController::class,'index']);
        // Route::post('/sms', [MessageController::class,'store']);

        //   //students
        // Route::get('/student',[StudentController::class,'index']);
        // Route::post('/student',[StudentController::class,'store']);

        //   //invoiceStudent
        // Route::get('/is',[InvoiceStudentController::class,'index']);
        // Route::post('/is',[InvoiceStudentController::class,'store']);

        //   //appt student 
        // Route::get('/appt/student',[AppointmentStudentController::class,'index']);
        // Route::post('/appt/student',[AppointmentStudentController::class,'store']);


      });

    // 👤 Regular user-only routes
        Route::middleware('user')->group(function () {
            ///province
            Route::get('/province',[ProvinceController::class,'index']);
            Route::post('/province', [ProvinceController::class,'store']);
            Route::delete('/province/{id}',[ProvinceController::class,'delete']);

            ///pays
            Route::get('/pay',[PerPayController::class,'index']);
            Route::post('/pay', [PerPayController::class,'store']);



        

            //patients
            Route::get('/patient',[PatientController::class,'index']);
            Route::post('/patient',[PatientController::class,'store']);
            


            //inviocePatient
            Route::get('/ip',[InvoicePatientController::class,'index']);
            Route::post('/ip',[InvoicePatientController::class,'store']);
            Route::get('/ip/{id}',[InvoicePatientController::class,'show']);
            Route::post('/ip/{id}',[ InvoicePatientController::class,'update']);

        

            //appt patient 
            Route::get('/appt/patient',[AppointmentPatientController::class,'index']);
            Route::post('/appt/patient',[AppointmentPatientController::class,'store']);

        

            //dutyDoctore
            Route::get('/duty', [DutyDoctorController::class, 'index']);
            Route::post('/duty', [DutyDoctorController::class, 'store']);
            Route::get('/duty/{id}',[ DutyDoctorController::class,'show']);
            Route::post('/duty/{id}',[ DutyDoctorController::class,'update']);

            //lab 
            Route::get('/lab',[LabController::class, 'index']);
            Route::post('/lab',[LabController::class, 'store']);

            //materail
            Route::get('/material',[MaterialController::class, 'index']);
            Route::post('/material',[MaterialController::class, 'store']);
            

            
            Route::get('/logout', [AuthController::class,'logout']); 
        });
    

});
