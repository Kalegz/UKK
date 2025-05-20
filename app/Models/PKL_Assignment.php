<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PKL_Assignment extends Model
{
    protected $table = 'pkl_assignments';
    
    protected $fillable = ['student_id', 'company_id', 'teacher_id', 'teacher_approved'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    
    public function teacherPkl()
    {
        $teacher = Auth::user()->teacher;
        $pklAssignments = $teacher->pklAssignments()->with('student.user', 'company')->get();
        return view('pkl.teacher', compact('teacher', 'pklAssignments'));
    }
}