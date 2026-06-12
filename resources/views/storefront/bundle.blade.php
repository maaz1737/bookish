@extends('layouts.app')
@section('content')


<nav class="text-sm text-gray-500 mb-4">
    <a href="{{ route('schools.show', $school) }}">{{ $school->name }}</a> / {{ $class->name }}
</nav>

<h1 class="text-2xl font-bold mb-1">{{ $class->name }} Book Bundle</h1>
<p class="text-gray-500 mb-6">Buy the complete set at a discount, or untick books you don't need.</p>

<form method="POST" action="{{ route('cart.addBundle', $bundle) }}" class="bg-white rounded-lg shadow p-6">
    @csrf
    <div class="divide-y">
        @foreach ($bundle->items as $item)
            <label class="flex items-center justify-between py-3">
                <span class="flex items-center gap-3">
                    <input type="checkbox" checked
                           onchange="this.checked ? this.nextElementSibling.remove() : null"
                           class="bundle-book" data-id="{{ $item->product_id }}">
                    <span>{{ $item->product->name }} <span class="text-gray-400">×{{ $item->quantity }}</span></span>
                </span>
                <span class="font-medium">{{ number_format($item->product->effectivePrice() * $item->quantity) }} PKR</span>
            </label>
        @endforeach
    </div>

    <div id="exclude-fields"></div>

    <div class="mt-6 flex items-center justify-between border-t pt-4">
        <div>
            <div class="text-sm text-gray-500 line-through">{{ number_format($bundle->total_price) }} PKR</div>
            <div class="text-xl font-bold text-indigo-600">{{ number_format($bundle->final_price) }} PKR
                <span class="text-sm font-normal text-green-600">({{ rtrim(rtrim($bundle->discount,'0'),'.') }}% off)</span>
            </div>
        </div>
        <button class="bg-indigo-600 text-white px-6 py-2 rounded font-medium">Add bundle to cart</button>
    </div>
</form>

<script>
document.querySelector('form').addEventListener('submit', function () {
    const wrap = document.getElementById('exclude-fields');
    wrap.innerHTML = '';
    document.querySelectorAll('.bundle-book').forEach(cb => {
        if (!cb.checked) {
            const f = document.createElement('input');
            f.type = 'hidden'; f.name = 'exclude[]'; f.value = cb.dataset.id;
            wrap.appendChild(f);
        }
    });
});
</script>
@endsection
