<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentProof;
use Illuminate\Http\Request;

/**
 * Module 7 — split-screen verification queue.
 * Admin compares uploaded screenshot vs bank record, then confirms.
 */
class PaymentVerificationController extends Controller
{
    public function index()
    {
        $proofs = PaymentProof::with('order')
            ->where('status', 'submitted')
            ->latest()->paginate(15);

        return view('admin.payments.index', compact('proofs'));
    }

    public function show(PaymentProof $proof)
    {
        $proof->load('order.items');
        return view('admin.payments.show', compact('proof'));
    }

    public function approve(Request $request, PaymentProof $proof)
    {
        $proof->update([
            'status' => 'approved',
            'reviewed_by' => $request->user()->id,
            'admin_note' => $request->input('note'),
        ]);

        // Stage 04: Paid -> unlock fulfillment (Financial Clearance rule)
        $proof->order->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);
        return redirect()->route('admin.payments.index')->with('success', 'Payment approved; order unlocked.');
    }

    public function reject(Request $request, PaymentProof $proof)
    {
        $proof->update([
            'status' => 'rejected',
            'reviewed_by' => $request->user()->id,
            'admin_note' => $request->input('note'),
        ]);

        $proof->order->update(['payment_status' => 'pending']);

        return redirect()->route('admin.payments.index')->with('success', 'Payment proof rejected.');
    }
}
