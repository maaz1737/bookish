@extends('admin.layout')
@section('title', 'Edit Bundle')
@section('content')
    @php
        $bundleItems = $bundle->items->keyBy('product_id');
    @endphp
    
    <h1 class="text-2xl font-bold mb-2">Edit Bundle</h1>
    <p class="text-sm text-gray-500 mb-6">Modify details, selected products, or discount for this bundle.</p>
    
    <form method="POST" action="{{ route('admin.bundles.update', $bundle) }}" class="bg-white p-6 rounded-lg shadow space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid sm:grid-cols-3 gap-6">
            <label class="block sm:col-span-3">
                <span class="text-sm font-bold text-gray-700">Bundle Name <span class="text-red-500">*</span></span>
                <input name="name" type="text" placeholder="e.g. Smart Saver Bundle" required value="{{ old('name', $bundle->name) }}"
                    class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                @error('name')
                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </label>
            
            <label class="block">
                <span class="text-sm font-semibold text-gray-700">School <span class="text-xs text-gray-400 font-normal">(Optional)</span></span>
                <select name="school_id" id="school" class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select School (Optional)</option>
                    @foreach ($schools as $s)
                        <option value="{{ $s->id }}" {{ old('school_id', $bundle->school_id) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
                @error('school_id')
                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </label>
            
            <label class="block">
                <span class="text-sm font-semibold text-gray-700">Class <span class="text-xs text-gray-400 font-normal">(Optional)</span></span>
                <select name="class_id" id="class" class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select Class (Optional)</option>
                </select>
                @error('class_id')
                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </label>
            
            <label class="block">
                <span class="text-sm font-bold text-gray-700">Discount % <span class="text-red-500">*</span></span>
                <input name="discount" id="discount-input" type="number" step="0.01" min="0" max="100" value="{{ old('discount', $bundle->discount) }}" required
                    class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                @error('discount')
                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </label>
        </div>

        <div>
            <div class="flex justify-between items-center mb-2">
                <h2 class="font-bold text-gray-700">Select Products <span class="text-xs font-normal text-gray-400">(Choose 2 or more)</span></h2>
                <div class="text-xs text-gray-500">
                    <span id="selected-count">0</span> products selected
                </div>
            </div>
            
            @error('items')
                <p class="text-red-500 text-xs mb-2 font-semibold">{{ $message }}</p>
            @enderror

            <div class="border rounded-lg overflow-hidden shadow-sm bg-gray-50">
                <div class="max-h-80 overflow-y-auto divide-y divide-gray-200">
                    @foreach ($products as $i => $p)
                        @php
                            $bundleItem = $bundleItems->get($p->id);
                            $isChecked = old('items') ? collect(old('items'))->contains('product_id', $p->id) : !is_null($bundleItem);
                            $quantity = old('items') ? (collect(old('items'))->firstWhere('product_id', $p->id)['quantity'] ?? 1) : ($bundleItem?->quantity ?? 1);
                        @endphp
                        <label class="flex items-center justify-between p-3.5 hover:bg-indigo-50/30 cursor-pointer bg-white transition select-none">
                            <span class="flex items-center gap-3">
                                <input type="checkbox" name="items[{{ $i }}][product_id]" value="{{ $p->id }}" 
                                    class="product-checkbox w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500"
                                    data-price="{{ $p->effectivePrice() }}"
                                    {{ $isChecked ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-800">{{ $p->name }}</span>
                            </span>
                            <span class="flex items-center gap-6">
                                <span class="text-xs text-gray-500 font-semibold bg-gray-100 px-2 py-1 rounded">Stock: {{ $p->stock }}</span>
                                <span class="text-sm font-bold text-gray-700 w-24 text-right" data-raw-price="{{ $p->effectivePrice() }}">{{ number_format($p->effectivePrice()) }} PKR</span>
                                <span class="text-xs text-gray-400">Qty:</span>
                                <input type="number" name="items[{{ $i }}][quantity]" value="{{ $quantity }}" min="1"
                                    class="product-qty w-16 border rounded-lg px-2 py-1 text-center focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Calculations card --}}
        <div class="bg-indigo-50/50 border border-indigo-100 rounded-xl p-5 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="space-y-1 text-center sm:text-left">
                <div class="text-sm text-gray-600">Total Price: <span class="font-bold text-gray-800"><span id="total-original-price">0</span> PKR</span></div>
                <div class="text-sm text-gray-600">Applied Discount: <span class="font-bold text-red-600"><span id="discount-pct">10</span>%</span></div>
            </div>
            <div class="text-center sm:text-right">
                <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Final Bundle Price</div>
                <div class="text-2xl font-extrabold text-[#0a1f44]"><span id="total-final-price">0</span> PKR</div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $bundle->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span class="text-sm font-medium text-gray-700">Active (Visible on storefront)</span>
            </label>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow-sm transition">
                Update Bundle
            </button>
        </div>
    </form>

    <script>
        // School-class relationship dictionary
        const classesBySchool = @json($schools->mapWithKeys(fn($s) => [$s->id => $s->classes->map(fn($c) => ['id' => $c->id, 'name' => $c->name])]));
        const schoolSel = document.getElementById('school'),
            classSel = document.getElementById('class');

        function updateClasses(selectedClassId = null) {
            classSel.innerHTML = '<option value="">Select Class (Optional)</option>';
            const classes = classesBySchool[schoolSel.value] || [];
            classes.forEach(c => {
                const o = document.createElement('option');
                o.value = c.id;
                o.textContent = c.name;
                if (selectedClassId && selectedClassId == c.id) {
                    o.selected = true;
                }
                classSel.appendChild(o);
            });
        }

        schoolSel.addEventListener('change', () => updateClasses());
        
        // Auto-run for edit view
        if (schoolSel.value) {
            updateClasses("{{ old('class_id', $bundle->class_id) }}");
        }

        // Live calculation logic
        const discountInput = document.getElementById('discount-input');
        const discountPctDisplay = document.getElementById('discount-pct');
        const totalOriginalDisplay = document.getElementById('total-original-price');
        const totalFinalDisplay = document.getElementById('total-final-price');
        const selectedCountDisplay = document.getElementById('selected-count');

        function calculatePrices() {
            let totalOriginal = 0;
            let selectedCount = 0;

            document.querySelectorAll('.product-checkbox:checked').forEach(cb => {
                selectedCount++;
                const price = parseFloat(cb.dataset.price);
                const parentLabel = cb.closest('label');
                const qtyInput = parentLabel.querySelector('.product-qty');
                const qty = parseInt(qtyInput.value) || 1;
                totalOriginal += (price * qty);
            });

            const discount = parseFloat(discountInput.value) || 0;
            const discountAmt = totalOriginal * (discount / 100);
            const totalFinal = Math.max(0, totalOriginal - discountAmt);

            selectedCountDisplay.innerText = selectedCount;
            totalOriginalDisplay.innerText = Math.round(totalOriginal).toLocaleString();
            discountPctDisplay.innerText = discount;
            totalFinalDisplay.innerText = Math.round(totalFinal).toLocaleString();
        }

        // Add event listeners to input changes
        document.querySelectorAll('.product-checkbox, .product-qty').forEach(el => {
            el.addEventListener('change', calculatePrices);
            el.addEventListener('input', calculatePrices);
        });
        discountInput.addEventListener('input', () => {
            calculatePrices();
        });

        // Initialize calculation
        calculatePrices();
    </script>
@endsection
