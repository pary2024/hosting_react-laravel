<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Student;
use App\Models\School;
use App\Models\Province;
use App\Models\Patient;
use App\Models\Treat;
use App\Models\PerPay;
use App\Models\AppointmentStudent;
use App\Models\AppointmentPatient;
use App\Models\Company;
use App\Models\InvoiceStudent;
use App\Models\InvoicePatient;
use App\Models\Message;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
            $superAdminRole =  Role::firstOrCreate(['name' => 'super admin']);
         
            

           $superCompany = Company::create([
                'name' => 'super Company',
                'phone'=> '0714877555',
                'address'=>'phnom penh',
                'email'=>'company@gmail.com'
                ]);
           
          

            $admin = User::create([
            'name' => 'super Admin',
            'email' => 'superAdmin@example.com',
            'password' => Hash::make('password'),
            'phone' => '012346789',
            'company_id' =>  $superCompany->id,
            'status' => 'active',
            ]);
            $admin -> assignRole($superAdminRole);
          
           
            // Create Users
          
     

        // Province
      

        // Student
       
        // Doctor
       
       
        // Patient
       

        // PerPay
       

        // AppointmentPatient
       

        // InvoicePatient
       
    }
}