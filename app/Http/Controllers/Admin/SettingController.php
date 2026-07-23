<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Store bank details + system thresholds (Super Admin only).
 */
class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings', [
            'settings' => [
                'bank_name' => Setting::get('bank_name'),
                'account_title' => Setting::get('account_title', 'Bookish Store'),
                'bank_iban' => Setting::get('bank_iban'),
                'bank_account_no' => Setting::get('bank_account_no'),
                'raast_id' => Setting::get('raast_id'),
                'qr_image' => Setting::get('qr_image'),
                'qr_bank_name' => Setting::get('qr_bank_name'),
                'qr_account_title' => Setting::get('qr_account_title')
            ],
        ]);
    }

    public function update(Request $request)
    {
        $formType = $request->input('form_type');

        if ($formType === 'bank') {

            $data = $request->validate([
                'bank_name' => ['nullable', 'string', 'max:255'],
                'account_title' => ['nullable', 'string', 'max:255'],
                'bank_iban' => ['nullable', 'string', 'max:50'],
                'bank_account_no' => ['nullable', 'string', 'max:50'],
                'raast_id' => ['nullable', 'string', 'max:50'],
            ]);

            foreach ($data as $key => $value) {
                Setting::put($key, $value);
            }

            return back()->with('success', 'Bank details updated successfully.');
        }

        if ($formType === 'qr') {

            $data = $request->validate([
                'qr_bank_name' => ['nullable', 'string', 'max:255'],
                'qr_account_title' => ['nullable', 'string', 'max:255'],
                'qr_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ]);

            // Remove QR Image
            if ($request->filled('remove_qr_image')) {

                if ($oldImage = Setting::get('qr_image')) {
                    Storage::disk('public')->delete($oldImage);
                }

                Setting::put('qr_image', null);

                return back()->with('success', 'QR code removed successfully.');
            }
            // Save text fields
            foreach (['qr_bank_name', 'qr_account_title'] as $field) {
                Setting::put($field, $request->$field);
            }

            // Upload new image
            if ($request->hasFile('qr_image')) {

                if ($oldImage = Setting::get('qr_image')) {
                    Storage::disk('public')->delete($oldImage);
                }

                $path = $request->file('qr_image')->store('settings', 'public');

                Setting::put('qr_image', $path);
            }

            return back()->with('success', 'QR details updated successfully.');
        }

        return back()->with('error', 'Invalid request.');
    }
}
