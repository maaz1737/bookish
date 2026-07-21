@extends('admin.layout')
@section('title', 'Bank Settings')

@section('content')
<div class="space-y-6 max-w-3xl">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" stroke="currentColor" stroke-width="1.8"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Bank & Store Settings</h1>
                <p class="text-xs text-gray-500 mt-0.5">Configure store bank transfer details and QR code image</p>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data"
          class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm space-y-5">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach ([
                'bank_name' => ['label' => 'Bank Name', 'ph' => 'e.g. Meezan Bank'],
                'account_title' => ['label' => 'Account Title', 'ph' => 'e.g. Bookish Store'],
                'bank_iban' => ['label' => 'IBAN Number', 'ph' => 'PK00MEZN0000123456789'],
                'bank_account_no' => ['label' => 'Account Number', 'ph' => '01020304050607'],
                'raast_id' => ['label' => 'Raast ID / Mobile', 'ph' => '03001234567']
            ] as $key => $field)
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-700">{{ $field['label'] }}</label>
                    <input name="{{ $key }}" value="{{ $settings[$key] ?? '' }}" placeholder="{{ $field['ph'] }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                </div>
            @endforeach
        </div>

        <div class="pt-4 border-t border-gray-100">
            <label class="block text-xs font-semibold text-gray-700 mb-2">QR Code Image</label>
            <div class="flex items-center gap-5">
                @if(!empty($settings['qr_image']))
                    <div class="h-24 w-24 rounded-xl border border-gray-200 bg-gray-50 p-1 flex-shrink-0 shadow-sm overflow-hidden">
                        <img src="{{ asset('storage/' . $settings['qr_image']) }}" alt="QR Code" class="w-full h-full object-contain rounded-lg">
                    </div>
                @endif
                <div class="flex-1">
                    <input type="file" name="qr_image" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer">
                    <p class="text-[11px] text-gray-400 mt-1">Upload QR Code image for quick payment transfers (PNG, JPG, WEBP)</p>
                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition shadow-md shadow-indigo-500/20 active:scale-95">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Bank Details
            </button>
        </div>
    </form>
</div>
@endsection