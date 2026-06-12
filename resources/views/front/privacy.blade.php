@extends('layouts.app')
@section('title', __('privacy.page_title') . ' — BARQAWI')
@section('description', __('seo.privacy_description'))
@section('content')
@php $loc = $locale ?? app()->getLocale(); @endphp

{{-- Hero --}}
<section class="relative overflow-hidden flex flex-col justify-center" style="min-height:280px; background:#0D2D6D;">
    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center gap-2 text-sm text-white/50 mb-6">
            <a href="{{ route('home', ['locale' => $loc]) }}" class="hover:text-white transition-colors">{{ __('breadcrumb.home') }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/80 font-medium">{{ __('privacy.page_title') }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3">{{ __('privacy.page_title') }}</h1>
        <p class="text-white/65 text-base max-w-lg leading-relaxed">{{ __('privacy.page_desc') }}</p>
    </div>
</section>

{{-- Contenu --}}
<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        @foreach([
            ['title' => __('privacy.collect_title'),   'text' => __('privacy.collect_text')],
            ['title' => __('privacy.purpose_title'),   'text' => __('privacy.purpose_text')],
            ['title' => __('privacy.retention_title'), 'text' => __('privacy.retention_text')],
            ['title' => __('privacy.third_title'),     'text' => __('privacy.third_text')],
            ['title' => __('privacy.rights_title'),    'text' => __('privacy.rights_text')],
            ['title' => __('privacy.cookies_title'),   'text' => __('privacy.cookies_text')],
            ['title' => __('privacy.contact_title'),   'text' => __('privacy.contact_text')],
        ] as $section)
            <div class="bg-gray-50 border border-gray-100 rounded-2xl p-8">
                <h2 class="text-lg font-bold mb-4" style="color:#0D2D6D;">{{ $section['title'] }}</h2>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $section['text'] }}</p>
            </div>
        @endforeach

    </div>
</section>

@endsection
