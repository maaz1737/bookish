<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Module 11 — Admin User Management (Super Admin only).
 * Create admins, adjust roles, revoke access.
 */
class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::whereIn('role', ['admin', 'super_admin'])->latest()->get();
        return view('admin.admin-users', compact('admins'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'mobile'   => ['required', 'string', 'max:50', 'unique:users,mobile'],
            'email'    => ['nullable', 'email', 'unique:users,email'],
            'role'     => ['required', Rule::in(['admin', 'super_admin'])],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create($data); // password auto-hashed by the cast
        return back()->with('success', 'Admin account created.');
    }

    public function updateRole(Request $request, User $admin)
    {
        $admin->update($request->validate([
            'role' => ['required', Rule::in(['admin', 'super_admin'])],
        ]));
        return back()->with('success', 'Role updated.');
    }

    public function revoke(User $admin)
    {
        $admin->tokens()->delete();
        $admin->update(['is_blocked' => true]);
        return back()->with('success', 'Admin access revoked.');
    }
}
