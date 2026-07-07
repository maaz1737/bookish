@extends('layouts.app')

@section('content')
    <div class="py-6">
        {{-- Breadcrumb Navigation --}}
        <nav class="text-sm text-slate-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-navy-800 transition">Home</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800 font-medium">My Wishlist</span>
        </nav>

        <div class="flex items-center justify-between border-b border-slate-200 pb-5 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold text-navy-800 tracking-tight">My Saved Items</h1>
                <p class="text-sm text-slate-500 mt-1">Products you have shortlisted to buy later.</p>
            </div>
            <span class="bg-navy-50 text-navy-800 font-semibold px-4 py-2 rounded-full text-sm border border-navy-100">
                Total Items: <span id="wishlist-total-badge">{{ count($wishlistItems) }}</span>
            </span>
        </div>

        {{-- Check if Wishlist is empty --}}
        @if (count($wishlistItems) == 0)
            <div
                class="text-center py-16 bg-white rounded-2xl border border-slate-200/80 shadow-sm max-w-md mx-auto my-8 px-6">
                <div
                    class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5 border border-slate-100">
                    <i class="fa-regular fa-heart text-slate-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-navy-800">Your wishlist is empty</h3>
                <p class="text-sm text-slate-500 mt-2 max-w-xs mx-auto leading-relaxed">
                    Explore our school books, bundles, uniforms, and gifts to save your favorite items!
                </p>
                <a href="{{ url('/') }}" class="primary-btn mt-6 w-full inline-flex items-center justify-center">
                    <i class="fa-solid fa-bag-shopping"></i> Continue Shopping
                </a>
            </div>
        @else
            {{-- Wishlist Responsive Grid Layout --}}
            <div class="grid-4" id="wishlist-grid">
                @foreach ($wishlistItems as $id => $item)
                    <div class="card relative flex flex-col justify-between h-full group"
                        id="wishlist-item-{{ $id }}">

                        {{-- Remove Button --}}
                        <button
                            class="remove-from-wishlist absolute top-3 right-3 z-30 w-8 h-8 rounded-full bg-white shadow-md flex items-center justify-center text-red-500 hover:text-red-700 hover:bg-slate-100 border border-slate-200 transition-all duration-200"
                            data-id="{{ $id }}" title="Remove from wishlist"
                            style="display: flex !important; align-items: center !important; justify-content: center !important;">
                            <i class="fa-solid fa-trash text-sm"></i>
                        </button>

                        <div>
                            {{-- Image Wrapper --}}
                            <div class="card-img-box bg-slate-50">
                                @if (!empty($item['image']))
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                        class="card-img">
                                @else
                                    <img src="{{ asset('images/placeholder.jpg') }}" alt="Placeholder" class="card-img">
                                @endif
                            </div>

                            {{-- Product Body --}}
                            <div class="p-5">
                                <h3
                                    class="font-bold text-slate-800 text-sm leading-snug line-clamp-2 min-h-[40px] group-hover:text-navy-800 transition-colors">
                                    {{ $item['name'] }}
                                </h3>

                                <div class="mt-3 flex items-baseline gap-2">
                                    <span class="text-base font-extrabold text-navy-800">Rs.
                                        {{ number_format($item['price']) }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Action Button (Add to Cart) --}}
                        <div class="px-5 pb-5 pt-0">
                            <button
                                class="primary-btn w-full text-xs py-2.5 rounded-xl flex items-center justify-center gap-2 add-to-cart-from-wishlist"
                                data-id="{{ $id }}">
                                <i class="fa-solid fa-cart-shopping text-xs"></i> Add to Cart
                            </button>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Script Section with Correct Handlers --}}
    <script>
        $(document).ready(function() {
            // CSRF Token Global setup for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ==========================================
            // 1. REMOVE FROM WISHLIST LOGIC
            // ==========================================
            $('.remove-from-wishlist').on('click', function(e) {
                e.preventDefault();

                let productId = $(this).data('id');
                let itemCard = $('#wishlist-item-' + productId);

                $.ajax({
                    url: '/wishlist/remove/' + productId,
                    method: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            itemCard.fadeOut(300, function() {
                                $(this).remove();

                                // Custom Toast dynamic popup call
                                if (typeof showToast === "function") {
                                    showToast('Item removed from wishlist', 'delete');
                                }

                                // Header counter/badge update
                                $('#wishlist_count').text(response.count);
                                $('#wishlist-total-badge').text(response.count);

                                // Agar items zero ho jayen to reload empty state dikhane ke liye
                                if (response.count == 0) {
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Could not remove item. Try again.');
                    }
                });
            });

            // ==========================================
            // 2. ADD TO CART FROM WISHLIST LOGIC
            // ==========================================
            $('.add-to-cart-from-wishlist').on('click', function(e) {
                e.preventDefault();

                let productId = $(this).data('id');
                let button = $(this);

                // Button state changing effect
                button.prop('disabled', true).html(
                    '<i class="fa-solid fa-spinner animate-spin"></i> Adding...');

                $.ajax({
                    url: '/cart/add/' + productId,
                    {{-- Apne Cart add route ke mutabiq url check kar lijiye ga --}}
                    method: 'POST',
                    data: {
                        quantity: 1
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Button wapas normal state me layein
                        button.prop('disabled', false).html(
                            '<i class="fa-solid fa-cart-shopping text-xs"></i> Add to Cart');

                        // Green Color Toast Notification
                        if (typeof showToast === "function") {
                            showToast(response.message || 'Product added to cart successfully!',
                                'success');
                        }

                        // Navbar cart count update karein agar layout me id bani hai
                        if (response.cart_count) {
                            $('#cart_count').text(response.cart_count);
                        }
                    },
                    error: function(xhr) {
                        button.prop('disabled', false).html(
                            '<i class="fa-solid fa-cart-shopping text-xs"></i> Add to Cart');

                        // Asli error message handle karein
                        let errorText = "Status: " + xhr.status + "\n";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorText += "Message: " + xhr.responseJSON.message;
                        } else {
                            errorText += "Response: " + xhr.responseText.substring(0, 200);
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Backend Error Trace',
                            html: '<pre style="text-align:left; font-size:12px;">' +
                                errorText + '</pre>',
                        });
                    }
                });
            });
        });
    </script>
@endsection
