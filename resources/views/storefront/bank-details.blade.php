@extends('layouts.app')


@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @php
            $currentStep = request()->get('step') === 'confirm' ? 'confirm' : 'method';
            $steps = [
                ['icon' => '🛒', 'label' => 'Cart', 'active' => false, 'completed' => true],
                ['icon' => '🚚', 'label' => 'Checkout', 'active' => false, 'completed' => true],
                [
                    'icon' => '💳',
                    'label' => 'Payment Method',
                    'active' => $currentStep === 'method',
                    'completed' => $currentStep === 'confirm',
                ],
                [
                    'icon' => '📤',
                    'label' => 'Payment Confirmation',
                    'active' => $currentStep === 'confirm',
                    'completed' => false,
                ],
                ['icon' => '✓', 'label' => 'Confirmation', 'active' => false, 'completed' => false],
            ];
        @endphp

        {{-- <div class="max-w-5xl mx-auto px-4 pt-2">
            <div class="flex items-center justify-between text-xs text-gray-500">
                @foreach ($steps as $i => $s)
                    <div class="flex flex-col items-center flex-1">
                        <div
                            class="w-10 h-10 rounded-full border-2 flex items-center justify-center transition-all duration-300
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    {{ $s['active'] || $s['completed'] ? 'bg-[#0a1f44] text-white border-[#0a1f44] shadow-sm' : 'bg-white text-gray-400 border-gray-300' }}">
                            @if ($s['completed'])
                                <i class="fa-solid fa-check text-xs"></i>
                            @else
                                <span>{{ $s['icon'] }}</span>
                            @endif
                        </div>
                        <div
                            class="mt-2 text-center text-[11px] transition-all duration-300 {{ $s['active'] ? 'text-[#0a1f44] font-semibold' : 'text-gray-400' }}">
                            {{ $s['label'] }}
                        </div>
                    </div>
                    @if ($i < count($steps) - 1)
                        <div
                            class="flex-1 h-px -mt-6 transition-all duration-300 {{ $s['completed'] ? 'bg-[#0a1f44]' : 'bg-gray-300' }}">
                        </div>
                    @endif
                @endforeach
            </div> --}}
        </div>

        <!-- Content grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-10 max-w-7xl mx-auto items-start">

            <!-- Order Summary Section (order-1 on mobile, order-2 on desktop) -->
            <div class="order-1 lg:order-2 lg:col-span-1">
                <div x-data="{ isOpen: true }" class="bg-white border border-gray-200/80 rounded-2xl overflow-hidden shadow-sm">
                    <!-- Header / Toggle -->
                    <div @click="isOpen = !isOpen"
                        class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50/50 transition-colors select-none">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500 flex-shrink-0">
                                <i class="fa-solid fa-cart-shopping text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-navy-800 text-sm sm:text-base">Order Summary</h3>
                                <p class="text-xs text-gray-500 font-medium">
                                    {{ count($order->items) }} {{ count($order->items) == 1 ? 'item' : 'items' }} • Total
                                    <span class="text-[#ff7a00] font-bold">PKR
                                        {{ number_format($order->total_amount) }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="text-gray-400 pr-1">
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200"
                                :class="isOpen ? 'rotate-180' : ''"></i>
                        </div>
                    </div>

                    <!-- Collapsible Content -->
                    <div x-show="isOpen" x-collapse>
                        <div class="px-4 pb-4 pt-2 border-t border-gray-100">
                            <!-- Items List -->
                            <div class="space-y-4 max-h-[300px] overflow-y-auto pr-1">
                                @foreach ($order->items as $item)
                                    <div class="flex gap-3 items-center py-2">
                                        <div
                                            class="w-14 h-14 bg-gray-50 border border-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                            <img src="{{ $item->product->imageUrl() }}"
                                                alt="{{ $item->product?->name ?? 'Product' }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-xs sm:text-sm text-navy-800 truncate">
                                                {{ $item->product->name }}</h4>
                                            <p class="text-[11px] text-gray-400 mt-0.5">Premium Quality • 18 inch</p>
                                            <p class="text-[11px] text-gray-500 font-semibold mt-0.5">Qty:
                                                {{ $item->quantity }}</p>
                                        </div>
                                        <div class="text-right flex-shrink-0 pl-2">
                                            <p class="text-xs sm:text-sm font-bold text-navy-800">PKR
                                                {{ number_format($item->line_total) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Subtotal & Delivery Charges -->
                            <div class="border-t border-gray-100 mt-3 pt-3 space-y-2.5 text-xs sm:text-sm">
                                <div class="flex justify-between items-center text-gray-600">
                                    <span>Subtotal ({{ count($order->items) }}
                                        {{ count($order->items) == 1 ? 'item' : 'items' }})</span>
                                    <span class="font-semibold text-[#0a1f44]">PKR
                                        {{ number_format($order->subtotal) }}</span>
                                </div>
                                <div class="flex justify-between items-center text-gray-600">
                                    <span>Delivery Charges</span>
                                    <span class="font-semibold text-[#0a1f44]">
                                        {{ optional($order->shippingRate)->price ? 'PKR ' . number_format($order->shippingRate->price) : 'PKR 0' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Grand Total Box -->
                            <div
                                class="bg-amber-50/60 border border-amber-100/50 mt-4 p-3.5 rounded-xl flex justify-between items-center font-bold text-navy-800 text-sm sm:text-base">
                                <span>Total Amount</span>
                                <span class="text-navy-900">PKR {{ number_format($order->total_amount) }}</span>
                            </div>

                            <!-- Security Box -->
                            {{-- ===== TRUST / BENEFITS STRIP ===== --}}
                            @include('partials.trust-section')

                            <!-- Footer Secure Info -->
                            <div
                                class="mt-3 flex items-center gap-1.5 justify-center text-[10px] text-gray-400 font-medium">
                                <i class="fa-solid fa-lock text-xs"></i> Secure payments. Multiple payment options
                                available.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment methods Section (order-2 on mobile, order-1 on desktop) -->
            <section
                class="order-2 lg:order-1 lg:col-span-2 bg-white border border-gray-200 rounded-xl p-6 sm:p-8 shadow-sm">
                @if ($order->payment_method === 'bank_transfer')

                    @if ($order->payment_status === 'proof_submitted')
                        {{-- PROOF SUBMITTED STATE --}}
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 text-center space-y-4">
                            <div
                                class="w-14 h-14 rounded-full bg-amber-100 flex items-center justify-center mx-auto text-amber-600 text-2xl">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <h3 class="text-xl font-bold text-[#0a1f44]">Payment Proof Submitted</h3>
                            <p class="text-sm text-gray-600 max-w-md mx-auto">
                                We have received your payment receipt. Our team is verifying the transaction. This usually
                                takes 1–2
                                hours.
                            </p>
                            @if ($order->latestProof)
                                @if ($order->latestProof->screenshot_path === 'whatsapp')
                                    <div
                                        class="inline-flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-xs font-semibold px-4 py-2 rounded-xl">
                                        <i class="fa-brands fa-whatsapp text-lg"></i> Payment receipt shared via WhatsApp
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <p class="text-xs font-semibold text-gray-400 mb-2">Uploaded Screenshot:</p>
                                        <div
                                            class="max-w-[200px] mx-auto border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                                            <img src="{{ asset('storage/' . $order->latestProof->screenshot_path) }}"
                                                alt="Payment proof"
                                                class="w-full h-auto object-contain max-h-[150px] cursor-pointer"
                                                onclick="window.open(this.src)" />
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <div class="pt-2">
                                <a href="{{ url('/') }}"
                                    class="inline-flex items-center gap-2 bg-[#0a1f44] hover:bg-[#0d2a5c] text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">
                                    <i class="fa-solid fa-house"></i> Continue Shopping
                                </a>
                            </div>
                        </div>
                    @elseif ($order->payment_status === 'paid')
                        {{-- PAID STATE --}}
                        <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center space-y-4">
                            <div
                                class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mx-auto text-green-600 text-2xl">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <h3 class="text-xl font-bold text-[#0a1f44]">Payment Verified!</h3>
                            <p class="text-sm text-gray-600 max-w-md mx-auto">
                                Thank you! Your payment has been successfully verified and your order is now being
                                processed.
                            </p>
                            <div class="pt-2">
                                <a href="{{ url('/') }}"
                                    class="inline-flex items-center gap-2 bg-[#0a1f44] hover:bg-[#0d2a5c] text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">
                                    <i class="fa-solid fa-house"></i> Continue Shopping
                                </a>
                            </div>
                        </div>
                    @elseif ($currentStep === 'confirm')
                        {{-- STEP 2: CONFIRM YOUR PAYMENT --}}
                        <div class="flex items-center gap-3 pb-4 border-b border-gray-200">
                            <div
                                class="w-9 h-9 rounded-full bg-[#0a1f44] text-white flex items-center justify-center font-bold text-sm shrink-0">
                                2</div>
                            <div>
                                <h2 class="text-xl sm:text-2xl font-extrabold text-[#0a1f44]">Confirm Your Payment</h2>
                                <p class="text-sm text-gray-500">Please send or upload your payment receipt so we can verify
                                    your
                                    order.</p>
                            </div>
                        </div>

                        @if ($order->latestProof && $order->latestProof->status === 'rejected')
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-red-800 mb-5 space-y-1">
                                <h4 class="font-bold flex items-center gap-2 text-sm text-red-700">
                                    <i class="fa-solid fa-circle-xmark text-red-600"></i> Payment Verification Failed
                                </h4>
                                <p class="text-xs text-gray-700">Your previous submission was rejected. Please re-submit:
                                </p>
                                <div
                                    class="bg-white/80 rounded border border-red-100 p-2.5 text-xs font-mono mt-2 text-red-700">
                                    <strong>Reason:</strong> {{ $order->latestProof->admin_note ?: 'No detail provided.' }}
                                </div>
                            </div>
                        @endif

                        <p class="text-sm font-bold text-[#0a1f44] my-4">Choose a confirmation method</p>

                        <form action="{{ route('checkout.proof', $order->order_number) }}" method="post"
                            enctype="multipart/form-data" id="confirm-payment-form">
                            @csrf
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start relative border-b border-gray-200 pb-4">

                                {{-- Option 1: Upload --}}
                                <div id="card-upload"
                                    class="border-2 border-green-500 bg-green-50 shadow-md rounded-2xl p-5 cursor-pointer h-full proof-card">
                                    <div class="flex items-start gap-3 mb-4 justify-between">
                                        <div
                                            class="w-12 h-12 rounded-full bg-blue-100 text-[#0a1f44] flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-extrabold text-[#0a1f44] text-sm">Upload Receipt</h4>
                                            <p class="text-xs text-gray-500  pt-2">Upload your payment screenshot directly.
                                            </p>
                                        </div>
                                        <div>
                                            <input type="radio" name="proof" value="screenshot" checked
                                                class="proof-radio w-5 h-5 accent-green-600 cursor-pointer">
                                        </div>
                                    </div>
                                    @error('screenshot')
                                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Option 2: WhatsApp --}}
                                <div id="card-whatsapp"
                                    class="border border-gray-200 rounded-2xl p-5 cursor-pointer h-full proof-card">
                                    <div class="flex items-start gap-3 mb-4 justify-between">
                                        <div
                                            class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                                            <i class="fa-brands fa-whatsapp text-xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-extrabold text-[#0a1f44] text-sm">WhatsApp</h4>
                                            <p class="text-xs text-gray-500  pt-2">Send your payment screenshot through
                                                WhatsApp.
                                            </p>
                                        </div>
                                        <div>
                                            <input type="radio" name="proof" value="whatsapp"
                                                class="proof-radio w-5 h-5 accent-green-600 cursor-pointer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4" id="payment-upload">
                                <p class="font-semibold">Upload your payment receipt</p>
                                <div class="border-2 border-dashed border-gray-200 hover:border-[#0a1f44] rounded-xl p-6 text-center cursor-pointer transition relative bg-white mt-3"
                                    id="upload-box">
                                    <input type="file" name="screenshot" id="screenshot-input"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        accept="image/*,application/pdf" onchange="previewFile(this)" />
                                    <div class="space-y-2" id="upload-placeholder">
                                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-300"></i>
                                        <p class="text-sm font-bold text-[#0a1f44]">Drag & drop your file here</p>
                                        <p class="text-[11px] text-gray-400">or <span
                                                class="bg-gray-100 border rounded mx-2 px-3 py-0.5 text-gray-700 font-semibold">Choose
                                                File</span>
                                        </p>
                                        <p class="text-[10px] text-gray-400">JPG, PNG, PDF (Max. 5MB)</p>
                                    </div>
                                    <div class="hidden space-y-2" id="upload-preview-container">
                                        <i class="fa-regular fa-file-image text-4xl text-green-400 hidden"
                                            id="file-icon"></i>
                                        <img id="upload-preview"
                                            class="max-h-[100px] mx-auto rounded border shadow-sm hidden" />
                                        <p class="text-xs text-[#0a1f44] font-semibold break-all" id="filename-label"></p>
                                        <p class="text-[10px] text-gray-400">Click or drag to change</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4" id="payment-whatsapp" style="display: none;">
                                <div
                                    class="flex items-center flex-col sm:flex-row gap-5 rounded-xl border border-green-100 bg-[#f5fbf7] px-6 py-10">

                                    <!-- Left Icon -->
                                    <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-green-100">
                                        <i class="fa-regular fa-file-lines text-4xl text-green-600 relative">
                                            <span
                                                class="absolute -bottom-1 -right-1 flex h-8 w-8 items-center justify-center rounded-full bg-[#25D366] border-2 border-white">
                                                <i class="fa-brands fa-whatsapp text-[11px] text-white"></i>
                                            </span>
                                        </i>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1">
                                        <h4 class="text-[15px] font-bold text-[#1b2d4b]">
                                            Send your payment receipt on WhatsApp
                                        </h4>

                                        <p class="mt-1 text-xs text-gray-500">
                                            Send your payment screenshot to the WhatsApp number below.
                                        </p>
                                        <div
                                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white border border-gray-200 rounded-xl p-3 mt-3 max-w-sm">

                                            <!-- Number -->
                                            <div class="flex items-center gap-2">
                                                <i class="fa-brands fa-whatsapp text-green-600 text-lg sm:text-xl"></i>

                                                <span
                                                    class="text-lg xs:text-xl sm:text-[22px] font-semibold tracking-wide text-[#1b2d4b]">
                                                    0321-4735908
                                                </span>
                                            </div>

                                            <!-- Copy Button -->
                                            <button type="button" id="copy-whatsapp"
                                                onclick="copyToClipboard('0321-4735908','copy-whatsapp')"
                                                class="self-end sm:self-auto bg-white border border-gray-200 text-xs font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1.5 shadow-sm hover:border-gray-300 transition shrink-0">
                                                <i class="fa-regular fa-copy"></i>
                                                <span>Copy</span>
                                            </button>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="mt-8">
                                <button type="submit"
                                    class="w-full bg-[#0a1f44] hover:bg-[#0d2a5c] text-white font-bold py-4 rounded-xl flex items-center justify-center gap-3 transition shadow-md text-base">
                                    <i class="fa-solid fa-lock"></i> Submit & Place Order
                                </button>
                                <p class="text-center text-xs text-gray-400 mt-3 flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-shield-halved"></i> Your information is secure and encrypted
                                </p>
                            </div>
                        </form>
                    @else
                        {{-- STEP 1: COMPLETE YOUR PAYMENT --}}
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-9 h-9 rounded-full bg-[#0a1f44] text-white flex items-center justify-center font-bold text-sm shrink-0">
                                1</div>
                            <div>
                                <h2 class="text-xl sm:text-2xl font-extrabold text-[#0a1f44]">Complete Your Payment</h2>
                                <p class="text-sm text-gray-500">No payment gateway is integrated. Please pay manually
                                    using one of
                                    the methods below.</p>
                            </div>
                        </div>

                        {{-- Tab Buttons --}}
                        <div class="flex mt-4 bg-slate-100 rounded-xl p-1 gap-1">
                            <button type="button" id="tab-qr"
                                class="flex-1 py-2.5 px-2 rounded-lg font-bold text-xs sm:text-sm flex items-center justify-center gap-1.5 transition duration-200 text-gray-500"
                                onclick="switchTab('qr')">
                                <i class="fa-solid fa-qrcode text-sm sm:text-base"></i>
                                <span class="hidden sm:inline">Method 1 — </span>QR Code
                            </button>
                            <button type="button" id="tab-bank"
                                class="flex-1 py-2.5 px-2 rounded-lg font-bold text-xs sm:text-sm flex items-center justify-center gap-1.5 transition duration-200 bg-[#0a1f44] text-white shadow-sm"
                                onclick="switchTab('bank')">
                                <i class="fa-solid fa-building-columns text-sm sm:text-base"></i>
                                <span class="hidden sm:inline">Method 2 — </span>Bank Info<span
                                    class="hidden sm:inline">rmation</span>
                            </button>
                        </div>

                        {{-- QR Code Tab --}}
                        <div id="content-qr" class="hidden text-center py-8">
                            <div
                                class="max-w-[220px] mx-auto border-4 border-[#0a1f44] rounded-2xl p-3 bg-white shadow-lg">
                                <img src="{{ asset('storage/' . $bank['qr_image']) }}" alt="Payment QR Code"
                                    class="w-full h-auto object-contain rounded-xl" />
                            </div>
                            <h4 class="text-base font-bold text-[#0a1f44] mt-5">Scan QR Code to Pay</h4>
                            <p class="text-xs text-gray-500 mt-1 max-w-xs mx-auto">Use Easypaisa, JazzCash, or any
                                Pakistani banking
                                app to scan and transfer the payment.</p>
                        </div>

                        {{-- Bank Info Tab --}}
                        <div id="content-bank" class="mt-5 space-y-3">
                            <div class="flex items-center gap-4 p-4 bg-slate-50 border border-gray-100 rounded-xl">
                                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-building-columns text-[#0a1f44] text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Bank Name</p>
                                    <p class="font-bold text-[#0a1f44]">{{ $bank['bank_name'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-4 bg-slate-50 border border-gray-100 rounded-xl">
                                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-user text-[#0a1f44] text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Account Title</p>
                                    <p class="font-bold text-[#0a1f44]">{{ $bank['account_title'] }}</p>
                                </div>
                            </div>
                            <div
                                class="flex items-center justify-between gap-4 p-4 bg-slate-50 border border-gray-100 rounded-xl">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-credit-card text-[#0a1f44] text-lg"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs text-gray-400">Account Number</p>
                                        <p class="font-bold text-[#0a1f44] font-mono text-sm break-all">
                                            {{ $bank['account_no'] }}
                                        </p>
                                    </div>
                                </div>
                                <button id="copy-iban"
                                    onclick="copyToClipboard('{{ $bank['iban'] ?: $bank['account_no'] }}','copy-iban')"
                                    class="bg-white border border-gray-200 text-xs font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1 shadow-sm transition shrink-0 hover:border-gray-300">
                                    <i class="fa-regular fa-copy"></i> Copy
                                </button>
                            </div>
                        </div>

                        {{-- Info notice --}}
                        <div
                            class="mt-5 bg-blue-50/50 border border-blue-100 rounded-xl p-4 text-xs text-gray-500 flex items-center gap-3">
                            <i class="fa-solid fa-circle-info text-[#0a1f44] text-base shrink-0"></i>
                            <span>After completing the payment using the details above, please continue to the next step to
                                confirm
                                your payment.</span>
                        </div>

                        <div class="mt-5">
                            <a href="{{ route('checkout.bank', $order->order_number) }}?step=confirm"
                                class="w-full bg-[#0a1f44] hover:bg-[#0d2a5c] text-white font-bold py-3.5 px-4 rounded-xl flex items-center justify-center gap-2 transition shadow-md text-sm">
                                <span class="hidden sm:inline">Continue to Payment Confirmation</span>
                                <span class="sm:hidden">Confirm Payment</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                @else
                    {{-- PAYMENT METHOD SELECTION --}}
                    <h2 class="text-2xl sm:text-3xl font-bold text-[#0a1f44]">Choose Payment Method</h2>
                    <p class="text-sm text-gray-500 mt-1">Select how you would like to pay for your order.</p>

                    <form action="{{ route('checkout.update', ['order' => $order->order_number]) }}" method="post"
                        id="payment-selection-form">
                        @csrf
                        <label
                            class="mt-6 block border-2 border-[#0a1f44] bg-blue-50/40 rounded-xl p-2 sm:p-4 md:p-5 cursor-pointer payment-method-card transition duration-200">
                            <div class="flex items-start gap-2 sm:gap-4">
                                <input type="radio" name="pay" value="cash_on_delivery" checked
                                    class="mt-1 w-4 h-4 sm:w-5 sm:h-5">

                                <div
                                    class="hidden sm:flex w-20 h-20 bg-white rounded-md items-center justify-center flex-shrink-0 border border-gray-200">
                                    <span class="text-3xl">💵</span>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h3 class="text-base sm:text-lg md:text-xl font-bold text-[#0a1f44]">
                                        Cash on Delivery
                                    </h3>

                                    <p class="mt-1 text-xs sm:text-sm text-gray-600">
                                        Pay when your order is delivered
                                    </p>

                                    <p class="mt-2 flex items-start gap-1.5 text-[11px] sm:text-xs text-gray-500">
                                        <i class="fa-solid fa-shield-halved text-[#0a1f44] mt-0.5 shrink-0"></i>
                                        <span>A representative will contact you to confirm your order.</span>
                                    </p>
                                </div>
                            </div>
                        </label>
                        <label
                            class="mt-4 block border border-gray-200 rounded-xl p-2 sm:p-4 md:p-5 cursor-pointer hover:border-[#0a1f44] payment-method-card bg-white transition duration-200">
                            <div class="flex items-start gap-2 sm:gap-4">
                                <input type="radio" name="pay" value="bank_transfer"
                                    class="mt-1 w-4 h-4 sm:w-5 sm:h-5">

                                <div
                                    class="hidden sm:flex w-20 h-20 bg-white rounded-md flex-col items-center justify-center flex-shrink-0 border border-gray-200 gap-1">
                                    <i class="fa-solid fa-building-columns text-[#0a1f44] text-xl"></i>

                                    <div class="flex gap-1 text-[8px] font-bold">
                                        <span class="text-green-600">easypaisa</span>
                                        <span class="text-red-600">JazzCash</span>
                                    </div>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h3 class="text-base sm:text-lg md:text-xl font-bold text-[#0a1f44]">
                                        Bank Transfer / Easypaisa / JazzCash
                                    </h3>

                                    <p class="mt-1 text-xs sm:text-sm text-gray-600">
                                        Pay manually using account details or QR code
                                    </p>

                                    <p class="mt-2 flex items-start gap-1.5 text-[11px] sm:text-xs text-gray-500">
                                        <i class="fa-solid fa-shield-halved text-[#0a1f44] mt-0.5 shrink-0"></i>
                                        <span>You will receive payment details after placing the order.</span>
                                    </p>
                                </div>
                            </div>
                        </label>

                        <div class="mt-6">
                            <button type="submit"
                                class="w-full bg-[#0a1f44] hover:bg-[#0d2a5c] text-white font-semibold
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                py-2.5 sm:py-3
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                px-3 sm:px-4
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                rounded-xl
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                flex items-center justify-center gap-2 sm:gap-3
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                text-sm sm:text-base
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                transition shadow-md">
                                <i class="fa-solid fa-lock text-sm"></i>

                                <span class="truncate">
                                    <span class="sm:hidden">Proceed</span>
                                    <span class="hidden sm:inline">Proceed with Selected Method</span>
                                </span>

                                <i class="fa-solid fa-arrow-right text-sm"></i>
                            </button>
                        </div>
                    </form>
                    <p class="text-center text-xs text-gray-500 mt-4 flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-shield-halved text-[#0a1f44]"></i> Your payments are secure and encrypted.
                    </p>

                    <script>
                        $(document).ready(function() {
                            $('input[name="pay"]').change(function() {
                                $('input[name="pay"]').each(function() {
                                    let label = $(this).closest('.payment-method-card');
                                    if ($(this).is(':checked')) {
                                        label.removeClass('border border-gray-200 bg-white').addClass(
                                            'border-2 border-[#0a1f44] bg-blue-50/40');
                                    } else {
                                        label.removeClass('border-2 border-[#0a1f44] bg-blue-50/40').addClass(
                                            'border border-gray-200 bg-white');
                                    }
                                });
                            });
                        });
                    </script>
                @endif
            </section>


        </div>

        <!-- Trust badges -->

        @include('partials.trust-section')


    </main>

    <script>
        function copyToClipboard(text, buttonId) {
            navigator.clipboard.writeText(text).then(function() {
                const btn = document.getElementById(buttonId);
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-check text-green-500"></i>';
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                }, 2000);
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }

        function switchTab(tab) {
            if (tab === 'qr') {
                $('#tab-qr').removeClass('text-gray-500').addClass('bg-[#0a1f44] text-white shadow-sm');
                $('#tab-bank').removeClass('bg-[#0a1f44] text-white shadow-sm').addClass('text-gray-500');
                $('#content-qr').removeClass('hidden');
                $('#content-bank').addClass('hidden');
            } else {
                $('#tab-bank').removeClass('text-gray-500').addClass('bg-[#0a1f44] text-white shadow-sm');
                $('#tab-qr').removeClass('bg-[#0a1f44] text-white shadow-sm').addClass('text-gray-500');
                $('#content-bank').removeClass('hidden');
                $('#content-qr').addClass('hidden');
            }
        }

        function previewFile(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('upload-preview');
                    const fileIcon = document.getElementById('file-icon');
                    if (file.type.match('image.*')) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        fileIcon.classList.add('hidden');
                    } else if (file.type === 'application/pdf') {
                        preview.classList.add('hidden');
                        fileIcon.classList.remove('hidden');
                        fileIcon.className = 'fa-regular fa-file-pdf text-4xl text-red-500';
                    }
                    document.getElementById('upload-placeholder').classList.add('hidden');
                    document.getElementById('upload-preview-container').classList.remove('hidden');
                    document.getElementById('filename-label').innerText = file.name;
                    document.getElementById('upload-box').classList.add('border-[#0a1f44]', 'bg-blue-50/10');
                }
                reader.readAsDataURL(file);
            }
        }

        $(function() {
            function updateProofCards() {
                $('.proof-card').each(function() {

                    const radio = $(this).find('.proof-radio');

                    if (radio.is(':checked')) {
                        $(this)
                            .removeClass('border-gray-200 bg-white')
                            .addClass('border-2 border-green-500 bg-green-50 shadow-md');
                    } else {
                        $(this)
                            .removeClass('border-2 border-green-500 bg-green-50 shadow-md')
                            .addClass('border border-gray-200 bg-white');
                    }
                });
            }
            $('.proof-card').on('click', function(e) {

                // Ignore if user directly clicked the radio
                if (!$(e.target).is('.proof-radio')) {
                    $(this).find('.proof-radio').prop('checked', true).trigger('change');
                }
            });
            $('.proof-radio').on('change', function() {
                updateProofCards();
            });
            updateProofCards();

        });

        $(function() {

            $('#card-upload').on('click', function() {
                console.log('test')
                $('#payment-upload').show();
                $('#payment-whatsapp').hide();
            });

            $('#card-whatsapp').on('click', function() {
                console.log('hellow')
                $('#payment-whatsapp').show();
                $('#payment-upload').hide();
            });

        });
    </script>
@endsection
