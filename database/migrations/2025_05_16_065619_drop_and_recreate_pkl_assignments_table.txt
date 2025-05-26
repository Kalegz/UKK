<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        // Create the new pkl_assignments table
        Schema::create('pkl_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                  ->nullable()
                  ->constrained('students', 'fk_pkl_assignments_student')
                  ->onDelete('cascade')
                  ->index()
                  ->nullable();
            $table->foreignId('teacher_id')
                  ->nullable()
                  ->constrained('teachers', 'fk_pkl_assignments_teacher')
                  ->onDelete('cascade')
                  ->index()
                  ->nullable();
            $table->foreignId('company_id')
                  ->constrained('companies', 'fk_pkl_assignments_company')
                  ->onDelete('cascade')
                  ->index()
                  ->nullable();
            $table->string('role'); // 'student' or 'teacher' to indicate the role in the assignment
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Drop the newly created pkl_assignments table
        Schema::dropIfExists('pkl_assignments');
    }
};