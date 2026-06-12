@extends('layouts.app')
@section('title', __('legal.page_title') . ' — BARQAWI')
@section('description', __('seo.legal_description'))
@section('content')
@php $loc = $locale ?? app()->getLocale(); @endphp

{{-- Hero --}}
<section class="relative overflow-hidden flex flex-col justify-center" style="min-height:280px; background:#0D2D6D;">
    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center gap-2 text-sm text-white/50 mb-6">
            <a href="{{ route('home', ['locale' => $loc]) }}" class="hover:text-white transition-colors">{{ __('breadcrumb.home') }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/80 font-medium">{{ __('legal.page_title') }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3">{{ __('legal.page_title') }}</h1>
        <p class="text-white/65 text-base max-w-lg leading-relaxed">{{ __('legal.page_desc') }}</p>
    </div>
</section>

{{-- Contenu --}}
<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        {{-- Éditeur --}}
        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-8">
            <h2 class="text-lg font-bold mb-5" style="color:#0D2D6D;">{{ __('legal.editor_title') }}</h2>
            <dl class="space-y-3 text-sm text-gray-700">
                <div class="flex gap-3">
                    <dt class="font-semibold w-40 shrink-0 text-gray-500">Société</dt>
                    <dd>{{ __('legal.editor_company') }}</dd>
                </div>
                <div class="flex gap-3">
                    <dt class="font-semibold w-40 shrink-0 text-gray-500">Forme</dt>
                    <dd>{{ __('legal.editor_form') }}</dd>
                </div>
                <div class="flex gap-3">
                    <dt class="font-semibold w-40 shrink-0 text-gray-500">Adresse</dt>
                    <dd>{{ __('legal.editor_address') }}</dd>
                </div>
                <div class="flex gap-3">
                    <dt class="font-semibold w-40 shrink-0 text-gray-500">Téléphone</dt>
                    <dd><a href="tel:+4971164589240" class="hover:underline" style="color:#0D2D6D;">{{ __('legal.editor_phone') }}</a></dd>
                </div>
                <div class="flex gap-3">
                    <dt class="font-semibold w-40 shrink-0 text-gray-500">Télécopieur</dt>
                    <dd>{{ __('legal.editor_fax') }}</dd>
                </div>
                <div class="flex gap-3">
                    <dt class="font-semibold w-40 shrink-0 text-gray-500">Mobile</dt>
                    <dd><a href="tel:+491726994705" class="hover:underline" style="color:#0D2D6D;">{{ __('legal.editor_mobile') }}</a></dd>
                </div>
                <div class="flex gap-3">
                    <dt class="font-semibold w-40 shrink-0 text-gray-500">Email</dt>
                    <dd><a href="mailto:info@barqawi-cars.de" class="hover:underline" style="color:#0D2D6D;">{{ __('legal.editor_email') }}</a></dd>
                </div>
                <div class="flex gap-3">
                    <dt class="font-semibold w-40 shrink-0 text-gray-500">N° TVA</dt>
                    <dd>{{ __('legal.editor_vat') }}</dd>
                </div>
            </dl>
        </div>

        {{-- Directeur de publication --}}
        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-8">
            <h2 class="text-lg font-bold mb-5" style="color:#0D2D6D;">{{ __('legal.director_title') }}</h2>
            <p class="text-sm text-gray-700">{{ __('legal.director_name') }}</p>
        </div>

        {{-- Hébergement --}}
        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-8">
            <h2 class="text-lg font-bold mb-5" style="color:#0D2D6D;">{{ __('legal.host_title') }}</h2>
            <dl class="space-y-3 text-sm text-gray-700">
                <div class="flex gap-3">
                    <dt class="font-semibold w-40 shrink-0 text-gray-500">Nom</dt>
                    <dd>{{ __('legal.host_name') }}</dd>
                </div>
                <div class="flex gap-3">
                    <dt class="font-semibold w-40 shrink-0 text-gray-500">Adresse</dt>
                    <dd>{{ __('legal.host_address') }}</dd>
                </div>
            </dl>
        </div>

        {{-- Propriété intellectuelle --}}
        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-8">
            <h2 class="text-lg font-bold mb-4" style="color:#0D2D6D;">{{ __('legal.ip_title') }}</h2>
            <p class="text-sm text-gray-600 leading-relaxed">{{ __('legal.ip_text') }}</p>
        </div>

        {{-- Responsabilité --}}
        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-8">
            <h2 class="text-lg font-bold mb-4" style="color:#0D2D6D;">{{ __('legal.liability_title') }}</h2>
            <p class="text-sm text-gray-600 leading-relaxed">{{ __('legal.liability_text') }}</p>
        </div>

        {{-- Données personnelles --}}
        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-8">
            <h2 class="text-lg font-bold mb-4" style="color:#0D2D6D;">{{ __('legal.data_title') }}</h2>
            <p class="text-sm text-gray-600 leading-relaxed">{{ __('legal.data_text') }}</p>
        </div>

    </div>
</section>

@endsection
