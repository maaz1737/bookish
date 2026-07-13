<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

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
            ],
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'bank_name' => ['nullable', 'string', 'max:255'],
            'account_title' => ['nullable', 'string', 'max:255'],
            'bank_iban' => ['nullable', 'string', 'max:50'],
            'bank_account_no' => ['nullable', 'string', 'max:50'],
            'raast_id' => ['nullable', 'string', 'max:50'],
            'qr_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        foreach ($data as $key => $value) {
            Setting::put($key, $value);
        }

        if ($request->hasFile('qr_image')) {

            // Delete old image (optional)
            if ($oldImage = Setting::get('qr_image')) {
                \Storage::disk('public')->delete($oldImage);
            }

            $path = $request->file('qr_image')->store('settings', 'public');

            Setting::put('qr_image', $path);
        }

        return back()->with('success', 'Bank details updated.');
    }
}
