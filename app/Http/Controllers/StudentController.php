<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $classes = Student::select('class')->distinct()->pluck('class');
        return view('students.index', compact('classes'));
    }

    public function byClass($class)
    {
        $students = Student::where('class', $class)
            ->with(['user', 'pklAssignment.company', 'pklAssignment.teacher.user'])
            ->get();

        return view('students.byClass', compact('students', 'class'));
    }
}