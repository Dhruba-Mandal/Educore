<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculties', function (Blueprint $table) {

            $table->id();

            $table->string('faculty_id', 20)->unique();

            $table->string('name');

            $table->unsignedBigInteger('department_id');

            $table->string('designation');

            $table->unsignedInteger('experience_years')->default(0);

            $table->string('email')->unique();

            $table->string('phone_no', 20)->nullable();

            $table->boolean('status')->default(true);

            $table->string('password');

            $table->timestamps();

            $table->unsignedBigInteger('created_by')->nullable();

            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};