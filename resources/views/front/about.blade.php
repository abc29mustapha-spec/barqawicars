@extends('layouts.app')
@section('title', __('seo.about_title'))
@section('description', __('seo.about_description'))

@push('structured_data')
@php
$loc = $locale ?? app()->getLocale();
$breadcrumbLd = [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1,
         'name'  => __('breadcrumb.home', [], $loc),
         'item'  => route('home', ['locale' => $loc])],
        ['@type' => 'ListItem', 'position' => 2,
         'name'  => __('breadcrumb.about', [], $loc),
         'item'  => route('about', ['locale' => $loc])],
    ],
];

// Person schema — fondateur identifiable par Google pour E-E-A-T
$personLd = [
    '@context'    => 'https://schema.org',
    '@type'       => 'Person',
    'name'        => 'Barqawi',
    'jobTitle'    => 'Founder and Director, BARQAWI Fahrzeughandel',
    'description' => 'Automotive import/export specialist based in Fellbach, Germany. Founded BARQAWI Fahrzeughandel in 2012, serving clients across France, Europe and North Africa.',
    'worksFor'    => [
        '@type' => 'AutoDealer',
        'name'  => 'BARQAWI Fahrzeughandel',
        'url'   => 'https://barqawi-cars.de',
    ],
    'address' => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => 'Salierstr. 44',
        'addressLocality' => 'Fellbach',
        'addressRegion'   => 'Baden-Württemberg',
        'postalCode'      => '70736',
        'addressCountry'  => 'DE',
    ],
    'url'         => route('about', ['locale' => 'de']),
    'knowsAbout'  => [
        'Automotive import/export',
        'German car market',
        'Vehicle export to France',
        'Vehicle export to North Africa',
        'COC documentation',
        'Premium used vehicles Germany',
    ],
    'knowsLanguage' => ['French', 'German', 'Arabic'],
    'sameAs' => [
        'https://www.facebook.com/barqawicars',
        'https://www.google.com/maps/place/Salierstr.+44,+70736+Fellbach',
    ],
];
@endphp
<script type="application/ld+json">{!! json_encode($breadcrumbLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
<script type="application/ld+json">{!! json_encode($personLd,     JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')
@php $loc = $locale ?? app()->getLocale(); @endphp

{{-- Hero --}}
<section class="relative overflow-hidden flex flex-col justify-center" style="min-height:420px; background:#0D2D6D;">
    @if(file_exists(public_path('images/aproposbarqawi.webp')))
        <div class="absolute inset-0">
            <img src="{{ asset('images/aproposbarqawi.webp') }}"
                 alt="BARQAWI Fahrzeughandel – {{ __('about.page_title') }}"
                 class="w-full h-full object-cover object-center"
                 loading="eager" fetchpriority="high">
            <div class="absolute inset-0" style="background:linear-gradient(to right, rgba(13,45,109,0.62) 0%, rgba(13,45,109,0.25) 55%, rgba(13,45,109,0.08) 100%);"></div>
        </div>
    @endif
    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center gap-2 text-sm text-white/50 mb-6">
            <a href="{{ route('home', ['locale' => $loc]) }}" class="hover:text-white transition-colors">{{ __('breadcrumb.home') }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/80 font-medium">{{ __('breadcrumb.about') }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 max-w-xl">{{ __('about.page_title') }}</h1>
        <p class="text-white/65 text-base max-w-md leading-relaxed">{{ __('about.page_desc') }}</p>
    </div>
</section>

{{-- Story --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
            <div>
                <h2 class="text-2xl font-bold mb-5" style="color:#0D2D6D;">{{ __('about.story_title') }}</h2>
                <p class="text-gray-600 leading-relaxed mb-4 text-sm">{{ __('about.story_p1') }}</p>
                <p class="text-gray-600 leading-relaxed mb-8 text-sm">{{ __('about.story_p2') }}</p>
                <div class="flex flex-col gap-3">
                    @foreach([
                        __('about.check_1'), __('about.check_2'), __('about.check_3'), __('about.check_4'),
                        __('about.check_5'), __('about.check_6'), __('about.check_7'), __('about.check_8'),
                    ] as $v)
                        <div class="flex items-center gap-3 text-sm text-gray-700">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center shrink-0" style="background:#EEF2FF;">
                                <svg class="w-3 h-3" style="color:#0D2D6D;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                            {{ $v }}
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                @foreach([
                    ['year'=>__('about.milestone_1_year'),'title'=>__('about.milestone_1_title'),'desc'=>__('about.milestone_1_desc')],
                    ['year'=>__('about.milestone_2_year'),'title'=>__('about.milestone_2_title'),'desc'=>__('about.milestone_2_desc')],
                    ['year'=>__('about.milestone_3_year'),'title'=>__('about.milestone_3_title'),'desc'=>__('about.milestone_3_desc')],
                    ['year'=>__('about.milestone_4_year'),'title'=>__('about.milestone_4_title'),'desc'=>__('about.milestone_4_desc')],
                ] as $m)
                    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 text-center hover:border-gray-200 hover:shadow-sm transition-all">
                        <div class="text-sm font-bold mb-1" style="color:#E30613;">{{ $m['year'] }}</div>
                        <div class="font-semibold text-sm mb-1" style="color:#0D2D6D;">{{ $m['title'] }}</div>
                        <div class="text-xs text-gray-500 leading-relaxed">{{ $m['desc'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Our Services --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold" style="color:#0D2D6D;">{{ __('about.services_section_title') }}</h2>
            <p class="text-gray-500 text-sm mt-1.5">{{ __('about.services_section_subtitle') }}</p>
        </div>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-gray-50 border border-gray-100 rounded-2xl p-7">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-5" style="background:#EEF2FF;">
                    <svg class="w-5 h-5" style="color:#0D2D6D;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-base mb-4" style="color:#0D2D6D;">{{ __('about.services_import_title') }}</h3>
                <ul class="space-y-2.5">
                    @foreach([
                        __('about.import_1'), __('about.import_2'), __('about.import_3'),
                        __('about.import_4'), __('about.import_5'), __('about.import_6'),
                        __('about.import_7'), __('about.import_8'), __('about.import_9'),
                    ] as $item)
                        <li class="flex items-start gap-2.5 text-sm text-gray-600">
                            <svg class="w-4 h-4 shrink-0 mt-0.5" style="color:#0D2D6D;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="bg-gray-50 border border-gray-100 rounded-2xl p-7">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-5" style="background:#EEF2FF;">
                    <svg class="w-5 h-5" style="color:#0D2D6D;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="font-bold text-base mb-4" style="color:#0D2D6D;">{{ __('about.services_export_title') }}</h3>
                <ul class="space-y-2.5">
                    @foreach([
                        __('about.export_svc_1'), __('about.export_svc_2'), __('about.export_svc_3'), __('about.export_svc_4'),
                        __('about.export_svc_5'), __('about.export_svc_6'), __('about.export_svc_7'), __('about.export_svc_8'),
                    ] as $item)
                        <li class="flex items-start gap-2.5 text-sm text-gray-600">
                            <svg class="w-4 h-4 shrink-0 mt-0.5" style="color:#0D2D6D;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="py-14" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold" style="color:#0D2D6D;">{{ __('about.values_title') }}</h2>
            <p class="text-gray-500 text-sm mt-1.5">{{ __('about.values_subtitle') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach([
                ['icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','title'=>__('about.value_1_title'),'desc'=>__('about.value_1_desc')],
                ['icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','title'=>__('about.value_2_title'),'desc'=>__('about.value_2_desc')],
                ['icon'=>'M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z','title'=>__('about.value_3_title'),'desc'=>__('about.value_3_desc')],
                ['icon'=>'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z','title'=>__('about.value_4_title'),'desc'=>__('about.value_4_desc')],
            ] as $v)
                <div class="bg-white border border-gray-100 rounded-2xl p-6 text-center hover:shadow-md hover:border-gray-200 transition-all">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center mx-auto mb-4" style="background:#EEF2FF;">
                        <svg class="w-5 h-5" style="color:#0D2D6D;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $v['icon'] }}"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-sm mb-2" style="color:#0D2D6D;">{{ $v['title'] }}</h3>
                    <p class="text-gray-500 text-xs leading-relaxed">{{ $v['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="py-12" style="background:#0D2D6D;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6 text-center">
            @foreach([
                ['value'=>__('about.stat_1_val'),'label'=>__('about.stat_1_label')],
                ['value'=>__('about.stat_2_val'),'label'=>__('about.stat_2_label')],
                ['value'=>__('about.stat_3_val'),'label'=>__('about.stat_3_label')],
                ['value'=>__('about.stat_4_val'),'label'=>__('about.stat_4_label')],
                ['value'=>__('about.stat_5_val'),'label'=>__('about.stat_5_label')],
            ] as $s)
                <div>
                    <div class="text-2xl md:text-3xl font-bold text-white">{{ $s['value'] }}</div>
                    <div class="text-white/50 text-xs mt-1 font-medium">{{ $s['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Team --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold" style="color:#0D2D6D;">{{ __('about.team_title') }}</h2>
            <p class="text-gray-500 text-sm mt-1.5">{{ __('about.team_subtitle') }}</p>
        </div>

        {{-- Founder card (featured) --}}
        <div class="max-w-2xl mx-auto mb-8">
            <div class="bg-gray-50 border border-gray-100 rounded-2xl p-8 hover:shadow-md hover:border-gray-200 transition-all">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    {{-- Avatar --}}
                    <div class="shrink-0">
                        @if(file_exists(public_path('images/team/barqawi-founder.webp')))
                            <img src="{{ asset('images/team/barqawi-founder.webp') }}"
                                 alt="M. Barqawi — Fondateur BARQAWI Fahrzeughandel"
                                 class="w-24 h-24 rounded-2xl object-cover shadow-sm">
                        @else
                            <div class="w-24 h-24 rounded-2xl flex items-center justify-center text-white text-2xl font-black shadow-sm"
                                 style="background:linear-gradient(135deg,#0D2D6D 0%,#1a4a9e 100%);">
                                B
                            </div>
                        @endif
                    </div>
                    {{-- Info --}}
                    <div class="text-center sm:text-left">
                        <div class="inline-flex items-center gap-2 mb-2">
                            <span class="text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full"
                                  style="background:#EEF2FF; color:#0D2D6D;">{{ __('about.founder_badge') }}</span>
                        </div>
                        <h3 class="text-lg font-black mb-0.5" style="color:#0D2D6D;">{{ __('about.founder_name') }}</h3>
                        <p class="text-sm font-semibold mb-3" style="color:#E30613;">{{ __('about.founder_role') }}</p>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ __('about.founder_bio') }}</p>
                        <div class="flex flex-wrap gap-2 mt-4 justify-center sm:justify-start">
                            @foreach([__('about.founder_tag_1'), __('about.founder_tag_2'), __('about.founder_tag_3')] as $tag)
                            <span class="text-[11px] font-semibold px-3 py-1 rounded-full border border-gray-200 text-gray-500">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Supporting team roles --}}
        <div class="grid md:grid-cols-2 gap-5 max-w-2xl mx-auto">
            @foreach([
                ['role'=>__('about.team_2_role'),'icon'=>'M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z','desc'=>__('about.team_2_desc')],
                ['role'=>__('about.team_3_role'),'icon'=>'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z','desc'=>__('about.team_3_desc')],
            ] as $m)
                <div class="flex items-start gap-4 bg-gray-50 border border-gray-100 rounded-2xl p-6 hover:shadow-sm hover:border-gray-200 transition-all">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 mt-0.5" style="background:#0D2D6D;">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $m['icon'] }}"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm mb-1.5" style="color:#0D2D6D;">{{ $m['role'] }}</h3>
                        <p class="text-gray-500 text-xs leading-relaxed">{{ $m['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-14" style="background:#0D2D6D;">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <h2 class="text-2xl font-bold text-white mb-3">{{ __('about.cta_title') }}</h2>
        <p class="text-white/60 mb-8 text-sm">{{ __('about.cta_desc') }}</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('contact', ['locale' => $loc]) }}"
               class="flex items-center justify-center gap-2 text-white font-semibold px-8 py-3.5 rounded-xl transition-opacity hover:opacity-90 text-sm"
               style="background:#E30613;">
                {{ __('about.cta_contact_btn') }}
            </a>
            <a href="{{ route('vehicles.index', ['locale' => $loc]) }}"
               class="flex items-center justify-center gap-2 border border-white/20 text-white font-semibold px-8 py-3.5 rounded-xl hover:bg-white/8 transition-colors text-sm">
                {{ __('about.cta_vehicles_btn') }}
            </a>
        </div>
    </div>
</section>

@endsection
