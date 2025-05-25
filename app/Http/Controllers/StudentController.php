<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Fetch distinct class and major combinations
        $classes = Student::select('class', 'major')
            ->distinct()
            ->get()
            ->map(function ($item) {
                return [
                    'class' => $item->class,
                    'major' => $item->major,
                ];
            })->toArray();
        
        return view('students.index', compact('classes'));
    }

    public function byClass($class, $major)
    {
        // Fetch students filtered by class and major
        $students = Student::where('class', $class)
            ->where('major', $major)
            ->with(['user', 'pklAssignment.company', 'pklAssignment.teacher.user'])
            ->get();

        return view('students.byClass', compact('students', 'class', 'major'));
    }
}