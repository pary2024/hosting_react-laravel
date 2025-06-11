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
use App\Models\InvoiceStudent;
use App\Models\InvoicePatient;
use App\Models\Message;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone' => '0123456789',
            'status' => 'active',
        ]);
        $admin->assignRole($adminRole);

        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'phone' => '0987654321',
            'status' => 'active',
        ]);
        $user->assignRole($userRole);

        // Province
      

        // Student
       
        // Doctor
       
       
        // Patient
       

        // PerPay
       

        // AppointmentPatient
       

        // InvoicePatient
       
    }
}