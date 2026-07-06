@extends('layouts.app') {{-- Make sure this matches your main layout blade file name --}}

@section('content')
<div class="py-6 sm:py-10">
    {{-- <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
        <span class="text-xs font-semibold tracking-widest text-indigo-600 uppercase">Get In Touch</span>
        <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
            We'd love to hear from you
        </h1>
        <p class="mt-3 text-lg text-gray-500">
            Have questions about school book bundles, uniform sizes, or delivery timelines? Our team is here to help.
        </p>
    </div> --}}

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <div class="space-y-4 lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Email Us</h3>
                    <p class="text-sm text-gray-500 mt-1">Our team is ready to assist.</p>
                    <a href="mailto:support@bookish.pk" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 block mt-2">support@bookish.pk</a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
                <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Call or WhatsApp</h3>
                    <p class="text-sm text-gray-500 mt-1">Mon-Sat from 9am to 6pm.</p>
                    <a href="https://wa.me/923204735908" target="_blank" class="text-sm font-medium text-green-600 hover:text-green-700 block mt-2">+92 320-4735908</a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/xl" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Headquarters</h3>
                    <p class="text-sm text-gray-500 mt-1">Lahore, Punjab, Pakistan.</p>
                    <span class="text-sm font-medium text-gray-700 block mt-2">Worldwide Shipping Available</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm lg:col-span-2">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Send us a Message</h2>
            
            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                @csrf
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" id="name" required value="{{ old('name') }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-gray-50/50 @error('name') border-red-500 @enderror"
                            placeholder="John Doe">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" required value="{{ old('email') }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-gray-50/50 @error('email') border-red-500 @enderror"
                            placeholder="you@example.com">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number (Optional)</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-gray-50/50"
                        placeholder="0320 1234567">
                </div>

                {{-- <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                    <select name="subject" id="subject" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-gray-50/50">
                        <option value="General Inquiry">General Inquiry</option>
                        <option value="Order Status">Order Status / Tracking</option>
                        <option value="School Partnership">School Bulk Orders</option>
                        <option value="Returns & Exchanges">Returns & Exchanges</option>
                    </select>
                </div> --}}

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Your Message</label>
                    <textarea name="message" id="message" rows="5" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-gray-50/50 @error('message') border-red-500 @enderror"
                        placeholder="Tell us how we can help you...">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full sm:w-auto bg-indigo-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-indigo-700 active:scale-[0.98] transition shadow-md shadow-indigo-100 flex items-center justify-center gap-2">
                        <span>Send Message</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection