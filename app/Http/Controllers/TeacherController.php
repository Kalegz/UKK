<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $subjects = Teacher::select('subject')->distinct()->pluck('subject');
        return view('teachers.index', compact('subjects'));
    }

    public function bySubject($subject)
    {
        $teachers = Teacher::where('subject', $subject)->with('user')->get();
        return view('teachers.bySubject', compact('teachers', 'subject'));
    }
}