<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !auth()->user()->hasRole('Admin')) {
            abort(403, 'Unauthorized Access');
        }    
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('admin.admin-manage-users', compact('users', 'roles'));
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles($request->role);

        return redirect()->back()->with('success', 'Role berhasil diperbarui!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        $user->syncRoles([$request->input('role')]);

        return redirect()->back()->with('success', 'User details updated successfully!');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User successfully deleted.');
    }
}
