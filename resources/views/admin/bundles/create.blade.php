@extends('admin.layout')
@section('title', 'New Bundle')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Build a Bundle</h1>
    <p class="text-sm text-gray-500 mb-4">Select School → Class → add books → discount auto-calculates the final price.</p>
    <form method="POST" action="{{ route('admin.bundles.store') }}" class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf
        <div class="grid sm:grid-cols-3 gap-4">
            <label class="block"><span class="text-sm font-medium">School</span>
                <select name="school_id" id="school" required class="w-full border rounded px-3 py-2 mt-1">
                    <option value="">Select…</option>
                    @foreach ($schools as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select></label>
            <label class="block"><span class="text-sm font-medium">Class</span>
                <select name="class_id" id="class" required
                    class="w-full border rounded px-3 py-2 mt-1"></select></label>
            <label class="block"><span class="text-sm font-medium">Discount %</span>
                <input name="discount" type="number" step="0.01" value="10" required
                    class="w-full border rounded px-3 py-2 mt-1"></label>
        </div>

        <div>
            <h2 class="font-medium mb-2">Books</h2>
            <div class="space-y-2 max-h-64 overflow-y-auto border rounded p-3">
                @foreach ($products as $i => $p)
                    <label class="flex items-center justify-between text-sm">
                        <span><input type="checkbox" name="items[{{ $i }}][product_id]"
                                value="{{ $p->id }}"> {{ $p->name }}
                            <span class="text-gray-400">({{ number_format($p->effectivePrice()) }} PKR)</span></span>
                        <input type="number" name="items[{{ $i }}][quantity]" value="1" min="1"
                            class="w-16 border rounded px-2 py-1">
                    </label>
                @endforeach
            </div>
        </div>
        <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" checked>
            Active</label>
        <button class="bg-indigo-600 text-white px-6 py-2 rounded">Save & Auto-Calculate</button>
    </form>

    <script>
        const classesBySchool = @json($schools->mapWithKeys(fn($s) => [$s->id => $s->classes->map(fn($c) => ['id' => $c->id, 'name' => $c->name])]));
        const schoolSel = document.getElementById('school'),
            classSel = document.getElementById('class');
        schoolSel.addEventListener('change', () => {
            classSel.innerHTML = '';
            (classesBySchool[schoolSel.value] || []).forEach(c => {
                const o = document.createElement('option');
                o.value = c.id;
                o.textContent = c.name;
                classSel.appendChild(o);
            });
        });
    </script>
@endsection
