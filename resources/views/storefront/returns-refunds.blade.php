@extends('layouts.app')

@section('title', 'Returns & Refunds Policy - Bookish & Beyond')

@section('content')

    {{-- ===== BREADCRUMB ===== --}}
    <nav class="text-xs text-slate-500 mb-6 flex items-center gap-2 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-[#001F54] transition-colors">Home</a>
        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
        <span class="text-[#001F54] font-semibold">Returns &amp; Refunds</span>
    </nav>

    {{-- ===== HERO BANNER ===== --}}
    <section class="relative overflow-hidden bg-gradient-to-r from-slate-50 via-slate-100 to-indigo-50/50 border border-slate-200/60 rounded-[24px] shadow-sm mb-12 p-8 md:p-12">
        <div class="grid md:grid-cols-12 items-center gap-8 relative z-10">
            <div class="md:col-span-7 flex flex-col justify-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-[#001F54] leading-tight tracking-tight">
                    Returns <span class="text-[#ff7a00]">&amp; Refunds</span>
                </h1>
                <div class="w-14 h-1 bg-[#ff7a00] rounded-full mt-4 mb-4"></div>
                <p class="text-slate-600 text-sm md:text-base max-w-xl leading-relaxed">
                    At Bookish &amp; Beyond, we aim to provide quality products and a reliable shopping experience.
                    Please read our returns and refunds policy carefully.
                </p>
            </div>
            <div class="md:col-span-5 flex justify-center md:justify-end">
                <img src="{{ url('images/contact_hero_collage.png') }}"
                     alt="Returns & Refunds"
                     class="max-h-56 md:max-h-64 object-contain drop-shadow-md hover:scale-105 transition-transform duration-500">
            </div>
        </div>
        <div class="absolute -top-12 -right-12 w-64 h-64 bg-gradient-to-br from-[#001F54]/5 to-transparent rounded-full pointer-events-none"></div>
    </section>

    {{-- ===== POLICY CARDS GRID ===== --}}
    <section class="mb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- 1. Return Period --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,31,84,0.03)] p-7 flex gap-5 group hover:shadow-[0_8px_30px_rgba(0,31,84,0.07)] transition-all duration-300">
                <div class="shrink-0">
                    <div class="w-10 h-10 rounded-full bg-[#001F54] text-white flex items-center justify-center font-extrabold text-base">1</div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="font-extrabold text-[#001F54] text-base leading-snug mb-2">Return Period</h2>
                        <i class="fa-regular fa-calendar-check text-slate-300 text-2xl shrink-0 mt-0.5"></i>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Customers can request a return within <strong class="text-[#001F54]">14 days</strong> from the date of delivery.
                        Return requests made after 14 days may not be accepted.
                    </p>
                </div>
            </div>

            {{-- 2. Return Conditions --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,31,84,0.03)] p-7 flex gap-5 group hover:shadow-[0_8px_30px_rgba(0,31,84,0.07)] transition-all duration-300">
                <div class="shrink-0">
                    <div class="w-10 h-10 rounded-full bg-[#001F54] text-white flex items-center justify-center font-extrabold text-base">2</div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="font-extrabold text-[#001F54] text-base leading-snug mb-2">Return Conditions</h2>
                        <i class="fa-solid fa-clipboard-list text-slate-300 text-2xl shrink-0 mt-0.5"></i>
                    </div>
                    <ul class="text-slate-500 text-sm leading-relaxed space-y-1">
                        <li class="flex items-start gap-2"><span class="text-[#ff7a00] mt-0.5 shrink-0">•</span> Unused and in its original condition</li>
                        <li class="flex items-start gap-2"><span class="text-[#ff7a00] mt-0.5 shrink-0">•</span> Returned with original packaging, tags, labels, and accessories where applicable</li>
                        <li class="flex items-start gap-2"><span class="text-[#ff7a00] mt-0.5 shrink-0">•</span> Not broken, damaged, washed, altered, or used</li>
                        <li class="flex items-start gap-2"><span class="text-[#ff7a00] mt-0.5 shrink-0">•</span> Returned with the original order/invoice details</li>
                    </ul>
                </div>
            </div>

            {{-- 3. Damaged or Broken Products --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,31,84,0.03)] p-7 flex gap-5 group hover:shadow-[0_8px_30px_rgba(0,31,84,0.07)] transition-all duration-300">
                <div class="shrink-0">
                    <div class="w-10 h-10 rounded-full bg-[#001F54] text-white flex items-center justify-center font-extrabold text-base">3</div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="font-extrabold text-[#001F54] text-base leading-snug mb-2">Damaged or Broken Products</h2>
                        <i class="fa-solid fa-shield-halved text-slate-300 text-2xl shrink-0 mt-0.5"></i>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        The returned product should not be broken or damaged by the customer. If the product is returned in broken, damaged, used, or incomplete condition,
                        Bookish &amp; Beyond reserves the right to deduct the repair/replacement cost or reject the return request, depending on the condition of the product.
                        In such cases, the final decision will be made after product inspection.
                    </p>
                </div>
            </div>

            {{-- 4. Refund Method --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,31,84,0.03)] p-7 flex gap-5 group hover:shadow-[0_8px_30px_rgba(0,31,84,0.07)] transition-all duration-300">
                <div class="shrink-0">
                    <div class="w-10 h-10 rounded-full bg-[#001F54] text-white flex items-center justify-center font-extrabold text-base">4</div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="font-extrabold text-[#001F54] text-base leading-snug mb-2">Refund Method</h2>
                        <i class="fa-solid fa-credit-card text-slate-300 text-2xl shrink-0 mt-0.5"></i>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Approved refunds will be processed online to the customer through the available payment/refund method.
                        Refund processing may take a few working days after the returned product has been received and inspected.
                    </p>
                </div>
            </div>

            {{-- 5. Delivery Charges --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,31,84,0.03)] p-7 flex gap-5 group hover:shadow-[0_8px_30px_rgba(0,31,84,0.07)] transition-all duration-300">
                <div class="shrink-0">
                    <div class="w-10 h-10 rounded-full bg-[#001F54] text-white flex items-center justify-center font-extrabold text-base">5</div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="font-extrabold text-[#001F54] text-base leading-snug mb-2">Delivery Charges</h2>
                        <i class="fa-solid fa-truck text-slate-300 text-2xl shrink-0 mt-0.5"></i>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Delivery charges are <strong class="text-[#001F54]">non-refundable</strong>. If a refund is approved, only the product amount will be refunded.
                        Any delivery, shipping, or courier charges paid by the customer will not be returned.
                    </p>
                </div>
            </div>

            {{-- 6. Return Delivery Charges --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,31,84,0.03)] p-7 flex gap-5 group hover:shadow-[0_8px_30px_rgba(0,31,84,0.07)] transition-all duration-300">
                <div class="shrink-0">
                    <div class="w-10 h-10 rounded-full bg-[#001F54] text-white flex items-center justify-center font-extrabold text-base">6</div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="font-extrabold text-[#001F54] text-base leading-snug mb-2">Return Delivery Charges</h2>
                        <i class="fa-solid fa-box-open text-slate-300 text-2xl shrink-0 mt-0.5"></i>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        The customer may be responsible for return delivery/courier charges unless the return is due to a mistake from our side,
                        such as wrong product delivery or a verified defective item.
                    </p>
                </div>
            </div>

            {{-- 7. Non-Returnable Items --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,31,84,0.03)] p-7 flex gap-5 group hover:shadow-[0_8px_30px_rgba(0,31,84,0.07)] transition-all duration-300">
                <div class="shrink-0">
                    <div class="w-10 h-10 rounded-full bg-[#001F54] text-white flex items-center justify-center font-extrabold text-base">7</div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="font-extrabold text-[#001F54] text-base leading-snug mb-2">Non-Returnable Items</h2>
                        <i class="fa-solid fa-ban text-slate-300 text-2xl shrink-0 mt-0.5"></i>
                    </div>
                    <p class="text-slate-500 text-sm mb-2">Some items may not be eligible for return, including:</p>
                    <ul class="text-slate-500 text-sm leading-relaxed space-y-1">
                        <li class="flex items-start gap-2"><span class="text-[#ff7a00] mt-0.5 shrink-0">•</span> Used or washed uniforms</li>
                        <li class="flex items-start gap-2"><span class="text-[#ff7a00] mt-0.5 shrink-0">•</span> Customized or specially ordered products</li>
                        <li class="flex items-start gap-2"><span class="text-[#ff7a00] mt-0.5 shrink-0">•</span> Damaged or broken items caused by customer handling</li>
                        <li class="flex items-start gap-2"><span class="text-[#ff7a00] mt-0.5 shrink-0">•</span> Items without original packaging, tags, or invoice details</li>
                    </ul>
                </div>
            </div>

            {{-- 8. How to Request a Return --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,31,84,0.03)] p-7 flex gap-5 group hover:shadow-[0_8px_30px_rgba(0,31,84,0.07)] transition-all duration-300">
                <div class="shrink-0">
                    <div class="w-10 h-10 rounded-full bg-[#001F54] text-white flex items-center justify-center font-extrabold text-base">8</div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="font-extrabold text-[#001F54] text-base leading-snug mb-2">How to Request a Return</h2>
                        <i class="fa-solid fa-headset text-slate-300 text-2xl shrink-0 mt-0.5"></i>
                    </div>
                    <p class="text-slate-500 text-sm mb-3">To request a return, please contact us with your order details.</p>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2 text-[#001F54] font-semibold">
                            <i class="fa-solid fa-phone text-[#ff7a00] text-xs"></i>
                            <a href="tel:03204735908" class="hover:text-[#ff7a00] transition-colors">0320-4735908</a>
                        </div>
                        <div class="flex items-start gap-2 text-slate-500">
                            <i class="fa-solid fa-location-dot text-[#ff7a00] text-xs mt-1 shrink-0"></i>
                            <span>Shop #3, Welfare Market, Sarwar Road, Lahore Cantt.</span>
                        </div>
                    </div>
                    <p class="text-slate-400 text-xs mt-3 leading-relaxed">
                        Please contact us with your order details and reason for return. Our team will guide you through the process.
                    </p>
                </div>
            </div>

        </div>
    </section>

    {{-- ===== FINAL NOTE ===== --}}
    <div class="bg-[#001F54]/5 border border-[#001F54]/10 rounded-2xl p-6 mb-12 flex gap-4 items-start">
        <div class="w-10 h-10 shrink-0 bg-[#001F54] rounded-xl flex items-center justify-center text-white">
            <i class="fa-solid fa-circle-info text-base"></i>
        </div>
        <div>
            <h3 class="font-extrabold text-[#001F54] text-sm mb-1">Final Note</h3>
            <p class="text-slate-600 text-sm leading-relaxed">
                Bookish &amp; Beyond reserves the right to approve, reject, or partially adjust a return/refund request based on the product condition and return policy.
            </p>
        </div>
    </div>

    {{-- ===== TRUST STRIP ===== --}}
    <section class="bg-white rounded-[20px] shadow-[0_8px_24px_rgba(0,31,84,0.04)] border border-slate-100 p-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
        <div class="flex flex-col items-center text-center gap-2 p-2">
            <div class="w-12 h-12 bg-[#001F54]/5 rounded-xl flex items-center justify-center text-[#001F54]">
                <i class="fa-solid fa-rotate-left text-xl"></i>
            </div>
            <b class="text-[#001F54] font-bold text-xs block leading-tight">Easy Return Window</b>
            <p class="text-xs text-slate-500 leading-normal">14-day hassle-free return policy.</p>
        </div>
        <div class="flex flex-col items-center text-center gap-2 p-2">
            <div class="w-12 h-12 bg-[#001F54]/5 rounded-xl flex items-center justify-center text-[#001F54]">
                <i class="fa-solid fa-credit-card text-xl"></i>
            </div>
            <b class="text-[#001F54] font-bold text-xs block leading-tight">Online Refunds</b>
            <p class="text-xs text-slate-500 leading-normal">Secure online refunds to your payment method.</p>
        </div>
        <div class="flex flex-col items-center text-center gap-2 p-2">
            <div class="w-12 h-12 bg-[#001F54]/5 rounded-xl flex items-center justify-center text-[#001F54]">
                <i class="fa-solid fa-shield-halved text-xl"></i>
            </div>
            <b class="text-[#001F54] font-bold text-xs block leading-tight">Transparent Policy</b>
            <p class="text-xs text-slate-500 leading-normal">Clear terms and fair processing every time.</p>
        </div>
        <div class="flex flex-col items-center text-center gap-2 p-2">
            <div class="w-12 h-12 bg-[#001F54]/5 rounded-xl flex items-center justify-center text-[#001F54]">
                <i class="fa-solid fa-headset text-xl"></i>
            </div>
            <b class="text-[#001F54] font-bold text-xs block leading-tight">Support Available</b>
            <p class="text-xs text-slate-500 leading-normal">We're here to help you at every step.</p>
        </div>
    </section>

@endsection