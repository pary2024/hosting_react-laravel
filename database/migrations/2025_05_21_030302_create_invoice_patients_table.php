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
        Schema::create('invoice_patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('treat_id')->constrained('treats')->cascadeOnDelete();
            $table->foreignId('pay_id')->constrained('per_pays')->cascadeOnDelete();
            $table->decimal("price");
            $table->decimal("deposit");
            $table->decimal('total',10,2)->nullable();
            $table->decimal("debt");
            $table->enum('status', ['paid','unpaid','pending'])->default('paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_patients');
    }
};