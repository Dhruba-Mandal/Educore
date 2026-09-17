<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('department_subject', function (Blueprint $table) {

            $table->foreignId('subject_id')
                ->constrained('subjects', 'subject_id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('department_id')
                ->constrained('departments', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->primary([
                'subject_id',
                'department_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('department_subject');
    }
};