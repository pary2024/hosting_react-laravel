<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('duty_doctors', function (Blueprint $table) {
           $table->id();
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('treat_id')->constrained('treats');
            $table->enum('status',['in progress','complete']);
            $table->text('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duty_doctors');
    }
};