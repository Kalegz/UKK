<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nis' => 'required_if:role,student|string|unique:students,nis,' . ($user->student ? $user->student->id : 0),
            'class' => 'required_if:role,student|string',
            'major' => 'required_if:role,student|string',
            'subject' => 'required_if:role,teacher|string',
        ]);

        $user->update(['name' => $request->name]);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->update(['profile_photo' => $path]);
        }

        if ($user->isStudent()) {
            $student = $user->student ?? new Student(['user_id' => $user->id]);
            $student->fill($request->only(['nis', 'class', 'major']))->save();
        } elseif ($user->isTeacher()) {
            $teacher = $user->teacher ?? new Teacher(['user_id' => $user->id]);
            $teacher->fill($request->only(['subject']))->save();
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}