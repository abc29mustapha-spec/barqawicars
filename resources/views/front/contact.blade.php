@extends('layouts.app')
@section('title', __('seo.contact_title'))
@section('description', __('seo.contact_description'))

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
         'name'  => __('breadcrumb.contact', [], $loc),
         'item'  => route('contact', ['locale' => $loc])],
    ],
];
@endphp
<script type="application/ld+json">{!! json_encode($breadcrumbLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')
@php $loc = $locale ?? app()->getLocale(); @endphp

{{-- ═══════════ PAGE HERO ═══════════ --}}
<section class="relative overflow-hidden flex flex-col justify-center" style="min-height:460px; background:#0D2D6D;">

    @if(file_exists(public_path('images/contactbarqawi.webp')))
        <div class="absolute inset-0">
            <img src="{{ asset('images/contactbarqawi.webp') }}" alt="{{ 'BARQAWI Fahrzeughandel – ' . __('nav.contact') . ', Fellbach' }}"
                 class="w-full h-full object-cover object-center"
                 loading="eager" fetchpriority="high">
            <div class="absolute inset-0" style="background:linear-gradient(to right, rgba(13,45,109,0.62) 0%, rgba(13,45,109,0.25) 55%, rgba(13,45,109,0.08) 100%);"></div>
        </div>
    @endif

    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center gap-2 text-sm text-white/50 mb-6">
            <a href="{{ route('home', ['locale' => $loc]) }}" class="hover:text-white transition-colors">{{ __('breadcrumb.home') }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/80 font-medium">{{ __('breadcrumb.contact') }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 max-w-xl">{{ __('contact.page_title') }}</h1>
        <p class="text-white/65 text-base max-w-md leading-relaxed">{{ __('contact.page_desc') }}</p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Info cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        @foreach([
            ['icon'=>'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z','title'=>__('contact.info_address'),'value'=>__('contact.address_value'),'link'=>null],
            ['icon'=>'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z','title'=>__('contact.info_phone'),'value'=>'0711 – 645 89 240','link'=>'tel:+4971164589240'],
            ['icon'=>'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z','title'=>__('contact.info_email'),'value'=>'info@barqawi-cars.de','link'=>'mailto:info@barqawi-cars.de'],
            ['icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','title'=>__('contact.info_hours'),'value'=>__('contact.hours_value'),'link'=>null],
        ] as $info)
            <div class="bg-white border border-gray-200 rounded-2xl p-5">
                <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-4.5 h-4.5 text-blue-600" style="width:1.1rem;height:1.1rem;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $info['icon'] }}"/>
                    </svg>
                </div>
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ $info['title'] }}</div>
                @if($info['link'])
                    <a href="{{ $info['link'] }}" class="text-sm font-semibold hover:opacity-70 transition-colors" style="color:#0D2D6D;">{{ $info['value'] }}</a>
                @else
                    <p class="text-sm font-semibold" style="color:#0D2D6D;">{{ $info['value'] }}</p>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Form + sidebar --}}
    <div class="grid lg:grid-cols-3 gap-8">

        {{-- Main form --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-7 sm:p-8">
            <h2 class="text-lg font-bold mb-1" style="color:#0D2D6D;">{{ __('contact.send_message') }}</h2>
            <p class="text-sm text-gray-500 mb-6">{{ __('contact.form_subtitle') }}</p>

            @if(session('success'))
                <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3 rounded-xl mb-6 alert-anim">
                    <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl mb-6">
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('contact.store', ['locale' => $loc]) }}" method="POST" class="space-y-5">
                @csrf
                @if(request('vehicle_id'))
                    <input type="hidden" name="vehicle_id" value="{{ request('vehicle_id') }}">
                @endif
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('contact.label_name') }} *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none transition-colors {{ $errors->has('name') ? 'border-red-400' : '' }}">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('contact.label_email') }} *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none transition-colors {{ $errors->has('email') ? 'border-red-400' : '' }}">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('contact.label_phone') }}</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+212 6 00 00 00 00"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('contact.label_subject') }}</label>
                        <select name="subject" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none transition-colors">
                            <option value="">{{ __('contact.select_subject') }}</option>
                            <option value="achat"       {{ old('subject')==='achat'       ?'selected':'' }}>{{ __('contact.subject_purchase') }}</option>
                            <option value="devis"       {{ old('subject')==='devis'       ?'selected':'' }}>{{ __('contact.subject_quote') }}</option>
                            <option value="export"      {{ old('subject')==='export'      ?'selected':'' }}>{{ __('contact.subject_export') }}</option>
                            <option value="essai"       {{ old('subject')==='essai'       ?'selected':'' }}>{{ __('contact.subject_test_drive') }}</option>
                            <option value="autre"       {{ old('subject')==='autre'       ?'selected':'' }}>{{ __('contact.subject_other') }}</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('contact.label_country') }}</label>
                    <input type="text" name="country" value="{{ old('country') }}" placeholder="{{ __('contact.placeholder_country') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('contact.label_message') }} *</label>
                    <textarea name="message" rows="5" required placeholder="{{ __('contact.placeholder_message') }}"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none transition-colors resize-none {{ $errors->has('message') ? 'border-red-400' : '' }}">{{ old('message') }}</textarea>
                </div>

                <label class="flex items-start gap-2.5 text-xs text-gray-500 cursor-pointer">
                    <input type="checkbox" name="consent" required value="1" class="mt-0.5 w-4 h-4 accent-[#0D2D6D] rounded shrink-0">
                    <span>{{ __('contact.consent_label') }}</span>
                </label>

                <button type="submit"
                        class="w-full text-white font-black py-3.5 rounded-xl text-sm transition-opacity hover:opacity-90 flex items-center justify-center gap-2"
                        style="background:#E30613;">
                    {{ __('contact.submit_btn') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
        </div>

        {{-- Right sidebar --}}
        <div class="space-y-5">

            {{-- Direct contact card --}}
            <div class="rounded-2xl p-6 text-white" style="background:#091D47;">
                <h3 class="font-bold text-base mb-1">{{ __('contact.direct_title') }}</h3>
                <p class="text-slate-400 text-sm mb-5">{{ __('contact.direct_hours') }}</p>
                <div class="space-y-3">
                    <a href="tel:+4971164589240"
                       class="flex items-center gap-3 p-3 bg-white/8 hover:bg-white/15 rounded-xl transition-colors text-sm">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0" style="background:#0D2D6D;">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-white font-semibold text-xs">{{ __('contact.info_phone') }}</div>
                            <div class="text-slate-400 text-xs">0711 – 645 89 240</div>
                        </div>
                    </a>
                    <a href="https://wa.me/491726994705" target="_blank"
                       class="flex items-center gap-3 p-3 bg-white/8 hover:bg-white/15 rounded-xl transition-colors text-sm">
                        <div class="w-9 h-9 bg-emerald-600 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.524 5.847L.057 23.882l6.19-1.624A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.845 0-3.574-.5-5.063-1.37l-.363-.214-3.755.985.999-3.648-.236-.376A9.94 9.94 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-white font-semibold text-xs">WhatsApp</div>
                            <div class="text-slate-400 text-xs">{{ __('contact.whatsapp_reply') }}</div>
                        </div>
                    </a>
                    <a href="mailto:info@barqawi-cars.de"
                       class="flex items-center gap-3 p-3 bg-white/8 hover:bg-white/15 rounded-xl transition-colors text-sm">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0" style="background:#1A3E85;">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-white font-semibold text-xs">{{ __('contact.info_email') }}</div>
                            <div class="text-slate-400 text-xs">info@barqawi-cars.de</div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Why us --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6">
                <h3 class="font-semibold text-sm mb-4" style="color:#0D2D6D;">{{ __('contact.why_us') }}</h3>
                <ul class="space-y-3">
                    @foreach([
                        __('contact.why_reason_1'),
                        __('contact.why_reason_2'),
                        __('contact.why_reason_3'),
                        __('contact.why_reason_4'),
                    ] as $r)
                        <li class="flex items-start gap-3 text-sm text-gray-600">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" style="color:#0D2D6D;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $r }}
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Response time badge --}}
            <div class="flex items-center gap-3 rounded-2xl p-4" style="background:#EEF2FF;">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0" style="background:#0D2D6D;">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-semibold" style="color:#0D2D6D;">{{ __('contact.response_guaranteed') }}</div>
                    <div class="text-xs text-gray-500">{{ __('contact.response_delay') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════ GOOGLE MAPS ═══════ --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-sm" style="height:380px;">
        <iframe
            title="BARQAWI Fahrzeughandel – Salierstr. 44, 70736 Fellbach"
            src="https://maps.google.com/maps?q=Salierstr.+44,+70736+Fellbach,+Deutschland&t=&z=16&ie=UTF8&iwloc=&output=embed"
            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>

@endsection
