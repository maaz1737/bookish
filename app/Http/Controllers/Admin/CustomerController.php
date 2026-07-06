<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')->latest()->paginate(20);

        return view('admin.customers', compact('customers'));
    }

    public function toggleBlock(User $customer)
    {
        $customer->update(['is_blocked' => ! $customer->is_blocked]);
        return back()->with('success', $customer->is_blocked ? 'Customer blocked.' : 'Customer unblocked.');
    }
}
