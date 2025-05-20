<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyRequest;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:student,teacher',
            'nis' => 'required_if:role,student|string|unique:students,nis',
            'class' => 'required_if:role,student|string',
            'major' => 'required_if:role,student|string',
            'subject' => 'required_if:role,teacher|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role === 'student') {
            Student::create([
                'user_id' => $user->id,
                'nis' => $request->nis,
                'class' => $request->class,
                'major' => $request->major,
            ]);
        } elseif ($request->role === 'teacher') {
            Teacher::create([
                'user_id' => $user->id,
                'subject' => $request->subject,
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    public function destroyUser(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.users')->with('error', 'Cannot delete admin user.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    public function companies()
    {
        $companyRequests = CompanyRequest::with('student.user')->get();
        $companies = Company::all();
        return view('admin.companies', compact('companyRequests', 'companies'));
    }

    public function approveCompany(CompanyRequest $companyRequest)
    {
        $company = Company::create([
            'name' => $companyRequest->name,
            'address' => $companyRequest->address,
            'is_approved' => true,
        ]);

        $companyRequest->update(['is_approved' => true]);
        return redirect()->route('admin.companies')->with('success', 'Company approved.');
    }
}