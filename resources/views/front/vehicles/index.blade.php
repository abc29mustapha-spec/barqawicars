@extends('layouts.app')
@php $currentPage = $vehicles->currentPage(); @endphp
@section('title',       ($catalogSeoTitle ?? __('seo.vehicles_title')) . ($currentPage > 1 ? ' – Page ' . $currentPage : ''))
@section('description', $catalogSeoDescription ?? __('seo.vehicles_description'))
@section('robots',      $currentPage > 1 ? 'noindex, follow' : 'index, follow')

@push('head')
@php
$loc = $locale ?? app()->getLocale();
$paginatorBase = $vehicles->url(1); // URL page 1 avec query string existants
@endphp
@if($vehicles->previousPageUrl())
    <link rel="prev" href="{{ $vehicles->previousPageUrl() }}">
@endif
@if($vehicles->nextPageUrl())
    <link rel="next" href="{{ $vehicles->nextPageUrl() }}">
@endif
@endpush

@push('structured_data')
@php
$loc = $locale ?? app()->getLocale();

// Nom du breadcrumb : titre filtré sans suffix "– BARQAWI", ou label générique
$breadcrumbLabel = isset($catalogSeoTitle) && $catalogSeoTitle
    ? str_replace(' – BARQAWI', '', $catalogSeoTitle)
    : __('breadcrumb.vehicles', [], $loc);

$breadcrumbLd = [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1,
         'name'  => __('breadcrumb.home', [], $loc),
         'item'  => route('home', ['locale' => $loc])],
        ['@type' => 'ListItem', 'position' => 2,
         'name'  => $breadcrumbLabel,
         'item'  => route('vehicles.index', ['locale' => $loc])],
    ],
];
@endphp
<script type="application/ld+json">{!! json_encode($breadcrumbLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')
@php $loc = $locale ?? app()->getLocale(); @endphp

{{-- Breadcrumb --}}
<div class="border-b border-gray-100" style="background:#F4F6FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 text-sm text-gray-500 flex items-center gap-2">
        <a href="{{ route('home', ['locale' => $loc]) }}" class="hover:text-[#E30613] transition-colors font-medium">{{ __('nav.home') }}</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="font-bold" style="color:#0D2D6D;">{{ __('nav.vehicles') }}</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-5">
        <p class="text-xs font-black uppercase tracking-widest mb-1" style="color:#E30613;">{{ __('vehicles.catalog_badge') }}</p>
        <h1 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">
            {{ (isset($catalogSeoTitle) && $catalogSeoTitle)
                ? str_replace(' – BARQAWI', '', $catalogSeoTitle)
                : __('vehicles.catalog_title') }}
        </h1>
        <p class="text-gray-500 text-sm mt-1">{{ __('vehicles.available_count', ['count' => $vehicles->total()]) }}</p>
    </div>

    <div class="flex gap-8 items-start">

        {{-- ─── SIDEBAR FILTERS ─── --}}
        <aside class="hidden lg:block w-60 shrink-0">
            <form method="GET" action="{{ route('vehicles.index', ['locale' => $loc]) }}">
                <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden sticky top-20 shadow-md shadow-gray-100/70 backdrop-blur-sm">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-gray-50/70">
                        <h2 class="font-semibold text-sm m-0 p-0" style="color:#0D2D6D;">{{ __('vehicles.filters') }}</h2>
                        @if(request()->hasAny(['search','brand','condition','fuel_type','transmission','price_min','price_max','mileage_max','year_min','year_max','vehicle_type','vat_status','color']))
                            <a href="{{ route('vehicles.index', ['locale' => $loc]) }}"
                               class="text-xs font-medium text-gray-400 hover:text-gray-600 transition-colors">{{ __('vehicles.reset') }}</a>
                        @endif
                    </div>

                    <div class="p-5 space-y-6 max-h-[calc(100vh-180px)] overflow-y-auto">

                        {{-- Search --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __('filters.search') }}</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('home.search_placeholder') }}"
                                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50 outline-none focus:bg-white focus:border-[#0D2D6D] focus:ring-4 focus:ring-[#0D2D6D]/10 transition-all duration-200">
                        </div>

                        {{-- Condition --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __('filters.condition') }}</label>
                            <select name="condition" onchange="this.form.submit()"
                                    class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50 outline-none focus:bg-white focus:border-[#0D2D6D] focus:ring-4 focus:ring-[#0D2D6D]/10 transition-all duration-200">
                                <option value="">{{ __('filters.all_conditions') }}</option>
                                <option value="neuf"     {{ request('condition')==='neuf'    ?'selected':'' }}>{{ __('filters.new') }}</option>
                                <option value="occasion" {{ request('condition')==='occasion'?'selected':'' }}>{{ __('filters.used') }}</option>
                            </select>
                        </div>

                        {{-- Type --}}
                        <div x-data="{ vtype: '{{ request('vehicle_type', '') }}' }">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __('filters.type') }}</label>
                            <input type="hidden" name="vehicle_type" :value="vtype">
                            <div class="grid grid-cols-2 gap-1.5">
                                @php $types = [
                                    'berline'           => ['label'=>'Berline',       'svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M10.2796 5.09566C11.1662 4.3864 12.2678 4 13.4031 4H25C26.5146 4 27.9883 4.49124 29.2 5.4L35.3769 10.0327L40.597 10.5547C43.6642 10.8614 46 13.4424 46 16.5249V20H41.584C40.8124 21.7659 39.0503 23 37 23C34.9497 23 33.1876 21.7659 32.416 20H17.584C16.8124 21.7659 15.0503 23 13 23C10.9497 23 9.1876 21.7659 8.41604 20H7C4.23858 20 2 17.7614 2 15V9.21922L6.54573 8.08279L10.2796 5.09566ZM6.69735 10.1064L4 10.7808V15C4 16.6569 5.34315 18 7 18H8C8 15.2386 10.2386 13 13 13C15.7614 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7614 13 42 15.2386 42 18H44V16.5249C44 14.4699 42.4428 12.7493 40.398 12.5448L34.9501 12H11.4853C9.70397 12 7.99266 11.321 6.69735 10.1064ZM32 10L28 7C27.1345 6.35089 26.0819 6 25 6H23.1805L23.8471 10H32ZM21.8195 10L21.1529 6H16.1805L16.8471 10H21.8195ZM14.8195 10L14.1529 6H13.4031C12.7219 6 12.061 6.23184 11.529 6.65739L8.54533 9.04436C9.39437 9.66156 10.4224 10 11.4853 10H14.8195ZM16 18C16 16.3431 14.6569 15 13 15C11.3431 15 10 16.3431 10 18C10 19.6569 11.3431 21 13 21C14.6569 21 16 19.6569 16 18ZM37 15C35.3431 15 34 16.3431 34 18C34 19.6569 35.3431 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
                                    'break'             => ['label'=>'Break',         'svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M3.36754 6.73509C3.912 5.10172 5.44056 4 7.16228 4H24.3118C25.5998 4 26.8629 4.35538 27.962 5.02703L35.3486 9.54111L40.89 10.3723C43.8272 10.8129 46 13.336 46 16.3059V20H41.584C40.8124 21.7659 39.0503 23 37 23C34.9497 23 33.1876 21.7659 32.416 20H17.584C16.8124 21.7659 15.0503 23 13 23C10.9497 23 9.1876 21.7659 8.41604 20H6C3.79086 20 2 18.2091 2 16V10.8377L3.36754 6.73509ZM8 18C8 15.2386 10.2386 13 13 13C15.7614 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7614 13 42 15.2386 42 18H44V16.3059C44 14.326 42.5514 12.6439 40.5934 12.3502L38.2587 12H4V16C4 17.1046 4.89543 18 6 18H8ZM4.38743 10H6.27924L7.61257 6H7.16228C6.30142 6 5.53714 6.55086 5.26491 7.36754L4.38743 10ZM9.72076 6L8.38743 10H14V6H9.72076ZM16 6V10H21.6126L20.2792 6H16ZM22.3874 6L23.7208 10H32.2641L26.9191 6.73359C26.134 6.25384 25.2318 6 24.3118 6H22.3874ZM13 15C11.3431 15 10 16.3431 10 18C10 19.6569 11.3431 21 13 21C14.6569 21 16 19.6569 16 18C16 16.3431 14.6569 15 13 15ZM37 15C35.3431 15 34 16.3431 34 18C34 19.6569 35.3431 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
                                    'suv_pickup'        => ['label'=>'SUV / Pick-up', 'svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M7.05279 3.65836C7.56096 2.64201 8.59975 2 9.73607 2H29.0775C30.5964 2 32.033 2.69045 32.9818 3.87652L35.5861 7.13178L41.7241 8.9732C44.262 9.73457 46 12.0705 46 14.7202V20H41.584C40.8124 21.7659 39.0503 23 37 23C34.9497 23 33.1876 21.7659 32.416 20H19.584C18.8124 21.7659 17.0503 23 15 23C12.9497 23 11.1876 21.7659 10.416 20H10C7.94968 20 6.1876 18.7659 5.41604 17H4C2.89543 17 2 16.1046 2 15V9C2 7.89543 2.89543 7 4 7H5.38197L7.05279 3.65836ZM5 9H4V15H5V9ZM7 8.23607V15C7 16.6569 8.34315 18 10 18C10 15.2386 12.2386 13 15 13C17.7614 13 20 15.2386 20 18H32C32 15.2386 34.2386 13 37 13C39.7614 13 42 15.2386 42 18H44V14.7202C44 12.9537 42.8413 11.3964 41.1494 10.8888L35.0925 9.07178L34.0807 9.57771C33.5252 9.85542 32.9128 10 32.2918 10H12.6178C11.1312 10 10.1642 8.43566 10.8288 7.10588L12.3811 4H9.73607C9.3573 4 9.01103 4.214 8.84164 4.55279L7 8.23607ZM14.617 4L12.6178 8H17.1534L17.8197 4H14.617ZM19.8472 4L19.181 8H24.6126L23.2794 4H19.8472ZM25.3875 4L26.7208 8H32.2918C32.6023 8 32.9085 7.92771 33.1862 7.78886L33.4464 7.65877L31.4201 5.12592C30.8508 4.41427 29.9889 4 29.0775 4H25.3875ZM15 15C13.3431 15 12 16.3431 12 18C12 19.6569 13.3431 21 15 21C16.6569 21 18 19.6569 18 18C18 16.3431 16.6569 15 15 15ZM37 15C35.3431 15 34 16.3431 34 18C34 19.6569 35.3431 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
                                    'citadine'          => ['label'=>'Citadine',      'svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M8.98048 6.2265C9.90781 4.83551 11.469 4 13.1407 4H24.5203C25.7139 4 26.868 4.42696 27.7743 5.20372L33.4225 10.045L36.7442 10.4602C39.7468 10.8356 42 13.388 42 16.4139V20H37.584C36.8124 21.7659 35.0503 23 33 23C30.9497 23 29.1876 21.7659 28.416 20H18.584C17.8124 21.7659 16.0503 23 14 23C11.9497 23 10.1876 21.7659 9.41604 20H9C7.34315 20 6 18.6569 6 17V12.8167C6 11.4347 6.40907 10.0836 7.17565 8.93375L8.98048 6.2265ZM9 18C9 15.2386 11.2386 13 14 13C16.7614 13 19 15.2386 19 18H28C28 15.2386 30.2386 13 33 13C35.7614 13 38 15.2386 38 18H40V16.4139C40 14.3966 38.4979 12.695 36.4961 12.4448L32.9377 12H17.2361C15.0059 12 13.5554 9.65306 14.5528 7.65836L15.382 6H13.1407C12.1377 6 11.201 6.5013 10.6446 7.3359L8.83975 10.0432C8.29219 10.8645 8 11.8295 8 12.8167V17C8 17.5523 8.44772 18 9 18ZM17.618 6L16.3416 8.55279C16.0092 9.21769 16.4927 10 17.2361 10H20.8195L20.1529 6H17.618ZM22.1805 6L22.8471 10H30.2967L26.4727 6.72223C25.9289 6.25618 25.2364 6 24.5203 6H22.1805ZM14 15C12.3431 15 11 16.3431 11 18C11 19.6569 12.3431 21 14 21C15.6569 21 17 19.6569 17 18C17 16.3431 15.6569 15 14 15ZM33 15C31.3431 15 30 16.3431 30 18C30 19.6569 31.3431 21 33 21C34.6569 21 36 19.6569 36 18C36 16.3431 34.6569 15 33 15Z" fill="currentColor"/>'],
                                    'cabriolet_roadster'=> ['label'=>'Cabriolet',     'svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M33.4645 9.08537L41.4553 11.0831C44.1263 11.7508 46 14.1507 46 16.9039V20H41.584C40.8124 21.7659 39.0504 23 37 23C34.9497 23 33.1876 21.7659 32.4161 20H17.584C16.8124 21.7659 15.0504 23 13 23C10.9497 23 9.18764 21.7659 8.41609 20H8.07316C5.8079 20 3.82565 18.4771 3.24198 16.2883L2.26734 12.6334C2.0023 11.6395 2.53441 10.6066 3.49756 10.2455L11.1618 7.37137L12 8.00003C12.714 8.53549 13.5553 8.86801 14.4353 8.96804L14.0514 7.81626L15.9487 7.1838L16.5541 9.00003H20.6126L20.0514 7.31626L21.9487 6.6838L22.7208 9.00003H30.238L26.3599 5.76825L27.6402 4.23181L33.4645 9.08537ZM8.00004 17.9991C8.00052 15.2381 10.2389 13 13 13C15.7615 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7615 13 42 15.2386 42 18H44V16.9039C44 15.0684 42.7509 13.4685 40.9702 13.0233L32.8769 11H15C13.5014 11 12.0428 10.5191 10.8384 9.62863L4.19981 12.1181L5.17445 15.773C5.51836 17.0627 6.67153 17.9671 8.00004 17.9991ZM13 15C11.3432 15 10 16.3432 10 18C10 19.6569 11.3432 21 13 21C14.6569 21 16 19.6569 16 18C16 16.3432 14.6569 15 13 15ZM37 15C35.3432 15 34 16.3432 34 18C34 19.6569 35.3432 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3432 38.6569 15 37 15Z" fill="currentColor"/>'],
                                    'sport_coupe'       => ['label'=>'Sport / Coupé', 'svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M12.628 5.22599C14.0044 4.42308 15.5693 4 17.1628 4H21C23.8128 4 26.5498 4.91231 28.8 6.6L33.3658 10.0244L41.3358 10.6147C44.6296 10.8587 46.786 14.1724 45.6752 17.2827L44.7048 20H41.584C40.8124 21.7659 39.0504 23 37 23C34.9497 23 33.1876 21.7659 32.4161 20H17.584C16.8124 21.7659 15.0504 23 13 23C10.9497 23 9.18763 21.7659 8.41608 20H8.01724C5.78484 20 3.82291 18.5201 3.20962 16.3736L1.82507 11.5277L12.628 5.22599ZM8.00003 17.9999C8.00006 15.2385 10.2386 13 13 13C15.7615 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7615 13 42 15.2386 42 18H43.2953L43.7917 16.6101C44.4582 14.7439 43.1643 12.7557 41.1881 12.6093L32.963 12H15.3541C13.1687 12 11.1516 10.8915 9.97426 9.08941L4.175 12.4723L5.13267 15.8242C5.49906 17.1065 6.66773 17.9924 8.00003 17.9999ZM11.7051 8.07976C12.5232 9.27106 13.8833 10 15.3541 10H16.382L14.6209 6.47783C14.2818 6.60998 13.9524 6.76884 13.6357 6.95355L11.7051 8.07976ZM16.6283 6.02044L18.6181 10H30L27.6 8.2C25.696 6.77196 23.3801 6 21 6H17.1628C16.9841 6 16.8058 6.00685 16.6283 6.02044ZM13 15C11.3432 15 10 16.3431 10 18C10 19.6569 11.3432 21 13 21C14.6569 21 16 19.6569 16 18C16 16.3431 14.6569 15 13 15ZM37 15C35.3432 15 34 16.3431 34 18C34 19.6569 35.3432 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
                                    'monospace_minibus' => ['label'=>'Monospace',     'svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M3.20959 5.62639C3.82287 3.47989 5.7848 2 8.01721 2H28.8277C30.4653 2 32.051 2.57411 33.309 3.62245L37.551 7.15748L42.6833 9.72361C44.716 10.74 46 12.8175 46 15.0902V20H41.584C40.8124 21.7659 39.0503 23 37 23C34.9497 23 33.1876 21.7659 32.416 20H17.584C16.8124 21.7659 15.0503 23 13 23C10.9497 23 9.1876 21.7659 8.41605 20C6.64137 19.9988 4.9066 19.4729 3.4299 18.4885L2 17.5352V9.85995L3.20959 5.62639ZM8.00002 17.9873C8.00689 15.2317 10.2428 13 13 13C15.7614 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7614 13 42 15.2386 42 18H44V15.0902C44 13.5751 43.144 12.19 41.7889 11.5125L36.9544 9.09526L34.1595 10.2132C32.8602 10.733 31.4736 11 30.0742 11H4V16.4648L4.5393 16.8244C5.57176 17.5127 6.76642 17.9127 8.00002 17.9873ZM4.32573 9H7.2457L8.67427 4H8.01721C6.67776 4 5.50061 4.88793 5.13263 6.17584L4.32573 9ZM10.7543 4L9.32573 9H16V4H10.7543ZM18 4V9H24.6743L23.2457 4H18ZM25.3257 4L26.7543 9H30.0742C31.2192 9 32.3536 8.78152 33.4167 8.35629L35.0713 7.69445L32.0286 5.15889C31.13 4.41008 29.9974 4 28.8277 4H25.3257ZM13 15C11.3431 15 10 16.3431 10 18C10 19.6569 11.3431 21 13 21C14.6569 21 16 19.6569 16 18C16 16.3431 14.6569 15 13 15ZM37 15C35.3431 15 34 16.3431 34 18C34 19.6569 35.3431 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
                                    'autre'             => ['label'=>'Autre',         'svg'=>'<path d="M24 4a9 9 0 1 0 0 18A9 9 0 0 0 24 4Zm0 2a7 7 0 1 1 0 14A7 7 0 0 1 24 6Zm0 2.5c-1.654 0-3 1.346-3 3 0 .828.672 1.5 1.5 1.5s1.5-.672 1.5-1.5c0-.276.224-.5.5-.5s.5.224.5.5c0 1.379-1.121 2.5-2.5 2.5-.828 0-1.5.672-1.5 1.5v1c0 .828.672 1.5 1.5 1.5s1.5-.672 1.5-1.5v-.085A4.494 4.494 0 0 0 28.5 11.5c0-1.654-1.346-3-3-3Zm0 9.25a1.25 1.25 0 1 0 0 2.5 1.25 1.25 0 0 0 0-2.5Z" fill="currentColor"/>'],
                                ]; @endphp
                                @foreach($types as $v => $item)
                                    <button type="button"
                                            @click="vtype = vtype === '{{ $v }}' ? '' : '{{ $v }}'; $nextTick(() => $el.closest('form').submit())"
                                            :class="vtype === '{{ $v }}' ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-gray-200 text-gray-400 hover:border-gray-300 hover:text-gray-600 hover:bg-gray-50'"
                                            class="flex flex-col items-center gap-1.5 p-3 border rounded-2xl transition-all duration-200 cursor-pointer hover:shadow-md hover:-translate-y-0.5">
                                        <svg width="48" height="24" viewBox="0 0 48 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            {!! $item['svg'] !!}
                                        </svg>
                                        <span class="text-[10px] font-semibold leading-tight text-center">{{ __('vtype.' . $v) }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Brand --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __('filters.brand') }}</label>
                            <select name="brand" onchange="this.form.submit()"
                                    class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50 outline-none focus:bg-white focus:border-[#0D2D6D] focus:ring-4 focus:ring-[#0D2D6D]/10 transition-all duration-200">
                                <option value="">{{ __('filters.all_brands') }}</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand')==(string)$brand->id?'selected':'' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Price --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __('filters.price') }}</label>
                            <div class="flex gap-2">
                                <input type="number" name="price_min" placeholder="Min" value="{{ request('price_min') }}"
                                       class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50 outline-none focus:bg-white focus:border-[#0D2D6D] focus:ring-4 focus:ring-[#0D2D6D]/10 transition-all duration-200">
                                <input type="number" name="price_max" placeholder="Max" value="{{ request('price_max') }}"
                                       class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50 outline-none focus:bg-white focus:border-[#0D2D6D] focus:ring-4 focus:ring-[#0D2D6D]/10 transition-all duration-200">
                            </div>
                        </div>

                        {{-- Mileage --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __('filters.mileage') }}</label>
                            <input type="number" name="mileage_max" placeholder="Max km" value="{{ request('mileage_max') }}"
                                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50 outline-none focus:bg-white focus:border-[#0D2D6D] focus:ring-4 focus:ring-[#0D2D6D]/10 transition-all duration-200">
                        </div>

                        {{-- Year --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __('filters.year') }}</label>
                            <div class="flex gap-2">
                                <input type="number" name="year_min" placeholder="{{ __('filters.year_from') }}" value="{{ request('year_min') }}"
                                       class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50 outline-none focus:bg-white focus:border-[#0D2D6D] focus:ring-4 focus:ring-[#0D2D6D]/10 transition-all duration-200">
                                <input type="number" name="year_max" placeholder="{{ __('filters.year_to') }}" value="{{ request('year_max') }}"
                                       class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50 outline-none focus:bg-white focus:border-[#0D2D6D] focus:ring-4 focus:ring-[#0D2D6D]/10 transition-all duration-200">
                            </div>
                        </div>

                        {{-- Fuel --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __('filters.fuel') }}</label>
                            <select name="fuel_type" onchange="this.form.submit()"
                                    class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50 outline-none focus:bg-white focus:border-[#0D2D6D] focus:ring-4 focus:ring-[#0D2D6D]/10 transition-all duration-200">
                                <option value="">{{ __('filters.all_fuels') }}</option>
                                @foreach(['essence'=>__('filters.fuel_essence'),'diesel'=>__('filters.fuel_diesel'),'electrique'=>__('filters.fuel_electric'),'hybride_essence'=>__('filters.fuel_hybrid'),'hybride_plug_in'=>__('filters.fuel_plugin'),'gpl'=>__('filters.fuel_gpl')] as $v=>$l)
                                    <option value="{{ $v }}" {{ request('fuel_type')===$v?'selected':'' }}>{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Transmission --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __('filters.transmission') }}</label>
                            <select name="transmission" onchange="this.form.submit()"
                                    class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50 outline-none focus:bg-white focus:border-[#0D2D6D] focus:ring-4 focus:ring-[#0D2D6D]/10 transition-all duration-200">
                                <option value="">{{ __('filters.all_trans') }}</option>
                                <option value="automatique"     {{ request('transmission')==='automatique'    ?'selected':'' }}>{{ __('filters.trans_auto') }}</option>
                                <option value="manuelle"        {{ request('transmission')==='manuelle'       ?'selected':'' }}>{{ __('filters.trans_manual') }}</option>
                                <option value="semi_automatique"{{ request('transmission')==='semi_automatique'?'selected':'' }}>{{ __('filters.trans_semi') }}</option>
                            </select>
                        </div>

                        {{-- Couleur extérieure --}}
                        <div x-data="{ col: '{{ request('color', '') }}' }">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __('filters.color') }}</label>
                            <input type="hidden" name="color" :value="col">
                            <div class="flex flex-wrap gap-2">
                                @foreach([
                                    'beige'  => ['hex'=>'#D4C5A9','border'=>false],
                                    'bleu'   => ['hex'=>'#2563EB','border'=>false],
                                    'brun'   => ['hex'=>'#92400E','border'=>false],
                                    'jaune'  => ['hex'=>'#FACC15','border'=>false],
                                    'or'     => ['hex'=>'#CA8A04','border'=>false],
                                    'vert'   => ['hex'=>'#16A34A','border'=>false],
                                    'gris'   => ['hex'=>'#6B7280','border'=>false],
                                    'orange' => ['hex'=>'#EA580C','border'=>false],
                                    'rouge'  => ['hex'=>'#DC2626','border'=>false],
                                    'noir'   => ['hex'=>'#111827','border'=>false],
                                    'argent' => ['hex'=>'#CBD5E1','border'=>false],
                                    'violet' => ['hex'=>'#7C3AED','border'=>false],
                                    'blanc'  => ['hex'=>'#FFFFFF','border'=>true],
                                ] as $cKey => $cProps)
                                <button type="button"
                                        title="{{ __('color.' . $cKey) }}"
                                        @click="col = col === '{{ $cKey }}' ? '' : '{{ $cKey }}'; $nextTick(() => $el.closest('form').submit())"
                                        :class="col === '{{ $cKey }}'
                                            ? 'ring-2 ring-offset-1 ring-gray-700 scale-110'
                                            : 'hover:scale-110'"
                                        class="w-6 h-6 rounded-full transition-all duration-150 shrink-0 {{ $cProps['border'] ? 'border border-gray-300' : '' }}"
                                        style="background:{{ $cProps['hex'] }};"></button>
                                @endforeach
                            </div>
                        </div>

                        {{-- TVA --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __('filters.vat') }}</label>
                            <select name="vat_status" onchange="this.form.submit()"
                                    class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50 outline-none focus:bg-white focus:border-[#0D2D6D] focus:ring-4 focus:ring-[#0D2D6D]/10 transition-all duration-200">
                                <option value="">{{ __('filters.all_vat') }}</option>
                                <option value="recuperable"     {{ request('vat_status')==='recuperable'     ?'selected':'' }}>{{ __('filters.vat_recoverable') }}</option>
                                <option value="non_recuperable" {{ request('vat_status')==='non_recuperable' ?'selected':'' }}>{{ __('filters.vat_non_rec') }}</option>
                            </select>
                        </div>

                        <button type="submit"
                                class="w-full text-white font-semibold py-3 rounded-2xl text-sm transition-all duration-200 hover:opacity-90 hover:shadow-lg hover:shadow-blue-100"
                                style="background:#0D2D6D;">
                            {{ __('filters.apply') }}
                        </button>
                    </div>
                </div>
            </form>
        </aside>

        {{-- ─── RESULTS ─── --}}
        <div class="flex-1 min-w-0">

            {{-- Sort + count bar --}}
            <div class="flex items-center justify-between mb-6 flex-wrap gap-3 bg-white border border-gray-100 rounded-2xl px-4 py-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <p class="text-sm font-semibold" style="color:#0D2D6D;">
                        {{ __('vehicles.available_count', ['count' => $vehicles->total()]) }}
                    </p>
                    {{-- Active filter chips --}}
                    @if(request()->hasAny(['search','brand','condition','fuel_type','transmission','price_min','price_max','mileage_max','year_min','year_max','vehicle_type','vat_status','color']))
                        <a href="{{ route('vehicles.index', ['locale' => $loc]) }}"
                           class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full border transition-colors hover:border-gray-300 text-gray-500 border-gray-200 hover:text-gray-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            {{ __('filters.reset_link') }}
                        </a>
                    @endif
                </div>
                <form method="GET" action="{{ route('vehicles.index', ['locale' => $loc]) }}" class="flex items-center gap-2">
                    @foreach(request()->except(['sort', 'page']) as $k => $v)
                        @if($v) <input type="hidden" name="{{ $k }}" value="{{ $v }}"> @endif
                    @endforeach
                    <label class="text-xs text-gray-400 font-medium whitespace-nowrap">{{ __('filters.sort_by') }}</label>
                    <select name="sort" onchange="this.form.submit()"
                            class="border border-gray-200 rounded-2xl px-4 py-2.5 text-sm font-medium outline-none bg-gray-50 text-gray-700 focus:border-[#0D2D6D] focus:ring-4 focus:ring-[#0D2D6D]/10 transition-all">
                        <option value="latest"     {{ request('sort','latest')==='latest'    ?'selected':'' }}>{{ __('filters.sort_latest') }}</option>
                        <option value="price_asc"  {{ request('sort')==='price_asc'          ?'selected':'' }}>{{ __('vehicles.sort_price_asc') }}</option>
                        <option value="price_desc" {{ request('sort')==='price_desc'         ?'selected':'' }}>{{ __('vehicles.sort_price_desc') }}</option>
                        <option value="year_desc"  {{ request('sort')==='year_desc'          ?'selected':'' }}>{{ __('filters.sort_year_recent') }}</option>
                        <option value="mileage_asc"{{ request('sort')==='mileage_asc'        ?'selected':'' }}>{{ __('filters.sort_mileage_asc') }}</option>
                    </select>
                </form>
            </div>

            @if($vehicles->isEmpty())
                <div class="text-center py-24 bg-white rounded-3xl border border-gray-100 shadow-sm">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background:#F7F8FA;">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-800 mb-1">{{ __('vehicles.no_results') }}</p>
                    <p class="text-sm text-gray-400 mb-5">{{ __('vehicles.no_results_hint') }}</p>
                    <a href="{{ route('vehicles.index', ['locale' => $loc]) }}"
                       class="inline-flex items-center gap-2 text-sm font-semibold text-white px-5 py-2.5 rounded-xl transition-opacity hover:opacity-90"
                       style="background:#0D2D6D;">
                        {{ __('vehicles.clear_filters') }}
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    @foreach($vehicles as $vehicle)
                        <x-vehicle-card :vehicle="$vehicle" :locale="$loc" :eager="$loop->index < 2"/>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="bg-white rounded-3xl border border-gray-100 px-5 py-4 shadow-sm">
                    {{ $vehicles->onEachSide(2)->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
