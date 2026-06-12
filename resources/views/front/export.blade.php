@extends('layouts.app')
@section('title', __('seo.export_title'))
@section('description', __('seo.export_description'))

@push('structured_data')
@php
$loc = $locale ?? app()->getLocale();

// ── BreadcrumbList ────────────────────────────────────────────────────────
$breadcrumbLd = [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1,
         'name'  => __('breadcrumb.home', [], $loc),
         'item'  => route('home', ['locale' => $loc])],
        ['@type' => 'ListItem', 'position' => 2,
         'name'  => __('breadcrumb.export', [], $loc),
         'item'  => route('export', ['locale' => $loc])],
    ],
];

// ── FAQPage — 5 questions issues des traductions ──────────────────────────
$faqLd = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(fn($i) => [
        '@type'          => 'Question',
        'name'           => __('export.faq_q' . $i, [], $loc),
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => __('export.faq_a' . $i, [], $loc)],
    ], range(1, 5)),
];
@endphp
<script type="application/ld+json">{!! json_encode($breadcrumbLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
<script type="application/ld+json">{!! json_encode($faqLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')
@php $loc = $locale ?? app()->getLocale(); @endphp

{{-- ═══════════ PAGE HERO ═══════════ --}}
<section class="relative overflow-hidden flex flex-col justify-center" style="min-height:460px; background:#0D2D6D;">

    @if(file_exists(public_path('images/banner-export.webp')))
        <div class="absolute inset-0">
            <img src="{{ asset('images/banner-export.webp') }}"
                 alt="BARQAWI Fahrzeughandel – {{ __('export.page_title') }}"
                 class="w-full h-full object-cover object-center"
                 loading="eager" fetchpriority="high">
            <div class="absolute inset-0" style="background:linear-gradient(to right, rgba(13,45,109,0.62) 0%, rgba(13,45,109,0.25) 55%, rgba(13,45,109,0.08) 100%);"></div>
        </div>
    @endif

    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center gap-2 text-sm text-white/50 mb-6">
            <a href="{{ route('home', ['locale' => $loc]) }}" class="hover:text-white transition-colors">{{ __('breadcrumb.home') }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/80 font-medium">{{ __('breadcrumb.export') }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 max-w-xl">{{ __('export.page_title') }}</h1>
        <p class="text-white/65 text-base max-w-md leading-relaxed mb-8">{{ __('export.page_desc') }}</p>
        <a href="#export-form"
           class="inline-flex items-center gap-2 text-white font-semibold px-7 py-3 rounded-xl text-sm transition-opacity hover:opacity-90" style="background:#E30613;">
            {{ __('export.page_cta') }}
        </a>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Destinations --}}
    <div class="mb-12">
        <div class="mb-7">
            <h2 class="text-xl font-bold font-semibold" style="color:#0D2D6D;">{{ __('export.dest_title') }}</h2>
            <p class="text-gray-500 text-sm mt-0.5">{{ __('export.dest_subtitle') }}</p>
        </div>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach([
                ['title'=>__('export.zone_europe_title'), 'desc'=>__('export.zone_europe_desc'),  'features'=>[__('export.zone_europe_f1'), __('export.zone_europe_f2'), __('export.zone_europe_f3')]],
                ['title'=>__('export.zone_maghreb_title'),'desc'=>__('export.zone_maghreb_desc'), 'features'=>[__('export.zone_maghreb_f1'),__('export.zone_maghreb_f2'),__('export.zone_maghreb_f3')]],
                ['title'=>__('export.zone_gulf_title'),   'desc'=>__('export.zone_gulf_desc'),    'features'=>[__('export.zone_gulf_f1'),  __('export.zone_gulf_f2'),  __('export.zone_gulf_f3')]],
            ] as $zone)
                <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-md hover:border-gray-200 hover:shadow-sm transition-all">
                    <h3 class="font-semibold text-base mb-2" style="color:#0D2D6D;">{{ $zone['title'] }}</h3>
                    <p class="text-gray-500 text-sm mb-4 leading-relaxed">{{ $zone['desc'] }}</p>
                    <ul class="space-y-2">
                        @foreach($zone['features'] as $f)
                            <li class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-3.5 h-3.5 shrink-0" style="color:#0D2D6D;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ $f }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

    {{-- How it works --}}
    <div class="bg-gray-50 rounded-2xl p-8 mb-12">
        <h2 class="text-xl font-bold text-center mb-8" style="color:#0D2D6D;">{{ __('export.how_title') }}</h2>
        <div class="relative grid md:grid-cols-4 gap-6">
            <div class="hidden md:block absolute top-7 left-[13%] right-[13%] h-px bg-gray-200"></div>
            @foreach([
                ['n'=>'1','title'=>__('export.step_1_title'),'desc'=>__('export.step_1_desc')],
                ['n'=>'2','title'=>__('export.step_2_title'),'desc'=>__('export.step_2_desc')],
                ['n'=>'3','title'=>__('export.step_3_title'),'desc'=>__('export.step_3_desc')],
                ['n'=>'4','title'=>__('export.step_4_title'),'desc'=>__('export.step_4_desc')],
            ] as $s)
                <div class="text-center relative z-10">
                    <div class="w-14 h-14 text-white rounded-full flex items-center justify-center text-xl font-black mx-auto mb-4" style="background:#E30613;">
                        {{ $s['n'] }}
                    </div>
                    <h3 class="font-semibold mb-2 text-sm" style="color:#0D2D6D;">{{ $s['title'] }}</h3>
                    <p class="text-gray-500 text-xs leading-relaxed">{{ $s['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- FAQ + Form --}}
    <div id="export-form" class="grid lg:grid-cols-2 gap-10">

        {{-- FAQ --}}
        <div x-data="{ open: null }">
            <h2 class="text-xl font-bold mb-6" style="color:#0D2D6D;">{{ __('export.faq_title_section') }}</h2>
            <div class="space-y-3">
                @foreach([
                    ['q'=>__('export.faq_q1'),'a'=>__('export.faq_a1')],
                    ['q'=>__('export.faq_q2'),'a'=>__('export.faq_a2')],
                    ['q'=>__('export.faq_q3'),'a'=>__('export.faq_a3')],
                    ['q'=>__('export.faq_q4'),'a'=>__('export.faq_a4')],
                    ['q'=>__('export.faq_q5'),'a'=>__('export.faq_a5')],
                ] as $i => $item)
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                                class="w-full flex items-center justify-between px-5 py-4 text-sm font-semibold text-left hover:bg-gray-50 transition-colors" style="color:#0D2D6D;">
                            {{ $item['q'] }}
                            <svg :class="open === {{ $i }} ? 'rotate-180 text-[#0D2D6D]' : 'text-gray-400'"
                                 class="w-4 h-4 transition-all shrink-0 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open === {{ $i }}" x-transition class="px-5 pb-4 border-t border-gray-100">
                            <p class="text-sm text-gray-600 leading-relaxed pt-3">{{ $item['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Export form --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-7">
            <h2 class="text-lg font-bold mb-1" style="color:#0D2D6D;">{{ __('export.form_request_title') }}</h2>
            <p class="text-sm text-gray-500 mb-6">{{ __('export.form_request_subtitle') }}</p>

            @if(session('success'))
                <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3 rounded-xl mb-5 alert-anim">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl mb-5">
                    <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('export.store', ['locale' => $loc]) }}" method="POST" class="space-y-4">
                @csrf
                @if(request('vehicle_id'))
                    <input type="hidden" name="vehicle_id" value="{{ request('vehicle_id') }}">
                @endif

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('export.label_name') }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('export.label_email') }}</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('export.label_phone') }}</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+212 6 00 00 00 00"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('export.label_country') }}</label>
                        <select name="country" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none transition-colors">
                            <option value="">{{ __('export.placeholder_country') }}</option>
                            @for($i = 1; $i <= 14; $i++)
                                @php $c = __("export.country_{$i}"); @endphp
                                <option value="{{ $c }}" {{ old('country')===$c?'selected':'' }}>{{ $c }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('export.label_vehicle') }}</label>
                    <input type="text" name="vehicle_info" value="{{ old('vehicle_info') }}" placeholder="{{ __('export.placeholder_vehicle') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('export.label_message') }}</label>
                    <textarea name="message" rows="3" placeholder="{{ __('export.placeholder_message') }}"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none transition-colors resize-none">{{ old('message') }}</textarea>
                </div>

                <label class="flex items-start gap-2.5 text-xs text-gray-500 cursor-pointer">
                    <input type="checkbox" name="consent" required value="1" class="mt-0.5 w-4 h-4 accent-[#0D2D6D] rounded shrink-0">
                    <span>{{ __('export.consent_label') }}</span>
                </label>

                <button type="submit"
                        class="w-full text-white font-semibold py-3.5 rounded-xl text-sm transition-opacity hover:opacity-90" style="background:#0D2D6D;">
                    {{ __('export.submit_btn') }}
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Trust bar --}}
<div class="py-10 mt-10" style="background:#0D2D6D;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6 text-center">
            @foreach([
                ['icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','title'=>__('export.trust_1_title'),'desc'=>__('export.trust_1_desc')],
                ['icon'=>'M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z','title'=>__('export.trust_2_title'),'desc'=>__('export.trust_2_desc')],
                ['icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','title'=>__('export.trust_3_title'),'desc'=>__('export.trust_3_desc')],
                ['icon'=>'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z','title'=>__('export.trust_4_title'),'desc'=>__('export.trust_4_desc')],
                ['icon'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6','title'=>__('export.trust_5_title'),'desc'=>__('export.trust_5_desc')],
            ] as $a)
                <div>
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mx-auto mb-3" style="background:rgba(255,255,255,0.12);">
                        <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $a['icon'] }}"/>
                        </svg>
                    </div>
                    <div class="font-bold text-white text-sm">{{ $a['title'] }}</div>
                    <div class="text-white/45 text-xs mt-0.5">{{ $a['desc'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
