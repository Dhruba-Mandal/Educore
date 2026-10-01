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
        Schema::create('courses', function (Blueprint $table) {

            $table->id();

            // Department
            $table->foreignId('department_id')
                  ->constrained('departments')
                  ->onDelete('cascade');

            // Course details
            $table->string('course_code')->unique();
            $table->string('course_name');
            $table->unsignedTinyInteger('duration_years');

            // Semester-wise subject IDs
            $table->json('semester_1')->nullable();
            $table->json('semester_2')->nullable();
            $table->json('semester_3')->nullable();
            $table->json('semester_4')->nullable();
            $table->json('semester_5')->nullable();
            $table->json('semester_6')->nullable();
            $table->json('semester_7')->nullable();
            $table->json('semester_8')->nullable();
            $table->json('semester_9')->nullable();
            $table->json('semester_10')->nullable();

            // Course status
            $table->boolean('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};