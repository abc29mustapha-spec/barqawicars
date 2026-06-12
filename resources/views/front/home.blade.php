@extends('layouts.app')
@section('title', __('seo.home_title'))
@section('description', __('seo.home_description'))

{{-- Préchargement de l'image hero pour améliorer le LCP --}}
@push('head')
@if(file_exists(public_path('images/hero-banner.webp')))
<link rel="preload" as="image" href="{{ asset('images/hero-banner.webp') }}" type="image/webp">
@elseif(file_exists(public_path('images/hero-banner.jpg')))
<link rel="preload" as="image" href="{{ asset('images/hero-banner.jpg') }}">
@endif
@endpush

@section('content')
@php $loc = $locale ?? app()->getLocale(); @endphp

{{-- ═══════ HERO ═══════ --}}
<section class="relative flex flex-col justify-center overflow-hidden" style="min-height:600px; background:#0D2D6D;">

    {{-- Background image — visible! --}}
    @if(file_exists(public_path('images/hero-banner.webp')) || file_exists(public_path('images/hero-banner.jpg')))
        <div class="absolute inset-0">
            <img src="{{ asset(file_exists(public_path('images/hero-banner.webp')) ? 'images/hero-banner.webp' : 'images/hero-banner.jpg') }}"
                 alt="BARQAWI Fahrzeughandel – véhicules de qualité à Fellbach"
                 class="w-full h-full object-cover object-center"
                 loading="eager" fetchpriority="high">
            {{-- Subtle gradient — image stays visible --}}
            <div class="absolute inset-0"
                 style="background: linear-gradient(to right, rgba(9,29,71,0.72) 0%, rgba(9,29,71,0.4) 50%, rgba(9,29,71,0.15) 100%);"></div>
        </div>
    @endif

    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="max-w-xl">

            <h1 class="text-4xl sm:text-5xl font-bold text-white leading-tight mb-4">
                {{ __('home.hero_title') }}<br>
                <span class="font-extrabold text-white">{{ __('home.hero_highlight') }}</span>
            </h1>
            <p class="text-white/80 text-base leading-relaxed mb-8 max-w-sm">
                {{ __('home.hero_desc') }}
            </p>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('vehicles.index', ['locale' => $loc]) }}"
                   class="inline-flex items-center gap-2 text-white text-sm font-semibold px-6 py-3 rounded-xl transition-opacity hover:opacity-90"
                   style="background:#E30613;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    {{ __('home.cta_vehicles') }}
                </a>
                <a href="{{ route('contact', ['locale' => $loc]) }}"
                   class="inline-flex items-center gap-2 text-white text-sm font-semibold px-6 py-3 rounded-xl border border-white/30 hover:bg-white/10 transition-colors">
                    {{ __('layout.contact_btn') }}
                </a>
            </div>

            <div class="flex items-center gap-3 mt-10 flex-wrap">
                @foreach(['home.stat_clients','home.stat_countries','home.stat_rating'] as $key)
                    <span class="flex items-center gap-2 text-white text-xs font-semibold px-3 py-1.5 rounded-full border border-white/20 bg-white/10 backdrop-blur-sm shrink-0"
                          style="text-shadow: 0 1px 3px rgba(0,0,0,0.45);">
                        <span class="w-1.5 h-1.5 rounded-full shrink-0 bg-white/60"></span>
                        {{ __($key) }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ═══════ QUICK SEARCH ═══════ --}}
<section class="mt-[-67px] sticky">
    <div class="max-w-5xl py-4 mx-auto px-4 sm:px-6 lg:px-8">
        @php
        $bodyTypes = [
            'berline'           => ['label'=>'Berline',   'svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M10.2796 5.09566C11.1662 4.3864 12.2678 4 13.4031 4H25C26.5146 4 27.9883 4.49124 29.2 5.4L35.3769 10.0327L40.597 10.5547C43.6642 10.8614 46 13.4424 46 16.5249V20H41.584C40.8124 21.7659 39.0503 23 37 23C34.9497 23 33.1876 21.7659 32.416 20H17.584C16.8124 21.7659 15.0503 23 13 23C10.9497 23 9.1876 21.7659 8.41604 20H7C4.23858 20 2 17.7614 2 15V9.21922L6.54573 8.08279L10.2796 5.09566ZM6.69735 10.1064L4 10.7808V15C4 16.6569 5.34315 18 7 18H8C8 15.2386 10.2386 13 13 13C15.7614 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7614 13 42 15.2386 42 18H44V16.5249C44 14.4699 42.4428 12.7493 40.398 12.5448L34.9501 12H11.4853C9.70397 12 7.99266 11.321 6.69735 10.1064ZM32 10L28 7C27.1345 6.35089 26.0819 6 25 6H23.1805L23.8471 10H32ZM21.8195 10L21.1529 6H16.1805L16.8471 10H21.8195ZM14.8195 10L14.1529 6H13.4031C12.7219 6 12.061 6.23184 11.529 6.65739L8.54533 9.04436C9.39437 9.66156 10.4224 10 11.4853 10H14.8195ZM16 18C16 16.3431 14.6569 15 13 15C11.3431 15 10 16.3431 10 18C10 19.6569 11.3431 21 13 21C14.6569 21 16 19.6569 16 18ZM37 15C35.3431 15 34 16.3431 34 18C34 19.6569 35.3431 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
            'break'             => ['label'=>'Break',     'svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M3.36754 6.73509C3.912 5.10172 5.44056 4 7.16228 4H24.3118C25.5998 4 26.8629 4.35538 27.962 5.02703L35.3486 9.54111L40.89 10.3723C43.8272 10.8129 46 13.336 46 16.3059V20H41.584C40.8124 21.7659 39.0503 23 37 23C34.9497 23 33.1876 21.7659 32.416 20H17.584C16.8124 21.7659 15.0503 23 13 23C10.9497 23 9.1876 21.7659 8.41604 20H6C3.79086 20 2 18.2091 2 16V10.8377L3.36754 6.73509ZM8 18C8 15.2386 10.2386 13 13 13C15.7614 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7614 13 42 15.2386 42 18H44V16.3059C44 14.326 42.5514 12.6439 40.5934 12.3502L38.2587 12H4V16C4 17.1046 4.89543 18 6 18H8ZM4.38743 10H6.27924L7.61257 6H7.16228C6.30142 6 5.53714 6.55086 5.26491 7.36754L4.38743 10ZM9.72076 6L8.38743 10H14V6H9.72076ZM16 6V10H21.6126L20.2792 6H16ZM22.3874 6L23.7208 10H32.2641L26.9191 6.73359C26.134 6.25384 25.2318 6 24.3118 6H22.3874ZM13 15C11.3431 15 10 16.3431 10 18C10 19.6569 11.3431 21 13 21C14.6569 21 16 19.6569 16 18C16 16.3431 14.6569 15 13 15ZM37 15C35.3431 15 34 16.3431 34 18C34 19.6569 35.3431 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
            'suv_pickup'        => ['label'=>'SUV',       'svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M7.05279 3.65836C7.56096 2.64201 8.59975 2 9.73607 2H29.0775C30.5964 2 32.033 2.69045 32.9818 3.87652L35.5861 7.13178L41.7241 8.9732C44.262 9.73457 46 12.0705 46 14.7202V20H41.584C40.8124 21.7659 39.0503 23 37 23C34.9497 23 33.1876 21.7659 32.416 20H19.584C18.8124 21.7659 17.0503 23 15 23C12.9497 23 11.1876 21.7659 10.416 20H10C7.94968 20 6.1876 18.7659 5.41604 17H4C2.89543 17 2 16.1046 2 15V9C2 7.89543 2.89543 7 4 7H5.38197L7.05279 3.65836ZM5 9H4V15H5V9ZM7 8.23607V15C7 16.6569 8.34315 18 10 18C10 15.2386 12.2386 13 15 13C17.7614 13 20 15.2386 20 18H32C32 15.2386 34.2386 13 37 13C39.7614 13 42 15.2386 42 18H44V14.7202C44 12.9537 42.8413 11.3964 41.1494 10.8888L35.0925 9.07178L34.0807 9.57771C33.5252 9.85542 32.9128 10 32.2918 10H12.6178C11.1312 10 10.1642 8.43566 10.8288 7.10588L12.3811 4H9.73607C9.3573 4 9.01103 4.214 8.84164 4.55279L7 8.23607ZM14.617 4L12.6178 8H17.1534L17.8197 4H14.617ZM19.8472 4L19.181 8H24.6126L23.2794 4H19.8472ZM25.3875 4L26.7208 8H32.2918C32.6023 8 32.9085 7.92771 33.1862 7.78886L33.4464 7.65877L31.4201 5.12592C30.8508 4.41427 29.9889 4 29.0775 4H25.3875ZM15 15C13.3431 15 12 16.3431 12 18C12 19.6569 13.3431 21 15 21C16.6569 21 18 19.6569 18 18C18 16.3431 16.6569 15 15 15ZM37 15C35.3431 15 34 16.3431 34 18C34 19.6569 35.3431 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
            'citadine'          => ['label'=>'Citadine',  'svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M8.98048 6.2265C9.90781 4.83551 11.469 4 13.1407 4H24.5203C25.7139 4 26.868 4.42696 27.7743 5.20372L33.4225 10.045L36.7442 10.4602C39.7468 10.8356 42 13.388 42 16.4139V20H37.584C36.8124 21.7659 35.0503 23 33 23C30.9497 23 29.1876 21.7659 28.416 20H18.584C17.8124 21.7659 16.0503 23 14 23C11.9497 23 10.1876 21.7659 9.41604 20H9C7.34315 20 6 18.6569 6 17V12.8167C6 11.4347 6.40907 10.0836 7.17565 8.93375L8.98048 6.2265ZM9 18C9 15.2386 11.2386 13 14 13C16.7614 13 19 15.2386 19 18H28C28 15.2386 30.2386 13 33 13C35.7614 13 38 15.2386 38 18H40V16.4139C40 14.3966 38.4979 12.695 36.4961 12.4448L32.9377 12H17.2361C15.0059 12 13.5554 9.65306 14.5528 7.65836L15.382 6H13.1407C12.1377 6 11.201 6.5013 10.6446 7.3359L8.83975 10.0432C8.29219 10.8645 8 11.8295 8 12.8167V17C8 17.5523 8.44772 18 9 18ZM17.618 6L16.3416 8.55279C16.0092 9.21769 16.4927 10 17.2361 10H20.8195L20.1529 6H17.618ZM22.1805 6L22.8471 10H30.2967L26.4727 6.72223C25.9289 6.25618 25.2364 6 24.5203 6H22.1805ZM14 15C12.3431 15 11 16.3431 11 18C11 19.6569 12.3431 21 14 21C15.6569 21 17 19.6569 17 18C17 16.3431 15.6569 15 14 15ZM33 15C31.3431 15 30 16.3431 30 18C30 19.6569 31.3431 21 33 21C34.6569 21 36 19.6569 36 18C36 16.3431 34.6569 15 33 15Z" fill="currentColor"/>'],
            'cabriolet_roadster'=> ['label'=>'Cabriolet', 'svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M33.4645 9.08537L41.4553 11.0831C44.1263 11.7508 46 14.1507 46 16.9039V20H41.584C40.8124 21.7659 39.0504 23 37 23C34.9497 23 33.1876 21.7659 32.4161 20H17.584C16.8124 21.7659 15.0504 23 13 23C10.9497 23 9.18764 21.7659 8.41609 20H8.07316C5.8079 20 3.82565 18.4771 3.24198 16.2883L2.26734 12.6334C2.0023 11.6395 2.53441 10.6066 3.49756 10.2455L11.1618 7.37137L12 8.00003C12.714 8.53549 13.5553 8.86801 14.4353 8.96804L14.0514 7.81626L15.9487 7.1838L16.5541 9.00003H20.6126L20.0514 7.31626L21.9487 6.6838L22.7208 9.00003H30.238L26.3599 5.76825L27.6402 4.23181L33.4645 9.08537ZM8.00004 17.9991C8.00052 15.2381 10.2389 13 13 13C15.7615 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7615 13 42 15.2386 42 18H44V16.9039C44 15.0684 42.7509 13.4685 40.9702 13.0233L32.8769 11H15C13.5014 11 12.0428 10.5191 10.8384 9.62863L4.19981 12.1181L5.17445 15.773C5.51836 17.0627 6.67153 17.9671 8.00004 17.9991ZM13 15C11.3432 15 10 16.3432 10 18C10 19.6569 11.3432 21 13 21C14.6569 21 16 19.6569 16 18C16 16.3432 14.6569 15 13 15ZM37 15C35.3432 15 34 16.3432 34 18C34 19.6569 35.3432 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3432 38.6569 15 37 15Z" fill="currentColor"/>'],
            'sport_coupe'       => ['label'=>'Coupé',     'svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M12.628 5.22599C14.0044 4.42308 15.5693 4 17.1628 4H21C23.8128 4 26.5498 4.91231 28.8 6.6L33.3658 10.0244L41.3358 10.6147C44.6296 10.8587 46.786 14.1724 45.6752 17.2827L44.7048 20H41.584C40.8124 21.7659 39.0504 23 37 23C34.9497 23 33.1876 21.7659 32.4161 20H17.584C16.8124 21.7659 15.0504 23 13 23C10.9497 23 9.18763 21.7659 8.41608 20H8.01724C5.78484 20 3.82291 18.5201 3.20962 16.3736L1.82507 11.5277L12.628 5.22599ZM8.00003 17.9999C8.00006 15.2385 10.2386 13 13 13C15.7615 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7615 13 42 15.2386 42 18H43.2953L43.7917 16.6101C44.4582 14.7439 43.1643 12.7557 41.1881 12.6093L32.963 12H15.3541C13.1687 12 11.1516 10.8915 9.97426 9.08941L4.175 12.4723L5.13267 15.8242C5.49906 17.1065 6.66773 17.9924 8.00003 17.9999ZM11.7051 8.07976C12.5232 9.27106 13.8833 10 15.3541 10H16.382L14.6209 6.47783C14.2818 6.60998 13.9524 6.76884 13.6357 6.95355L11.7051 8.07976ZM16.6283 6.02044L18.6181 10H30L27.6 8.2C25.696 6.77196 23.3801 6 21 6H17.1628C16.9841 6 16.8058 6.00685 16.6283 6.02044ZM13 15C11.3432 15 10 16.3431 10 18C10 19.6569 11.3432 21 13 21C14.6569 21 16 19.6569 16 18C16 16.3431 14.6569 15 13 15ZM37 15C35.3432 15 34 16.3431 34 18C34 19.6569 35.3432 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
            'monospace_minibus' => ['label'=>'Monospace',  'svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M3.20959 5.62639C3.82287 3.47989 5.7848 2 8.01721 2H28.8277C30.4653 2 32.051 2.57411 33.309 3.62245L37.551 7.15748L42.6833 9.72361C44.716 10.74 46 12.8175 46 15.0902V20H41.584C40.8124 21.7659 39.0503 23 37 23C34.9497 23 33.1876 21.7659 32.416 20H17.584C16.8124 21.7659 15.0503 23 13 23C10.9497 23 9.1876 21.7659 8.41605 20C6.64137 19.9988 4.9066 19.4729 3.4299 18.4885L2 17.5352V9.85995L3.20959 5.62639ZM8.00002 17.9873C8.00689 15.2317 10.2428 13 13 13C15.7614 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7614 13 42 15.2386 42 18H44V15.0902C44 13.5751 43.144 12.19 41.7889 11.5125L36.9544 9.09526L34.1595 10.2132C32.8602 10.733 31.4736 11 30.0742 11H4V16.4648L4.5393 16.8244C5.57176 17.5127 6.76642 17.9127 8.00002 17.9873ZM4.32573 9H7.2457L8.67427 4H8.01721C6.67776 4 5.50061 4.88793 5.13263 6.17584L4.32573 9ZM10.7543 4L9.32573 9H16V4H10.7543ZM18 4V9H24.6743L23.2457 4H18ZM25.3257 4L26.7543 9H30.0742C31.2192 9 32.3536 8.78152 33.4167 8.35629L35.0713 7.69445L32.0286 5.15889C31.13 4.41008 29.9974 4 28.8277 4H25.3257ZM13 15C11.3431 15 10 16.3431 10 18C10 19.6569 11.3431 21 13 21C14.6569 21 16 19.6569 16 18C16 16.3431 14.6569 15 13 15ZM37 15C35.3431 15 34 16.3431 34 18C34 19.6569 35.3431 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
            'autre'             => ['label'=>'Autre',      'svg'=>'<path d="M24 4a9 9 0 1 0 0 18A9 9 0 0 0 24 4Zm0 2a7 7 0 1 1 0 14A7 7 0 0 1 24 6Zm0 2.5c-1.654 0-3 1.346-3 3 0 .828.672 1.5 1.5 1.5s1.5-.672 1.5-1.5c0-.276.224-.5.5-.5s.5.224.5.5c0 1.379-1.121 2.5-2.5 2.5-.828 0-1.5.672-1.5 1.5v1c0 .828.672 1.5 1.5 1.5s1.5-.672 1.5-1.5v-.085A4.494 4.494 0 0 0 28.5 11.5c0-1.654-1.346-3-3-3Zm0 9.25a1.25 1.25 0 1 0 0 2.5 1.25 1.25 0 0 0 0-2.5Z" fill="currentColor"/>'],
        ];
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ vtype: '' }">

            {{-- Body type icons --}}
            <div class="flex overflow-x-auto border-b border-gray-100">
                @foreach($bodyTypes as $v => $item)
                    <button type="button"
                            @click="vtype = vtype === '{{ $v }}' ? '' : '{{ $v }}'"
                            :class="vtype === '{{ $v }}' ? 'active-type' : ''"
                            class="type-btn">
                        <svg width="40" height="20" viewBox="0 0 48 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            {!! $item['svg'] !!}
                        </svg>
                        <span>{{ __('vtype.' . $v) }}</span>
                    </button>
                @endforeach
            </div>

            {{-- Fields --}}
            <form action="{{ route('vehicles.index', ['locale' => $loc]) }}" method="GET">
                <input type="hidden" name="vehicle_type" :value="vtype">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 divide-x divide-y md:divide-y-0 divide-gray-100">

                    <div class="px-4 py-4">
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1.5">{{ __('filters.brand') }}</label>
                        <select name="brand" class="w-full text-sm font-medium text-gray-700 bg-transparent outline-none border-none">
                            <option value="">{{ __('filters.all_brands') }}</option>
                            @foreach($brands as $b)
                                <option value="{{ $b->id }}">{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="px-4 py-4">
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1.5">{{ __('filters.condition') }}</label>
                        <select name="condition" class="w-full text-sm font-medium text-gray-700 bg-transparent outline-none border-none">
                            <option value="">{{ __('filters.all_conditions') }}</option>
                            <option value="occasion">{{ __('filters.used') }}</option>
                            <option value="neuf">{{ __('filters.new') }}</option>
                        </select>
                    </div>

                    <div class="px-4 py-4">
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1.5">{{ __('home.search_price_max') }}</label>
                        <select name="price_max" class="w-full text-sm font-medium text-gray-700 bg-transparent outline-none border-none">
                            <option value="">{{ __('home.search_no_limit') }}</option>
                            @foreach([5000,10000,15000,20000,25000,30000,40000,50000,75000] as $p)
                                <option value="{{ $p }}">{{ number_format($p,0,',',' ') }} €</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="px-4 py-4">
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1.5">{{ __('home.search_year_min') }}</label>
                        <select name="year_min" class="w-full text-sm font-medium text-gray-700 bg-transparent outline-none border-none">
                            <option value="">{{ __('home.search_year_all') }}</option>
                            @for($y = date('Y'); $y >= 1995; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-span-2 md:col-span-4 lg:col-span-1">
                        <button type="submit"
                                class="w-full h-full text-white font-semibold text-sm flex items-center justify-center gap-2 py-4 px-6 transition-opacity hover:opacity-90"
                                style="background:#0D2D6D; min-height:64px;">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            {{ __('hero.search_button') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- ═══════ BRANDS ═══════ --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8 flex-wrap gap-3">
            <div>
                <h2 class="text-2xl font-bold" style="color:#0D2D6D;">{{ __('home.brands_title') }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('home.brands_subtitle') }}</p>
            </div>
            <a href="{{ route('vehicles.index', ['locale' => $loc]) }}"
               class="text-sm font-semibold flex items-center gap-1 hover:opacity-70 transition-opacity" style="color:#0D2D6D;">
                {{ __('home.brands_see_all') }}
            </a>
        </div>

        @php
        $knownBrands = [
            'BMW'=>['abbr'=>'BMW','color'=>'#1c69d4'],'Mercedes-Benz'=>['abbr'=>'MB','color'=>'#231f20'],
            'Audi'=>['abbr'=>'AUDI','color'=>'#bb0a14'],'Volkswagen'=>['abbr'=>'VW','color'=>'#001e50'],
            'Toyota'=>['abbr'=>'TYT','color'=>'#eb0a1e'],'Renault'=>['abbr'=>'RNT','color'=>'#f6a800'],
            'Peugeot'=>['abbr'=>'PGT','color'=>'#002c70'],'Ford'=>['abbr'=>'FORD','color'=>'#003476'],
        ];
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-4">
            @forelse($topBrands->take(5) as $brand)
                @php $info = $knownBrands[$brand->name] ?? ['abbr'=>strtoupper(substr($brand->name,0,3)),'color'=>'#0D2D6D']; @endphp
                <a href="{{ route('vehicles.index', ['locale'=>$loc,'brand'=>$brand->id]) }}"
                   class="group flex flex-col items-center gap-3 py-5 px-4 bg-gray-50 hover:bg-white border border-gray-100 hover:border-gray-200 rounded-xl transition-all hover:shadow-md">
                    @if($brand->logo_url)
                        <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" class="w-10 h-10 object-contain" loading="lazy">
                    @else
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white text-xs font-bold"
                             style="background:{{ $info['color'] }};">{{ $info['abbr'] }}</div>
                    @endif
                    <div class="text-center">
                        <div class="text-sm font-semibold group-hover:text-[#0D2D6D] transition-colors" style="color:#1F2937;">{{ $brand->name }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ __('home.vehicle_count_short', ['count' => $brand->vehicles_count]) }}</div>
                    </div>
                </a>
            @empty
                <p class="col-span-5 text-sm text-gray-400 text-center py-6">{{ __('home.no_brand') }}</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ═══════ VEHICLE TYPES ═══════ --}}
<section class="py-14" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8 flex-wrap gap-3">
            <div>
                <h2 class="text-2xl font-bold" style="color:#0D2D6D;">{{ __('home.types_title') }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('home.types_subtitle') }}</p>
            </div>
        </div>

        @php
        $vehicleTypes = [
            'berline'           => ['label'=>'Berline','svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M10.2796 5.09566C11.1662 4.3864 12.2678 4 13.4031 4H25C26.5146 4 27.9883 4.49124 29.2 5.4L35.3769 10.0327L40.597 10.5547C43.6642 10.8614 46 13.4424 46 16.5249V20H41.584C40.8124 21.7659 39.0503 23 37 23C34.9497 23 33.1876 21.7659 32.416 20H17.584C16.8124 21.7659 15.0503 23 13 23C10.9497 23 9.1876 21.7659 8.41604 20H7C4.23858 20 2 17.7614 2 15V9.21922L6.54573 8.08279L10.2796 5.09566ZM6.69735 10.1064L4 10.7808V15C4 16.6569 5.34315 18 7 18H8C8 15.2386 10.2386 13 13 13C15.7614 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7614 13 42 15.2386 42 18H44V16.5249C44 14.4699 42.4428 12.7493 40.398 12.5448L34.9501 12H11.4853C9.70397 12 7.99266 11.321 6.69735 10.1064ZM32 10L28 7C27.1345 6.35089 26.0819 6 25 6H23.1805L23.8471 10H32ZM21.8195 10L21.1529 6H16.1805L16.8471 10H21.8195ZM14.8195 10L14.1529 6H13.4031C12.7219 6 12.061 6.23184 11.529 6.65739L8.54533 9.04436C9.39437 9.66156 10.4224 10 11.4853 10H14.8195ZM16 18C16 16.3431 14.6569 15 13 15C11.3431 15 10 16.3431 10 18C10 19.6569 11.3431 21 13 21C14.6569 21 16 19.6569 16 18ZM37 15C35.3431 15 34 16.3431 34 18C34 19.6569 35.3431 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
            'break'             => ['label'=>'Break','svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M3.36754 6.73509C3.912 5.10172 5.44056 4 7.16228 4H24.3118C25.5998 4 26.8629 4.35538 27.962 5.02703L35.3486 9.54111L40.89 10.3723C43.8272 10.8129 46 13.336 46 16.3059V20H41.584C40.8124 21.7659 39.0503 23 37 23C34.9497 23 33.1876 21.7659 32.416 20H17.584C16.8124 21.7659 15.0503 23 13 23C10.9497 23 9.1876 21.7659 8.41604 20H6C3.79086 20 2 18.2091 2 16V10.8377L3.36754 6.73509ZM8 18C8 15.2386 10.2386 13 13 13C15.7614 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7614 13 42 15.2386 42 18H44V16.3059C44 14.326 42.5514 12.6439 40.5934 12.3502L38.2587 12H4V16C4 17.1046 4.89543 18 6 18H8ZM4.38743 10H6.27924L7.61257 6H7.16228C6.30142 6 5.53714 6.55086 5.26491 7.36754L4.38743 10ZM9.72076 6L8.38743 10H14V6H9.72076ZM16 6V10H21.6126L20.2792 6H16ZM22.3874 6L23.7208 10H32.2641L26.9191 6.73359C26.134 6.25384 25.2318 6 24.3118 6H22.3874ZM13 15C11.3431 15 10 16.3431 10 18C10 19.6569 11.3431 21 13 21C14.6569 21 16 19.6569 16 18C16 16.3431 14.6569 15 13 15ZM37 15C35.3431 15 34 16.3431 34 18C34 19.6569 35.3431 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
            'suv_pickup'        => ['label'=>'SUV / Pick-up','svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M7.05279 3.65836C7.56096 2.64201 8.59975 2 9.73607 2H29.0775C30.5964 2 32.033 2.69045 32.9818 3.87652L35.5861 7.13178L41.7241 8.9732C44.262 9.73457 46 12.0705 46 14.7202V20H41.584C40.8124 21.7659 39.0503 23 37 23C34.9497 23 33.1876 21.7659 32.416 20H19.584C18.8124 21.7659 17.0503 23 15 23C12.9497 23 11.1876 21.7659 10.416 20H10C7.94968 20 6.1876 18.7659 5.41604 17H4C2.89543 17 2 16.1046 2 15V9C2 7.89543 2.89543 7 4 7H5.38197L7.05279 3.65836ZM5 9H4V15H5V9ZM7 8.23607V15C7 16.6569 8.34315 18 10 18C10 15.2386 12.2386 13 15 13C17.7614 13 20 15.2386 20 18H32C32 15.2386 34.2386 13 37 13C39.7614 13 42 15.2386 42 18H44V14.7202C44 12.9537 42.8413 11.3964 41.1494 10.8888L35.0925 9.07178L34.0807 9.57771C33.5252 9.85542 32.9128 10 32.2918 10H12.6178C11.1312 10 10.1642 8.43566 10.8288 7.10588L12.3811 4H9.73607C9.3573 4 9.01103 4.214 8.84164 4.55279L7 8.23607ZM14.617 4L12.6178 8H17.1534L17.8197 4H14.617ZM19.8472 4L19.181 8H24.6126L23.2794 4H19.8472ZM25.3875 4L26.7208 8H32.2918C32.6023 8 32.9085 7.92771 33.1862 7.78886L33.4464 7.65877L31.4201 5.12592C30.8508 4.41427 29.9889 4 29.0775 4H25.3875ZM15 15C13.3431 15 12 16.3431 12 18C12 19.6569 13.3431 21 15 21C16.6569 21 18 19.6569 18 18C18 16.3431 16.6569 15 15 15ZM37 15C35.3431 15 34 16.3431 34 18C34 19.6569 35.3431 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
            'citadine'          => ['label'=>'Citadine','svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M8.98048 6.2265C9.90781 4.83551 11.469 4 13.1407 4H24.5203C25.7139 4 26.868 4.42696 27.7743 5.20372L33.4225 10.045L36.7442 10.4602C39.7468 10.8356 42 13.388 42 16.4139V20H37.584C36.8124 21.7659 35.0503 23 33 23C30.9497 23 29.1876 21.7659 28.416 20H18.584C17.8124 21.7659 16.0503 23 14 23C11.9497 23 10.1876 21.7659 9.41604 20H9C7.34315 20 6 18.6569 6 17V12.8167C6 11.4347 6.40907 10.0836 7.17565 8.93375L8.98048 6.2265ZM9 18C9 15.2386 11.2386 13 14 13C16.7614 13 19 15.2386 19 18H28C28 15.2386 30.2386 13 33 13C35.7614 13 38 15.2386 38 18H40V16.4139C40 14.3966 38.4979 12.695 36.4961 12.4448L32.9377 12H17.2361C15.0059 12 13.5554 9.65306 14.5528 7.65836L15.382 6H13.1407C12.1377 6 11.201 6.5013 10.6446 7.3359L8.83975 10.0432C8.29219 10.8645 8 11.8295 8 12.8167V17C8 17.5523 8.44772 18 9 18ZM17.618 6L16.3416 8.55279C16.0092 9.21769 16.4927 10 17.2361 10H20.8195L20.1529 6H17.618ZM22.1805 6L22.8471 10H30.2967L26.4727 6.72223C25.9289 6.25618 25.2364 6 24.5203 6H22.1805ZM14 15C12.3431 15 11 16.3431 11 18C11 19.6569 12.3431 21 14 21C15.6569 21 17 19.6569 17 18C17 16.3431 15.6569 15 14 15ZM33 15C31.3431 15 30 16.3431 30 18C30 19.6569 31.3431 21 33 21C34.6569 21 36 19.6569 36 18C36 16.3431 34.6569 15 33 15Z" fill="currentColor"/>'],
            'cabriolet_roadster'=> ['label'=>'Cabriolet','svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M33.4645 9.08537L41.4553 11.0831C44.1263 11.7508 46 14.1507 46 16.9039V20H41.584C40.8124 21.7659 39.0504 23 37 23C34.9497 23 33.1876 21.7659 32.4161 20H17.584C16.8124 21.7659 15.0504 23 13 23C10.9497 23 9.18764 21.7659 8.41609 20H8.07316C5.8079 20 3.82565 18.4771 3.24198 16.2883L2.26734 12.6334C2.0023 11.6395 2.53441 10.6066 3.49756 10.2455L11.1618 7.37137L12 8.00003C12.714 8.53549 13.5553 8.86801 14.4353 8.96804L14.0514 7.81626L15.9487 7.1838L16.5541 9.00003H20.6126L20.0514 7.31626L21.9487 6.6838L22.7208 9.00003H30.238L26.3599 5.76825L27.6402 4.23181L33.4645 9.08537ZM8.00004 17.9991C8.00052 15.2381 10.2389 13 13 13C15.7615 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7615 13 42 15.2386 42 18H44V16.9039C44 15.0684 42.7509 13.4685 40.9702 13.0233L32.8769 11H15C13.5014 11 12.0428 10.5191 10.8384 9.62863L4.19981 12.1181L5.17445 15.773C5.51836 17.0627 6.67153 17.9671 8.00004 17.9991ZM13 15C11.3432 15 10 16.3432 10 18C10 19.6569 11.3432 21 13 21C14.6569 21 16 19.6569 16 18C16 16.3432 14.6569 15 13 15ZM37 15C35.3432 15 34 16.3432 34 18C34 19.6569 35.3432 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3432 38.6569 15 37 15Z" fill="currentColor"/>'],
            'sport_coupe'       => ['label'=>'Coupé / Sport','svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M12.628 5.22599C14.0044 4.42308 15.5693 4 17.1628 4H21C23.8128 4 26.5498 4.91231 28.8 6.6L33.3658 10.0244L41.3358 10.6147C44.6296 10.8587 46.786 14.1724 45.6752 17.2827L44.7048 20H41.584C40.8124 21.7659 39.0504 23 37 23C34.9497 23 33.1876 21.7659 32.4161 20H17.584C16.8124 21.7659 15.0504 23 13 23C10.9497 23 9.18763 21.7659 8.41608 20H8.01724C5.78484 20 3.82291 18.5201 3.20962 16.3736L1.82507 11.5277L12.628 5.22599ZM8.00003 17.9999C8.00006 15.2385 10.2386 13 13 13C15.7615 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7615 13 42 15.2386 42 18H43.2953L43.7917 16.6101C44.4582 14.7439 43.1643 12.7557 41.1881 12.6093L32.963 12H15.3541C13.1687 12 11.1516 10.8915 9.97426 9.08941L4.175 12.4723L5.13267 15.8242C5.49906 17.1065 6.66773 17.9924 8.00003 17.9999ZM11.7051 8.07976C12.5232 9.27106 13.8833 10 15.3541 10H16.382L14.6209 6.47783C14.2818 6.60998 13.9524 6.76884 13.6357 6.95355L11.7051 8.07976ZM16.6283 6.02044L18.6181 10H30L27.6 8.2C25.696 6.77196 23.3801 6 21 6H17.1628C16.9841 6 16.8058 6.00685 16.6283 6.02044ZM13 15C11.3432 15 10 16.3431 10 18C10 19.6569 11.3432 21 13 21C14.6569 21 16 19.6569 16 18C16 16.3431 14.6569 15 13 15ZM37 15C35.3432 15 34 16.3431 34 18C34 19.6569 35.3432 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
            'monospace_minibus' => ['label'=>'Monospace','svg'=>'<path fill-rule="evenodd" clip-rule="evenodd" d="M3.20959 5.62639C3.82287 3.47989 5.7848 2 8.01721 2H28.8277C30.4653 2 32.051 2.57411 33.309 3.62245L37.551 7.15748L42.6833 9.72361C44.716 10.74 46 12.8175 46 15.0902V20H41.584C40.8124 21.7659 39.0503 23 37 23C34.9497 23 33.1876 21.7659 32.416 20H17.584C16.8124 21.7659 15.0503 23 13 23C10.9497 23 9.1876 21.7659 8.41605 20C6.64137 19.9988 4.9066 19.4729 3.4299 18.4885L2 17.5352V9.85995L3.20959 5.62639ZM8.00002 17.9873C8.00689 15.2317 10.2428 13 13 13C15.7614 13 18 15.2386 18 18H32C32 15.2386 34.2386 13 37 13C39.7614 13 42 15.2386 42 18H44V15.0902C44 13.5751 43.144 12.19 41.7889 11.5125L36.9544 9.09526L34.1595 10.2132C32.8602 10.733 31.4736 11 30.0742 11H4V16.4648L4.5393 16.8244C5.57176 17.5127 6.76642 17.9127 8.00002 17.9873ZM4.32573 9H7.2457L8.67427 4H8.01721C6.67776 4 5.50061 4.88793 5.13263 6.17584L4.32573 9ZM10.7543 4L9.32573 9H16V4H10.7543ZM18 4V9H24.6743L23.2457 4H18ZM25.3257 4L26.7543 9H30.0742C31.2192 9 32.3536 8.78152 33.4167 8.35629L35.0713 7.69445L32.0286 5.15889C31.13 4.41008 29.9974 4 28.8277 4H25.3257ZM13 15C11.3431 15 10 16.3431 10 18C10 19.6569 11.3431 21 13 21C14.6569 21 16 19.6569 16 18C16 16.3431 14.6569 15 13 15ZM37 15C35.3431 15 34 16.3431 34 18C34 19.6569 35.3431 21 37 21C38.6569 21 40 19.6569 40 18C40 16.3431 38.6569 15 37 15Z" fill="currentColor"/>'],
            'autre'             => ['label'=>'Autre','svg'=>'<path d="M24 4a9 9 0 1 0 0 18A9 9 0 0 0 24 4Zm0 2a7 7 0 1 1 0 14A7 7 0 0 1 24 6Zm0 2.5c-1.654 0-3 1.346-3 3 0 .828.672 1.5 1.5 1.5s1.5-.672 1.5-1.5c0-.276.224-.5.5-.5s.5.224.5.5c0 1.379-1.121 2.5-2.5 2.5-.828 0-1.5.672-1.5 1.5v1c0 .828.672 1.5 1.5 1.5s1.5-.672 1.5-1.5v-.085A4.494 4.494 0 0 0 28.5 11.5c0-1.654-1.346-3-3-3Zm0 9.25a1.25 1.25 0 1 0 0 2.5 1.25 1.25 0 0 0 0-2.5Z" fill="currentColor"/>'],
        ];
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            @foreach($vehicleTypes as $type => $info)
                @php $count = $typeCounts[$type] ?? 0; @endphp
                <a href="{{ route('vehicles.index', ['locale'=>$loc,'vehicle_type'=>$type]) }}"
                   class="group bg-white border border-gray-100 hover:border-gray-300 rounded-xl p-4 flex flex-col items-center gap-3 transition-all hover:shadow-md text-center">
                    <svg width="48" height="24" viewBox="0 0 48 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                         class="text-gray-400 group-hover:text-[#0D2D6D] transition-colors" aria-hidden="true">
                        {!! $info['svg'] !!}
                    </svg>
                    <div>
                        <div class="text-sm font-semibold text-gray-700 group-hover:text-[#0D2D6D] transition-colors">{{ __('vtype.' . $type) }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">
                            {{ $count > 0 ? __('home.vehicle_count_short', ['count' => $count]) : '—' }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════ FEATURED VEHICLES ═══════ --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8 flex-wrap gap-3">
            <div>
                <h2 class="text-2xl font-bold" style="color:#0D2D6D;">{{ __('home.featured_title') }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('home.featured_desc') }}</p>
            </div>
            <a href="{{ route('vehicles.index', ['locale'=>$loc]) }}"
               class="text-sm font-semibold hover:opacity-70 transition-opacity" style="color:#0D2D6D;">
                {{ __('home.featured_btn') }} →
            </a>
        </div>
        @if($featuredVehicles->isEmpty())
            <div class="text-center py-16 text-gray-400 text-sm">{{ __('home.no_vehicle') }}</div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($featuredVehicles as $vehicle)
                    <x-vehicle-card :vehicle="$vehicle" :locale="$loc"/>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ═══════ SERVICES ═══════ --}}
<section class="py-14" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-8" style="color:#0D2D6D;">{{ __('home.services_title') }}</h2>
        <div class="grid md:grid-cols-3 gap-5">
            @php $services = [
                ['icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','title'=>__('home.service1_title'),'desc'=>__('home.service1_desc')],
                ['icon'=>'M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z','title'=>__('home.service2_title'),'desc'=>__('home.service2_desc')],
                ['icon'=>'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z','title'=>__('home.service3_title'),'desc'=>__('home.service3_desc')],
            ]; @endphp
            @foreach($services as $s)
                <div class="bg-white border border-gray-100 rounded-xl p-6 flex gap-4 hover:border-gray-200 hover:shadow-sm transition-all">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 mt-0.5" style="background:#EEF2FF;">
                        <svg class="w-5 h-5" style="color:#0D2D6D;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1.5 text-sm">{{ $s['title'] }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ $s['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════ AVIS CLIENTS ═══════ --}}
@if(isset($reviews) && $reviews->isNotEmpty())
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold" style="color:#0D2D6D;">{{ __('home.reviews_title') }}</h2>
            <p class="text-sm text-gray-500 mt-2">{{ __('home.reviews_subtitle') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($reviews as $review)
                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 hover:border-gray-200 hover:shadow-sm transition-all">
                    <div class="flex gap-0.5 mb-3">
                        @for($s = 1; $s <= 5; $s++)
                            <svg class="w-4 h-4 {{ $s <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">"{{ $review->body }}"</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold" style="color:#0D2D6D;">{{ $review->author }}</span>
                        <span class="text-xs text-gray-400">{{ __('home.reviews_source_' . $review->source) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════ CTA ═══════ --}}
<section class="py-16" style="background:#0D2D6D;">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3">{{ __('home.cta_title') }}</h2>
        <p class="text-white/60 mb-8 text-sm leading-relaxed">{{ __('home.cta_desc') }}</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('contact', ['locale'=>$loc]) }}"
               class="inline-flex items-center justify-center gap-2 text-white font-semibold px-8 py-3.5 rounded-xl transition-opacity hover:opacity-90 text-sm"
               style="background:#E30613;">
                {{ __('home.cta_contact') }}
            </a>
            <a href="{{ route('vehicles.index', ['locale'=>$loc]) }}"
               class="inline-flex items-center justify-center gap-2 border border-white/20 text-white font-semibold px-8 py-3.5 rounded-xl hover:bg-white/8 transition-colors text-sm">
                {{ __('home.cta_vehicles') }}
            </a>
        </div>
    </div>
</section>

@endsection
