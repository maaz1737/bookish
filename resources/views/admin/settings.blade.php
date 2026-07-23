@extends('admin.layout')
@section('title', 'Bank Settings')

@section('content')

<h1 class="text-2xl font-bold mb-6">Store Bank Details</h1>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

    <!-- ================= BANK DETAILS ================= -->
    <form method="POST"
        action="{{ route('admin.settings.update') }}"
        class="bg-white p-4 sm:p-6 rounded-lg shadow space-y-4">

        @csrf
        @method('PUT')

        <input type="hidden" name="form_type" value="bank">

        @foreach ([
            'bank_name' => 'Bank Name',
            'account_title' => 'Account Title',
            'bank_iban' => 'IBAN',
            'bank_account_no' => 'Account Number',
            'raast_id' => 'Raast ID'
        ] as $key => $label)

            <label class="block">
                <span class="text-sm font-medium">{{ $label }}</span>

                <input
                    type="text"
                    name="{{ $key }}"
                    value="{{ $settings[$key] ?? '' }}"
                    class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </label>

        @endforeach

        <button
            class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition">
            Save Bank Details
        </button>

    </form>


    <!-- ================= QR PAYMENT ================= -->
    <form method="POST"
        action="{{ route('admin.settings.update') }}"
        enctype="multipart/form-data"
        class="bg-white p-4 sm:p-6 rounded-lg shadow space-y-4">

        @csrf
        @method('PUT')

        <input type="hidden" name="form_type" value="qr">

        <label class="block">
            <span class="text-sm font-medium">Bank Name / Payment Method</span>

            <input
                type="text"
                name="qr_bank_name"
                value="{{ $settings['qr_bank_name'] ?? '' }}"
                class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        </label>

        <label class="block">
            <span class="text-sm font-medium">Account Title</span>

            <input
                type="text"
                name="qr_account_title"
                value="{{ $settings['qr_account_title'] ?? '' }}"
                class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        </label>

        @if(!empty($settings['qr_image']))
            <div>
                <span class="text-sm font-medium block mb-2">
                    Current QR Code
                </span>

                <div class="relative inline-block">

                    <img
                        src="{{ asset('storage/'.$settings['qr_image']) }}"
                        alt="QR Code"
                        class="h-28 w-28 border rounded-lg object-contain">

                    <!-- Delete Button -->
                    <button
                        type="submit"
                        name="remove_qr_image"
                        value="1"
                        onclick="return confirm('Remove this QR code?')"
                        class="absolute -top-2 -right-2 h-6 w-6 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center shadow-lg transition"
                        title="Remove QR Code">

                        &times;

                    </button>

                </div>
            </div>
        @endif

        <label class="block">
            <span class="text-sm font-medium">QR Image</span>

            <input
                type="file"
                name="qr_image"
                class="w-full border rounded-lg px-3 py-2 mt-1">
        </label>

        <button
            class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition">
            Save QR Details
        </button>

    </form>

</div>

@endsection