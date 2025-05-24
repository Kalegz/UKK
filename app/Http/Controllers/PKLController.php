<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyRequest;
use App\Models\PKL_Assignment;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PKLController extends Controller
{
    public function studentPkl()
    {
        $student = Auth::user()->student;
        $pklAssignment = $student->pklAssignment;
        $companies = Company::where('is_approved', true)->get();
        $teachers = Teacher::with('user')->get();
        return view('pkl.student', compact('student', 'pklAssignment', 'companies', 'teachers'));
    }

    public function storeCompanyRequest(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'nullable|string',
        ]);

        CompanyRequest::create([
            'name' => $request->company_name,
            'address' => $request->company_address,
            'student_id' => Auth::user()->student->id,
        ]);

        return redirect()->route('pkl.student')->with('success', 'Company request submitted.');
    }

    public function assignPkl(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $student = Auth::user()->student;
        $pklAssignment = $student->pklAssignment ?? new PKL_Assignment(['student_id' => $student->id]);

        $pklAssignment->fill([
            'company_id' => $request->company_id,
            'teacher_id' => $request->teacher_id,
            'teacher_approved' => false,
        ])->save();

        return redirect()->route('pkl.student')->with('success', 'PKL assignment submitted, awaiting teacher approval.');
    }

    public function teacherPkl()
    {
        $teacher = Auth::user()->teacher;
        $pklAssignments = $teacher->pklAssignment()->with('student.user', 'company')->get();
        return view('pkl.teacher', compact('teacher', 'pklAssignments'));
    }

    public function approvePkl(PKL_Assignment $pklAssignment)
    {
        if ($pklAssignment->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        $pklAssignment->update(['teacher_approved' => true]);
        return redirect()->route('pkl.teacher')->with('success', 'PKL assignment approved.');
    }
}