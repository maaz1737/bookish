@extends('admin.layout')
@section('title','Bank Settings')
@section('content')
<h1 class="text-2xl font-bold mb-6">Store Bank Details</h1>
<form method="POST" action="{{ route('admin.settings.update') }}" class="bg-white p-6 rounded-lg shadow max-w-lg space-y-4">
    @csrf @method('PUT')
    @foreach (['bank_name'=>'Bank Name','account_title'=>'Account Title','bank_iban'=>'IBAN','bank_account_no'=>'Account Number','raast_id'=>'Raast ID'] as $key=>$label)
        <label class="block"><span class="text-sm font-medium">{{ $label }}</span>
            <input name="{{ $key }}" value="{{ $settings[$key] }}" class="w-full border rounded px-3 py-2 mt-1"></label>
    @endforeach
    <button class="bg-indigo-600 text-white px-6 py-2 rounded">Save</button>
</form>
@endsection
