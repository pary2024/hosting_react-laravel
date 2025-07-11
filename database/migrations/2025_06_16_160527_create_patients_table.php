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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('province_id')->nullable()->constrained('provinces')->cascadeOnDelete();
            $table->integer("age")->nullable();
            $table->string("gender")->nullable();
            $table->integer('daily_number')->nullable();
            $table->string("phone")->nullable();
            $table->string("career")->nullable();
            $table->enum("status", ["active","recovered","chronic"])->default("active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};