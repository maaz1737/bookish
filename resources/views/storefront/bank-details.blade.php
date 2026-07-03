@extends('layouts.app')


@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @php
            $currentStep = request()->get('step') === 'confirm' ? 'confirm' : 'method';
            $steps = [
                ['icon' => '🛒', 'label' => 'Cart', 'active' => false, 'completed' => true],
                ['icon' => '🚚', 'label' => 'Checkout', 'active' => false, 'completed' => true],
                ['icon' => '💳', 'label' => 'Payment Method', 'active' => ($currentStep === 'method'), 'completed' => ($currentStep === 'confirm')],
                ['icon' => '📤', 'label' => 'Payment Confirmation', 'active' => ($currentStep === 'confirm'), 'completed' => false],
                ['icon' => '✓', 'label' => 'Confirmation', 'active' => false, 'completed' => false],
            ];
        @endphp

        <div class="max-w-5xl mx-auto px-4 pt-2">
            <div class="flex items-center justify-between text-xs text-gray-500">
                @foreach ($steps as $i => $s)
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center transition-all duration-300
                            {{ $s['active'] || $s['completed'] ? 'bg-[#0a1f44] text-white border-[#0a1f44] shadow-sm' : 'bg-white text-gray-400 border-gray-300' }}">
                            @if ($s['completed'])
                                <i class="fa-solid fa-check text-xs"></i>
                            @else
                                <span>{{ $s['icon'] }}</span>
                            @endif
                        </div>
                        <div class="mt-2 text-center text-[11px] transition-all duration-300 {{ $s['active'] ? 'text-[#0a1f44] font-semibold' : 'text-gray-400' }}">
                            {{ $s['label'] }}
                        </div>
                    </div>
                    @if ($i < count($steps) - 1)
                        <div class="flex-1 h-px -mt-6 transition-all duration-300 {{ $s['completed'] ? 'bg-[#0a1f44]' : 'bg-gray-300' }}"></div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Content grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-10 max-w-5xl mx-auto">

            <!-- Payment methods (2/3) -->
            <section class="lg:col-span-2 bg-white border border-gray-200 rounded-xl p-6 sm:p-8 shadow-sm">
                @if ($order->payment_method === 'bank_transfer')

                    @if ($order->payment_status === 'proof_submitted')
                        {{-- PROOF SUBMITTED STATE --}}
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 text-center space-y-4">
                            <div class="w-14 h-14 rounded-full bg-amber-100 flex items-center justify-center mx-auto text-amber-600 text-2xl">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <h3 class="text-xl font-bold text-[#0a1f44]">Payment Proof Submitted</h3>
                            <p class="text-sm text-gray-600 max-w-md mx-auto">
                                We have received your payment receipt. Our team is verifying the transaction. This usually takes 1–2 hours.
                            </p>
                            @if ($order->latestProof)
                                @if ($order->latestProof->screenshot_path === 'whatsapp')
                                    <div class="inline-flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-xs font-semibold px-4 py-2 rounded-xl">
                                        <i class="fa-brands fa-whatsapp text-lg"></i> Payment receipt shared via WhatsApp
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <p class="text-xs font-semibold text-gray-400 mb-2">Uploaded Screenshot:</p>
                                        <div class="max-w-[200px] mx-auto border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                                            <img src="{{ asset('storage/' . $order->latestProof->screenshot_path) }}" alt="Payment proof" class="w-full h-auto object-contain max-h-[150px] cursor-pointer" onclick="window.open(this.src)" />
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <div class="pt-2">
                                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-[#0a1f44] hover:bg-[#0d2a5c] text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">
                                    <i class="fa-solid fa-house"></i> Continue Shopping
                                </a>
                            </div>
                        </div>

                    @elseif ($order->payment_status === 'paid')
                        {{-- PAID STATE --}}
                        <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center space-y-4">
                            <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mx-auto text-green-600 text-2xl">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <h3 class="text-xl font-bold text-[#0a1f44]">Payment Verified!</h3>
                            <p class="text-sm text-gray-600 max-w-md mx-auto">
                                Thank you! Your payment has been successfully verified and your order is now being processed.
                            </p>
                            <div class="pt-2">
                                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-[#0a1f44] hover:bg-[#0d2a5c] text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">
                                    <i class="fa-solid fa-house"></i> Continue Shopping
                                </a>
                            </div>
                        </div>

                    @elseif ($currentStep === 'confirm')
                        {{-- STEP 2: CONFIRM YOUR PAYMENT --}}
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-9 h-9 rounded-full bg-[#0a1f44] text-white flex items-center justify-center font-bold text-sm shrink-0">2</div>
                            <div>
                                <h2 class="text-xl sm:text-2xl font-extrabold text-[#0a1f44]">Confirm Your Payment</h2>
                                <p class="text-sm text-gray-500">Please confirm how you have made the payment for your order.</p>
                            </div>
                        </div>

                        @if ($order->latestProof && $order->latestProof->status === 'rejected')
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-red-800 mb-5 space-y-1">
                                <h4 class="font-bold flex items-center gap-2 text-sm text-red-700">
                                    <i class="fa-solid fa-circle-xmark text-red-600"></i> Payment Verification Failed
                                </h4>
                                <p class="text-xs text-gray-700">Your previous submission was rejected. Please re-submit:</p>
                                <div class="bg-white/80 rounded border border-red-100 p-2.5 text-xs font-mono mt-2 text-red-700">
                                    <strong>Reason:</strong> {{ $order->latestProof->admin_note ?: 'No detail provided.' }}
                                </div>
                            </div>
                        @endif

                        <p class="text-sm font-bold text-[#0a1f44] mb-4">How would you like to confirm your payment? <span class="text-gray-400 font-normal">Choose one of the options below.</span></p>

                        <form action="{{ route('checkout.proof', $order->order_number) }}" method="post" enctype="multipart/form-data" id="confirm-payment-form">
                            @csrf
                            <input type="hidden" name="confirm_method" id="confirm_method" value="upload" />

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start relative">

                                {{-- Option 1: Upload --}}
                                <div id="card-upload" class="flex flex-col border-2 border-[#0a1f44] bg-blue-50/20 rounded-2xl p-5 cursor-pointer transition duration-200">
                                    <div class="flex items-start gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 text-[#0a1f44] flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-extrabold text-[#0a1f44] text-sm">Option 1: Upload Payment Receipt</h4>
                                            <p class="text-xs text-gray-500">Upload a screenshot or photo of your payment receipt.</p>
                                        </div>
                                    </div>

                                    <div class="border-2 border-dashed border-gray-200 hover:border-[#0a1f44] rounded-xl p-6 text-center cursor-pointer transition relative bg-white" id="upload-box">
                                        <input type="file" name="screenshot" id="screenshot-input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*,application/pdf" onchange="previewFile(this)" />
                                        <div class="space-y-2" id="upload-placeholder">
                                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-300"></i>
                                            <p class="text-sm font-bold text-[#0a1f44]">Drag & drop your file here</p>
                                            <p class="text-[11px] text-gray-400">or <span class="bg-gray-100 border rounded px-2 py-0.5 text-gray-600">Choose File</span></p>
                                            <p class="text-[10px] text-gray-400">JPG, PNG, PDF (Max. 5MB)</p>
                                        </div>
                                        <div class="hidden space-y-2" id="upload-preview-container">
                                            <i class="fa-regular fa-file-image text-4xl text-green-400 hidden" id="file-icon"></i>
                                            <img id="upload-preview" class="max-h-[100px] mx-auto rounded border shadow-sm hidden" />
                                            <p class="text-xs text-[#0a1f44] font-semibold break-all" id="filename-label"></p>
                                            <p class="text-[10px] text-gray-400">Click or drag to change</p>
                                        </div>
                                    </div>
                                    @error('screenshot')
                                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror

                                    <div class="mt-3 bg-blue-50 border border-blue-100 rounded-lg p-3 text-xs text-gray-500 flex items-start gap-2">
                                        <i class="fa-solid fa-circle-info text-[#0a1f44] mt-0.5 shrink-0"></i>
                                        <span>Please make sure the receipt is clear and shows the transaction details (date, amount, reference number).</span>
                                    </div>
                                </div>

                                {{-- OR Badge for desktop --}}
                                <div class="hidden md:flex justify-center items-center my-2 md:absolute md:left-1/2 md:top-1/3 md:-translate-x-1/2 md:-translate-y-1/2 z-10 pointer-events-none">
                                    <div class="w-9 h-9 rounded-full bg-white border-2 border-gray-200 flex items-center justify-center text-xs font-bold text-gray-400 shadow-sm">OR</div>
                                </div>

                                {{-- Option 2: WhatsApp --}}
                                <div id="card-whatsapp" class="flex flex-col border border-gray-200 bg-white rounded-2xl p-5 cursor-pointer transition duration-200">
                                    <div class="flex items-start gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                                            <i class="fa-brands fa-whatsapp text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-extrabold text-[#0a1f44] text-sm">Option 2: Shared on WhatsApp</h4>
                                            <p class="text-xs text-gray-500">Share your payment receipt on WhatsApp using the number below.</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between bg-green-50 border border-green-100 rounded-xl p-3 mb-4">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-brands fa-whatsapp text-green-600 text-xl"></i>
                                            <span class="font-mono text-base font-bold text-[#0a1f44]">0320-4735908</span>
                                        </div>
                                        <button type="button" id="copy-whatsapp" onclick="copyToClipboard('03204735908','copy-whatsapp')" class="bg-white border border-gray-200 text-xs font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1.5 shadow-sm transition hover:border-gray-300 shrink-0">
                                            <i class="fa-regular fa-copy"></i>
                                        </button>
                                    </div>

                                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-xs space-y-2">
                                        <h5 class="font-bold text-red-600 flex items-center gap-1.5">
                                            <i class="fa-solid fa-triangle-exclamation"></i> Acknowledgement <span class="text-red-600">(Required)</span>
                                        </h5>
                                        <p class="text-gray-500">By selecting this option, you acknowledge and agree that:</p>
                                        <ul class="space-y-1.5 text-gray-700">
                                            <li class="flex items-start gap-1.5">
                                                <i class="fa-solid fa-circle-check text-amber-500 mt-0.5 shrink-0"></i>
                                                <span>I have shared the payment receipt on WhatsApp at 0320-4735908.</span>
                                            </li>
                                            <li class="flex items-start gap-1.5">
                                                <i class="fa-solid fa-circle-check text-amber-500 mt-0.5 shrink-0"></i>
                                                <span>My order will remain pending until Bookish & Beyond verifies my payment.</span>
                                            </li>
                                            <li class="flex items-start gap-1.5">
                                                <i class="fa-solid fa-circle-check text-amber-500 mt-0.5 shrink-0"></i>
                                                <span>Bookish & Beyond will contact me once the payment is verified.</span>
                                            </li>
                                        </ul>
                                        <label class="flex items-center gap-2 mt-3 pt-2 border-t border-amber-200/60 cursor-pointer">
                                            <input type="checkbox" name="whatsapp_agree" id="whatsapp_agree" value="1" class="rounded" onclick="event.stopPropagation()" />
                                            <span class="font-bold text-gray-700">I understand and agree to the above. <span class="text-red-600">*</span></span>
                                        </label>
                                        @error('whatsapp_agree')
                                            <p class="text-red-500 text-[10px] mt-1 font-semibold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8">
                                <button type="submit" class="w-full bg-[#0a1f44] hover:bg-[#0d2a5c] text-white font-bold py-4 rounded-xl flex items-center justify-center gap-3 transition shadow-md text-base">
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
                            <div class="w-9 h-9 rounded-full bg-[#0a1f44] text-white flex items-center justify-center font-bold text-sm shrink-0">1</div>
                            <div>
                                <h2 class="text-xl sm:text-2xl font-extrabold text-[#0a1f44]">Complete Your Payment</h2>
                                <p class="text-sm text-gray-500">No payment gateway is integrated. Please pay manually using one of the methods below.</p>
                            </div>
                        </div>

                        {{-- Tab Buttons --}}
                        <div class="flex mt-4 bg-slate-100 rounded-xl p-1 gap-1">
                            <button type="button" id="tab-qr"
                                class="flex-1 py-2.5 px-3 rounded-lg font-bold text-sm flex items-center justify-center gap-2 transition duration-200 text-gray-500 hover:text-[#0a1f44]"
                                onclick="switchTab('qr')">
                                <i class="fa-solid fa-qrcode"></i> Method 1 — QR Code
                            </button>
                            <button type="button" id="tab-bank"
                                class="flex-1 py-2.5 px-3 rounded-lg font-bold text-sm flex items-center justify-center gap-2 transition duration-200 bg-[#0a1f44] text-white shadow-sm"
                                onclick="switchTab('bank')">
                                <i class="fa-solid fa-building-columns"></i> Method 2 — Bank Information
                            </button>
                        </div>

                        {{-- QR Code Tab --}}
                        <div id="content-qr" class="hidden text-center py-8">
                            <div class="max-w-[220px] mx-auto border-4 border-[#0a1f44] rounded-2xl p-3 bg-white shadow-lg">
                                <img src="{{ asset('storage/payment_qr.png') }}" alt="Payment QR Code" class="w-full h-auto object-contain rounded-xl" />
                            </div>
                            <h4 class="text-base font-bold text-[#0a1f44] mt-5">Scan QR Code to Pay</h4>
                            <p class="text-xs text-gray-500 mt-1 max-w-xs mx-auto">Use Easypaisa, JazzCash, or any Pakistani banking app to scan and transfer the payment.</p>
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
                            <div class="flex items-center justify-between gap-4 p-4 bg-slate-50 border border-gray-100 rounded-xl">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-credit-card text-[#0a1f44] text-lg"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs text-gray-400">Account Number / IBAN</p>
                                        <p class="font-bold text-[#0a1f44] font-mono text-sm break-all">{{ $bank['iban'] ?: $bank['account_no'] }}</p>
                                    </div>
                                </div>
                                <button id="copy-iban" onclick="copyToClipboard('{{ $bank['iban'] ?: $bank['account_no'] }}','copy-iban')" class="bg-white border border-gray-200 text-xs font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1 shadow-sm transition shrink-0 hover:border-gray-300">
                                    <i class="fa-regular fa-copy"></i> Copy
                                </button>
                            </div>
                            {{-- <div class="flex items-center justify-between gap-4 p-4 bg-slate-50 border border-gray-100 rounded-xl">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-mobile-screen-button text-green-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Easypaisa Number <span class="text-gray-300">(optional)</span></p>
                                        <p class="font-bold text-[#0a1f44] font-mono text-sm">{{ $bank['raast_id'] }}</p>
                                    </div>
                                </div>
                                <button id="copy-ep" onclick="copyToClipboard('{{ $bank['raast_id'] }}','copy-ep')" class="bg-white border border-gray-200 text-xs font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1 shadow-sm transition shrink-0 hover:border-gray-300">
                                    <i class="fa-regular fa-copy"></i> Copy
                                </button>
                            </div> --}}
                            {{-- <div class="flex items-center justify-between gap-4 p-4 bg-slate-50 border border-gray-100 rounded-xl">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-mobile-screen-button text-red-500 text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">JazzCash Number <span class="text-gray-300">(optional)</span></p>
                                        <p class="font-bold text-[#0a1f44] font-mono text-sm">{{ $bank['raast_id'] }}</p>
                                    </div>
                                </div>
                                <button id="copy-jc" onclick="copyToClipboard('{{ $bank['raast_id'] }}','copy-jc')" class="bg-white border border-gray-200 text-xs font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1 shadow-sm transition shrink-0 hover:border-gray-300">
                                    <i class="fa-regular fa-copy"></i> Copy
                                </button>
                            </div> --}}
                        </div>

                        {{-- Info notice --}}
                        <div class="mt-5 bg-blue-50/50 border border-blue-100 rounded-xl p-4 text-xs text-gray-500 flex items-center gap-3">
                            <i class="fa-solid fa-circle-info text-[#0a1f44] text-base shrink-0"></i>
                            <span>After completing the payment using the details above, please continue to the next step to confirm your payment.</span>
                        </div>

                        {{-- Continue Button --}}
                        <div class="mt-5">
                            <a href="{{ route('checkout.bank', $order->order_number) }}?step=confirm"
                                class="w-full bg-[#0a1f44] hover:bg-[#0d2a5c] text-white font-bold py-3.5 rounded-xl flex items-center justify-center gap-2 transition shadow-md text-sm">
                                Continue to Payment Confirmation
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    @endif

                @else
                    {{-- PAYMENT METHOD SELECTION --}}
                    <h2 class="text-2xl sm:text-3xl font-bold text-[#0a1f44]">Choose Payment Method</h2>
                    <p class="text-sm text-gray-500 mt-1">Select how you would like to pay for your order.</p>

                    <form action="{{ route('checkout.update', ['order' => $order->order_number]) }}" method="post" id="payment-selection-form">
                        @csrf
                        <label class="mt-6 block border-2 border-[#0a1f44] bg-blue-50/40 rounded-xl p-4 sm:p-5 cursor-pointer payment-method-card transition duration-200">
                            <div class="flex items-start gap-4">
                                <input type="radio" name="pay" value="cash_on_delivery" checked="" class="mt-1 w-5 h-5">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-md flex items-center justify-center flex-shrink-0 border border-gray-200">
                                    <span class="text-3xl">💵</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-lg sm:text-xl font-bold text-[#0a1f44]">Cash on Delivery</h3>
                                    <p class="text-sm text-gray-600">Pay when your order is delivered</p>
                                    <p class="text-xs text-gray-500 mt-2 flex items-center gap-1.5">
                                        <i class="fa-solid fa-shield-halved text-[#0a1f44]"></i>
                                        A representative will contact you to confirm your order.
                                    </p>
                                </div>
                            </div>
                        </label>

                        <label class="mt-4 block border border-gray-200 rounded-xl p-4 sm:p-5 cursor-pointer hover:border-[#0a1f44] payment-method-card bg-white transition duration-200">
                            <div class="flex items-start gap-4">
                                <input type="radio" name="pay" value="bank_transfer" class="mt-1 w-5 h-5">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-md flex flex-col items-center justify-center flex-shrink-0 border border-gray-200 gap-1">
                                    <i class="fa-solid fa-building-columns text-[#0a1f44] text-xl"></i>
                                    <div class="flex gap-1 text-[8px] font-bold">
                                        <span class="text-green-600">easypaisa</span>
                                        <span class="text-red-600">JazzCash</span>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-lg sm:text-xl font-bold text-[#0a1f44]">Bank Transfer / Easypaisa / JazzCash</h3>
                                    <p class="text-sm text-gray-600">Pay manually using account details or QR code</p>
                                    <p class="text-xs text-gray-500 mt-2 flex items-center gap-1.5">
                                        <i class="fa-solid fa-shield-halved text-[#0a1f44]"></i>
                                        You will receive payment details after placing the order.
                                    </p>
                                </div>
                            </div>
                        </label>

                        <div class="mt-6">
                            <button type="submit" class="w-full bg-[#0a1f44] hover:bg-[#0d2a5c] text-white font-semibold py-3 rounded-xl flex items-center justify-center gap-3 transition shadow-md">
                                <i class="fa-solid fa-lock"></i>
                                Proceed with Selected Method
                                <i class="fa-solid fa-arrow-right"></i>
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
                                        label.removeClass('border border-gray-200 bg-white').addClass('border-2 border-[#0a1f44] bg-blue-50/40');
                                    } else {
                                        label.removeClass('border-2 border-[#0a1f44] bg-blue-50/40').addClass('border border-gray-200 bg-white');
                                    }
                                });
                            });
                        });
                    </script>
                @endif
            </section>

            <!-- Order summary -->
            <aside class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="relative">
                            <i class="fa-solid fa-bag-shopping text-[#0a1f44] text-xl"></i>
                            <span class="absolute -top-2 -right-3 bg-amber-500 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ count($order->items) }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-[#0a1f44] ml-2">Order Summary</h3>
                    </div>
                </div>

                <div class="mt-5 space-y-4">
                    @foreach ($order->items as $item)
                        <div class="flex gap-3">
                            <div class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center flex-shrink-0">
                                @php
                                    $image = $item->product?->images[0] ?? null;
                                @endphp
                                @if ($image)
                                    <img src="{{ app()->environment('production') ? asset('storage/' . $image) : asset('storage/' . $image) }}"
                                        alt="{{ $item->product?->name ?? 'Product' }}"
                                        class="w-full h-full object-contain rounded-md"
                                        onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}" alt="Image not found"
                                        class="w-full h-full object-contain rounded-md">
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex justify-between gap-2">
                                    <h4 class="font-semibold text-sm text-[#0a1f44]">{{ $item->product->name }}</h4>
                                    <span class="text-sm font-bold text-[#0a1f44] whitespace-nowrap">PKR {{ number_format($item->line_total) }}</span>
                                </div>
                                <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 mt-5 pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal ({{ count($order->items) }} items)</span>
                        <span class="font-semibold text-[#0a1f44]">PKR {{ number_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 flex items-center gap-1">Delivery Charges <i class="fa-regular fa-circle-question text-xs"></i></span>
                        <span class="font-semibold text-[#0a1f44]">PKR {{ number_format($order->shippingRate->price) }}</span>
                    </div>
                </div>

                <div class="bg-gray-50 -mx-6 px-6 py-4 mt-4 flex justify-between items-center rounded-b-xl">
                    <span class="text-lg font-bold text-[#0a1f44]">Total Amount</span>
                    <span class="text-xl font-extrabold text-[#0a1f44]">PKR {{ number_format($order->total_amount) }}</span>
                </div>

                <div class="mt-4 bg-blue-50 border border-blue-100 rounded-lg p-3 text-xs text-gray-500 flex items-start gap-2">
                    <i class="fa-solid fa-shield-halved text-[#0a1f44] mt-0.5 shrink-0"></i>
                    <span>Your payment is secure. After manual payment, you will proceed to the Payment Confirmation step.</span>
                </div>

                <div class="mt-3 flex items-center gap-1.5 justify-center text-xs text-gray-400">
                    <i class="fa-solid fa-lock text-xs"></i> Secure payments. Multiple payment options available.
                </div>
            </aside>
        </div>

        <!-- Trust badges -->
        <div class="mt-8 border border-gray-200 rounded-xl p-6 bg-white max-w-5xl mx-auto">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                <div class="flex items-center gap-3"><i class="fa-solid fa-shield-halved text-2xl text-[#0a1f44]"></i>
                    <div>
                        <p class="text-sm font-bold text-[#0a1f44]">100% Original Products</p>
                        <p class="text-xs text-gray-500">Sourced from authorized suppliers</p>
                    </div>
                </div>
                <div class="flex items-center gap-3"><i class="fa-solid fa-truck text-2xl text-[#0a1f44]"></i>
                    <div>
                        <p class="text-sm font-bold text-[#0a1f44]">Fast & Reliable Delivery</p>
                        <p class="text-xs text-gray-500">Across Pakistan</p>
                    </div>
                </div>
                <div class="flex items-center gap-3"><i class="fa-solid fa-credit-card text-2xl text-[#0a1f44]"></i>
                    <div>
                        <p class="text-sm font-bold text-[#0a1f44]">Secure Payments</p>
                        <p class="text-xs text-gray-500">Multiple payment options</p>
                    </div>
                </div>
                <div class="flex items-center gap-3"><i class="fa-solid fa-rotate-left text-2xl text-[#0a1f44]"></i>
                    <div>
                        <p class="text-sm font-bold text-[#0a1f44]">Easy Returns</p>
                        <p class="text-xs text-gray-500">Hassle-free returns within 7 days</p>
                    </div>
                </div>
                <div class="flex items-center gap-3"><i class="fa-solid fa-headset text-2xl text-[#0a1f44]"></i>
                    <div>
                        <p class="text-sm font-bold text-[#0a1f44]">Dedicated Support</p>
                        <p class="text-xs text-gray-500">We're here to help you anytime</p>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        function copyToClipboard(text, buttonId) {
            navigator.clipboard.writeText(text).then(function() {
                const btn = document.getElementById(buttonId);
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-check text-green-500"></i>';
                setTimeout(() => { btn.innerHTML = originalHtml; }, 2000);
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

        $(document).ready(function() {
            $('#card-upload').click(function() {
                $('#confirm_method').val('upload');
                $(this).removeClass('border border-gray-200 bg-white').addClass('border-2 border-[#0a1f44] bg-blue-50/20');
                $('#card-whatsapp').removeClass('border-2 border-[#0a1f44] bg-blue-50/20').addClass('border border-gray-200 bg-white');
                $('#screenshot-input').prop('required', true);
                $('#whatsapp_agree').prop('required', false);
            });

            $('#card-whatsapp').click(function() {
                $('#confirm_method').val('whatsapp');
                $(this).removeClass('border border-gray-200 bg-white').addClass('border-2 border-[#0a1f44] bg-blue-50/20');
                $('#card-upload').removeClass('border-2 border-[#0a1f44] bg-blue-50/20').addClass('border border-gray-200 bg-white');
                $('#screenshot-input').prop('required', false);
                $('#whatsapp_agree').prop('required', true);
            });
        });
    </script>
@endsection
