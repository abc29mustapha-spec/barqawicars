@extends('layouts.app')
@section('title', __('terms.page_title') . ' — BARQAWI')
@section('description', __('seo.terms_description'))
@section('content')
@php $loc = $locale ?? app()->getLocale(); @endphp

{{-- Hero --}}
<section class="relative overflow-hidden flex flex-col justify-center" style="min-height:280px; background:#0D2D6D;">
    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center gap-2 text-sm text-white/50 mb-6">
            <a href="{{ route('home', ['locale' => $loc]) }}" class="hover:text-white transition-colors">{{ __('breadcrumb.home') }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/80 font-medium">{{ __('terms.page_title') }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3">{{ __('terms.page_title') }}</h1>
        <p class="text-white/65 text-base max-w-lg leading-relaxed">{{ __('terms.page_desc') }}</p>
    </div>
</section>

{{-- Contenu --}}
<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        @foreach([
            ['title' => __('terms.use_title'),          'text' => __('terms.use_text')],
            ['title' => __('terms.offer_title'),         'text' => __('terms.offer_text')],
            ['title' => __('terms.order_title'),         'text' => __('terms.order_text')],
            ['title' => __('terms.warranty_title'),      'text' => __('terms.warranty_text')],
            ['title' => __('terms.export_title'),        'text' => __('terms.export_text')],
            ['title' => __('terms.jurisdiction_title'),  'text' => __('terms.jurisdiction_text')],
        ] as $section)
            <div class="bg-gray-50 border border-gray-100 rounded-2xl p-8">
                <h2 class="text-lg font-bold mb-4" style="color:#0D2D6D;">{{ $section['title'] }}</h2>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $section['text'] }}</p>
            </div>
        @endforeach

    </div>
</section>

@endsection
