<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guard = "user";
    protected $table = "users";
    
     protected $fillable = [
        'name',
        'email',
        'company_id',
        'password',
        'phone',
        'status',
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function doctors() { return $this->hasMany(Doctor::class); }
    public function students() { return $this->hasMany(Student::class); }
    public function patients() { return $this->hasMany(Patient::class); }
    public function provinces() { return $this->hasMany(Province::class); }
    public function schools() { return $this->hasMany(School::class); }
    public function perPays() { return $this->hasMany(PerPay::class); }
    public function treats() { return $this->hasMany(Treat::class); }
    public function appointmentStudents() { return $this->hasMany(AppointmentStudent::class); }
    public function appointmentPatients() { return $this->hasMany(AppointmentPatient::class); }
    public function invoiceStudents() { return $this->hasMany(InvoiceStudent::class); }
    public function invoicePatients() { return $this->hasMany(InvoicePatient::class); }
    public function messages() { return $this->hasMany(Message::class); }
    public function company(){
        return $this -> belongsTo(Company::class,'company_id');
    }
}