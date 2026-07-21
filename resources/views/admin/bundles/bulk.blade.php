@extends('admin.layout')
@section('title', 'Bulk Bundle Upload')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Bulk Bundle Upload</h1>
                <p class="text-xs text-gray-500 mt-0.5">Import multiple school syllabus bundles simultaneously via CSV</p>
            </div>
        </div>
        <a href="{{ route('admin.bundles.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-4 py-2.5 rounded-xl transition">
            ← Back to Bundles
        </a>
    </div>

    @if (session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl font-medium text-xs flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Upload Card --}}
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm space-y-6">
        <div>
            <h2 class="text-base font-bold text-gray-900">Upload Bundles CSV File</h2>
            <p class="text-xs text-gray-500 mt-1">
                Upload a CSV file containing your bundle names, affiliated school & class, discount percentage, and product lists.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-5 bg-amber-50/70 border border-amber-200/70 rounded-2xl">
            <div>
                <h4 class="text-xs font-bold text-amber-950 uppercase tracking-wider">CSV Format Specification</h4>
                <p class="text-xs text-amber-800 mt-1">
                    Columns required: <strong>Bundle Name, School, Class, Discount Percent, Products</strong><br>
                    Products format: Separate products with <code class="bg-amber-100 px-1 py-0.5 rounded">|</code> or <code class="bg-amber-100 px-1 py-0.5 rounded">;</code> e.g. <code class="bg-amber-100 px-1 py-0.5 rounded">Maths Book Class 5 | English Reader Class 5</code>
                </p>
            </div>
            <a href="{{ route('admin.bundles.bulk.template') }}" class="inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-md shadow-amber-600/20 whitespace-nowrap active:scale-95">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download CSV Template
            </a>
        </div>

        <form action="{{ route('admin.bundles.bulk.post') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="border-2 border-dashed border-gray-200 hover:border-amber-500 rounded-2xl p-8 text-center cursor-pointer transition relative bg-gray-50/40" id="upload-container">
                <input type="file" name="file" id="file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".csv" onchange="displayFilename(this)">
                <div class="space-y-2" id="upload-placeholder">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto shadow-inner">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-gray-800">Drag & drop your CSV file here</p>
                    <p class="text-xs text-gray-400">or <span class="bg-white border border-gray-200 rounded-lg px-3 py-1 text-gray-700 font-semibold shadow-xs">Browse File</span></p>
                </div>
                <div class="hidden space-y-2" id="filename-container">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto shadow-inner">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-emerald-800" id="filename-label"></p>
                    <p class="text-xs text-gray-400">Click or drag again to change file</p>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs px-6 py-3 rounded-xl shadow-md shadow-indigo-500/20 transition active:scale-95">
                    Validate & Preview
                </button>
            </div>
        </form>
    </div>

    {{-- Validation Preview Results --}}
    @if (isset($rows))
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
            <h2 class="text-base font-bold text-gray-900">Upload Validation Results</h2>

            @if (count($bulkErrors) > 0)
                <div class="bg-rose-50 border border-rose-200 rounded-2xl p-5 text-rose-900 space-y-2">
                    <h4 class="font-bold flex items-center gap-2 text-rose-700 text-sm">
                        <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Validation Errors Detected
                    </h4>
                    <p class="text-xs text-rose-700">Please resolve the following errors in your CSV file and upload it again:</p>
                    <ul class="list-disc list-inside space-y-1 text-xs text-rose-800 font-mono">
                        @foreach ($bulkErrors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 text-emerald-900 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div>
                        <h4 class="font-bold flex items-center gap-2 text-emerald-800 text-sm">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            All Bundle Records Validated Successfully
                        </h4>
                        <p class="text-xs text-emerald-700 mt-0.5">All products, schools, and classes match our database. You can now import the bundles.</p>
                    </div>
                    <form action="{{ route('admin.bundles.bulk.import') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-6 py-3 rounded-xl shadow-md shadow-emerald-600/20 transition active:scale-95 whitespace-nowrap">
                            Confirm & Import Bundles Now
                        </button>
                    </form>
                </div>
            @endif

            <h3 class="font-bold text-gray-900 text-sm">Bundle File Preview</h3>
            <div class="overflow-x-auto border border-gray-100 rounded-xl">
                <table class="w-full text-xs text-left">
                    <thead class="bg-gray-50/80 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-100">
                        <tr>
                            <th class="px-4 py-3">Row</th>
                            <th class="px-4 py-3">Bundle Name</th>
                            <th class="px-4 py-3">School</th>
                            <th class="px-4 py-3">Class</th>
                            <th class="px-4 py-3">Products Matched</th>
                            <th class="px-4 py-3">Discount</th>
                            <th class="px-4 py-3">Final Price</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($rows as $row)
                            <tr class="hover:bg-gray-50/50 transition-colors align-top">
                                <td class="px-4 py-3 font-semibold text-gray-400">#{{ $row['row_num'] }}</td>
                                <td class="px-4 py-3 font-bold text-gray-900">{{ $row['name'] }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $row['school_name'] ?: 'Any School' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $row['class_name'] ?: 'Any Class' }}</td>
                                <td class="px-4 py-3">
                                    @if(count($row['products']) > 0)
                                        <div class="space-y-1">
                                            @foreach($row['products'] as $pItem)
                                                <div class="inline-flex items-center gap-1 bg-gray-100 text-gray-800 px-2 py-0.5 rounded text-[11px]">
                                                    <span>{{ $pItem['product_name'] }}</span>
                                                    <span class="font-bold text-indigo-600">x{{ $pItem['quantity'] }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-rose-600 font-semibold">{{ $row['products_raw'] }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-bold text-rose-600">{{ $row['discount'] }}%</td>
                                <td class="px-4 py-3 font-extrabold text-gray-900">{{ number_format($row['final_price'], 2) }} PKR</td>
                                <td class="px-4 py-3">
                                    @if (count($row['errors']) === 0)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Valid</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Invalid</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<script>
    function displayFilename(input) {
        const placeholder = document.getElementById('upload-placeholder');
        const container = document.getElementById('filename-container');
        const label = document.getElementById('filename-label');

        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name;
            placeholder.classList.add('hidden');
            container.classList.remove('hidden');
        }
    }
</script>
@endsection
