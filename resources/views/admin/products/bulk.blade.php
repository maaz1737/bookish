@extends('admin.layout')
@section('title', 'Bulk Product Upload')
@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Bulk Product Upload</h1>
            <a href="{{ route('admin.products.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold text-sm">
                ← Back to Products
            </a>
        </div>

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-800 rounded-lg font-medium">
                {{ session('error') }}
            </div>
        @endif

        {{-- UPLOAD FORM CARD --}}
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-2">Upload CSV File</h2>
            <p class="text-sm text-gray-500 mb-4">
                Please upload a CSV file conforming to the predefined format. Use the link below to download a blank template with columns already mapped.
            </p>

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-4 bg-indigo-50 border border-indigo-100 rounded-lg mb-6">
                <div>
                    <h4 class="text-sm font-bold text-indigo-900">Predefined Excel/CSV Template</h4>
                    <p class="text-xs text-indigo-700">Contains required columns: Product Name, Category, School, Class, Publisher, Base Price, Discount Price, Stock, Low Stock Threshold, Description.</p>
                </div>
                <a href="{{ route('admin.products.bulk.template') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2.5 rounded-lg flex items-center gap-2 transition whitespace-nowrap shadow-sm">
                    <i class="fa-solid fa-download"></i> Download Template
                </a>
            </div>

            <form action="{{ route('admin.products.bulk.post') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="border-2 border-dashed border-gray-300 hover:border-indigo-500 rounded-xl p-6 text-center cursor-pointer transition relative bg-gray-50/50" id="upload-container">
                    <input type="file" name="file" id="file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".csv" onchange="displayFilename(this)">
                    <div class="space-y-2" id="upload-placeholder">
                        <i class="fa-solid fa-file-csv text-4xl text-gray-400"></i>
                        <p class="text-sm font-bold text-gray-800">Drag & drop your CSV file here</p>
                        <p class="text-xs text-gray-500">or <span class="bg-white border rounded-md px-2.5 py-1 text-gray-700 font-semibold shadow-sm">Choose File</span></p>
                    </div>
                    <div class="hidden space-y-2" id="filename-container">
                        <i class="fa-solid fa-file-csv text-4xl text-green-500"></i>
                        <p class="text-sm font-bold text-green-800" id="filename-label"></p>
                        <p class="text-xs text-gray-400">Click or drag again to change file</p>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow-sm transition">
                        Validate & Preview
                    </button>
                </div>
            </form>
        </div>

        {{-- PREVIEW & RESULTS SECTION --}}
        @if (isset($rows))
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Upload Validation Results</h2>

                @if (count($bulkErrors) > 0)
                    <div class="bg-red-50 border border-red-200 rounded-xl p-5 mb-6 text-red-900">
                        <h4 class="font-bold flex items-center gap-2 text-red-700 mb-2">
                            <i class="fa-solid fa-triangle-exclamation text-red-600"></i> Validation Errors Found
                        </h4>
                        <p class="text-xs text-red-700 mb-3">Please resolve the following errors in your file and upload it again:</p>
                        <ul class="list-disc list-inside space-y-1.5 text-xs text-red-800/90 font-mono">
                            @foreach ($bulkErrors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="bg-green-50 border border-green-200 rounded-xl p-5 mb-6 text-green-900 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div>
                            <h4 class="font-bold flex items-center gap-2 text-green-700">
                                <i class="fa-solid fa-circle-check text-green-600"></i> All Products Validated Successfully
                            </h4>
                            <p class="text-xs text-green-600 mt-1">No duplicates or errors found. You can now import the products into the database.</p>
                        </div>
                        <form action="{{ route('admin.products.bulk.import') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-3 rounded-lg shadow-md transition whitespace-nowrap text-sm flex items-center gap-2">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Confirm & Import Now
                            </button>
                        </form>
                    </div>
                @endif

                <h3 class="font-bold text-gray-700 mb-3 text-sm">Product File Preview</h3>
                <div class="overflow-x-auto border rounded-lg">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="p-3 border-b">Row</th>
                                <th class="p-3 border-b">Product Name</th>
                                <th class="p-3 border-b">Category</th>
                                <th class="p-3 border-b">School</th>
                                <th class="p-3 border-b">Class</th>
                                <th class="p-3 border-b">Base Price</th>
                                <th class="p-3 border-b">Discount Price</th>
                                <th class="p-3 border-b">Stock</th>
                                <th class="p-3 border-b">Status / Errors</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($rows as $row)
                                <tr class="{{ count($row['errors']) > 0 ? 'bg-red-50/50 hover:bg-red-50' : 'hover:bg-gray-50' }}">
                                    <td class="p-3 font-semibold text-gray-500 border-r">{{ $row['row_num'] }}</td>
                                    <td class="p-3 font-medium text-gray-900">{{ $row['name'] ?: '—' }}</td>
                                    <td class="p-3">{{ $row['category_name'] ?: '—' }}</td>
                                    <td class="p-3">{{ $row['school_name'] ?: '—' }}</td>
                                    <td class="p-3">{{ $row['class_name'] ?: '—' }}</td>
                                    <td class="p-3 font-mono font-semibold">{{ number_format($row['price']) }} PKR</td>
                                    <td class="p-3 font-mono text-gray-500">{{ $row['discount_price'] ? number_format($row['discount_price']) . ' PKR' : '—' }}</td>
                                    <td class="p-3 font-semibold">{{ $row['stock'] }}</td>
                                    <td class="p-3 border-l">
                                        @if (count($row['errors']) > 0)
                                            <span class="text-red-600 font-bold flex items-start gap-1">
                                                <i class="fa-solid fa-circle-exclamation mt-0.5 shrink-0 text-red-500"></i>
                                                <span>{{ implode(' | ', $row['errors']) }}</span>
                                            </span>
                                        @else
                                            <span class="text-green-600 font-semibold flex items-center gap-1">
                                                <i class="fa-solid fa-circle-check text-green-500"></i> Valid
                                            </span>
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
            const file = input.files[0];
            if (file) {
                document.getElementById('upload-placeholder').classList.add('hidden');
                document.getElementById('filename-container').classList.remove('hidden');
                document.getElementById('filename-label').innerText = file.name;
                document.getElementById('upload-container').classList.add('border-indigo-500', 'bg-indigo-50/20');
            }
        }
    </script>
@endsection
