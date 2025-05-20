<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::where('is_approved', true)->get();
        return view('companies.index', compact('companies'));
    }

    public function show(Company $company)
    {
        $PKL_Assignment = $company->PKL_Assignment()->with('student.user', 'teacher.user')->get();
        return view('companies.show', compact('company', 'PKL_Assignment'));
    }
}