@extends('layouts.app')
@php
    // ── Title : Marque + Modèle + Version + Année ≥ 50 chars
    $vtParts = array_filter([
        $vehicle->brand?->name,
        $vehicle->model,
        $vehicle->version ?: null,
        $vehicle->year ? '(' . $vehicle->year . ')' : null,
    ]);
    $vehicleTitle = implode(' ', $vtParts) . ' – BARQAWI Fellbach';

    // ── Description : détails complets ≈ 120-150 chars
    $fuelLabel = ucfirst(str_replace('_', ' ', $vehicle->fuel_type ?? ''));
    $vehicleDesc = trim(implode(', ', array_filter([
        trim(($vehicle->brand?->name ?? '') . ' ' . $vehicle->model . ($vehicle->version ? ' ' . $vehicle->version : '')),
        $vehicle->year,
        number_format($vehicle->mileage, 0, ',', ' ') . ' km',
        $fuelLabel ?: null,
        number_format($vehicle->price, 0, ',', ' ') . ' €',
    ]))) . ' – BARQAWI Fahrzeughandel Fellbach. ' . __('seo.vehicle_cta');

    $firstImage = $vehicle->mainImage
        ? Storage::url($vehicle->mainImage->image_path)
        : asset('images/og-default.jpg');
@endphp
@section('title', $vehicleTitle)
@section('description', $vehicleDesc)
@section('og_type', 'product')
@section('og_image', $firstImage)

@push('structured_data')
@php
$loc = $locale ?? app()->getLocale();

// ── Car schema (enrichi) ──────────────────────────────────────────────────
$jsonLd = [
    '@context'            => 'https://schema.org',
    '@type'               => 'Car',
    'name'                => trim(($vehicle->brand?->name ?? '') . ' ' . $vehicle->model . ' ' . ($vehicle->version ?? '')),
    'description'         => $vehicle->description ?? (($vehicle->brand?->name ?? '') . ' ' . $vehicle->model . ' ' . $vehicle->year . ', ' . number_format($vehicle->mileage, 0) . ' km'),
    'brand'               => ['@type' => 'Brand', 'name' => $vehicle->brand?->name ?? ''],
    'model'               => $vehicle->model,
    'modelDate'           => (string) $vehicle->year,
    'mileageFromOdometer' => ['@type' => 'QuantitativeValue', 'value' => $vehicle->mileage, 'unitCode' => 'KMT'],
    'fuelType'            => ucfirst(str_replace('_', ' ', $vehicle->fuel_type ?? '')),
    'vehicleTransmission' => ucfirst(str_replace('_', ' ', $vehicle->transmission ?? '')),
    'offers'              => [
        '@type'         => 'Offer',
        'price'         => (string) $vehicle->price,
        'priceCurrency' => 'EUR',
        'availability'  => $vehicle->status === 'actif' ? 'https://schema.org/InStock' : 'https://schema.org/SoldOut',
        'url'           => url()->current(),
        'seller'        => ['@type' => 'AutoDealer', 'name' => 'BARQAWI Fahrzeughandel'],
    ],
];
if ($vehicle->mainImage)        { $jsonLd['image']                        = $firstImage; }
if ($vehicle->vin)              { $jsonLd['vehicleIdentificationNumber']   = $vehicle->vin; }
if ($vehicle->exterior_color)   { $jsonLd['color']                        = $vehicle->exterior_color; }
if ($vehicle->doors)            { $jsonLd['numberOfDoors']                = $vehicle->doors; }
if ($vehicle->seats)            { $jsonLd['vehicleSeatingCapacity']       = $vehicle->seats; }

// ── BreadcrumbList ────────────────────────────────────────────────────────
$breadcrumbLd = [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1,
         'name'  => __('breadcrumb.home', [], $loc),
         'item'  => route('home', ['locale' => $loc])],
        ['@type' => 'ListItem', 'position' => 2,
         'name'  => __('breadcrumb.vehicles', [], $loc),
         'item'  => route('vehicles.index', ['locale' => $loc])],
        ['@type' => 'ListItem', 'position' => 3,
         'name'  => trim(($vehicle->brand?->name ?? '') . ' ' . $vehicle->model)],
    ],
];
@endphp
<script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
<script type="application/ld+json">{!! json_encode($breadcrumbLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')
@php $loc = $locale ?? app()->getLocale(); @endphp

{{-- Breadcrumb --}}
<div class="border-b border-gray-100" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 text-sm text-gray-500 flex items-center gap-2 flex-wrap">
        <a href="{{ route('home', ['locale' => $loc]) }}" class="hover:opacity-70 transition-opacity font-medium" style="color:#0D2D6D;">{{ __('breadcrumb.home') }}</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('vehicles.index', ['locale' => $loc]) }}" class="hover:opacity-70 transition-opacity font-medium" style="color:#0D2D6D;">{{ __('breadcrumb.vehicles') }}</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-600 font-medium">{{ $vehicle->brand?->name }} {{ $vehicle->model }}</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
     x-data="{ activeImage: 0, images: {{ $vehicle->images->pluck('image_path')->toJson() }}, activeTab: 'specs' }">

    <div class="grid lg:grid-cols-3 gap-8">

        {{-- ─── LEFT: Gallery + Info ─── --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Gallery --}}
            @if($vehicle->images->count() > 0)
                <div class="rounded-2xl overflow-hidden bg-gray-100 relative" style="aspect-ratio:16/9;">
                    @foreach($vehicle->images as $i => $img)
                        <img src="{{ Storage::url($img->image_path) }}" alt="{{ trim(($vehicle->brand?->name ?? '') . ' ' . $vehicle->model) }} – photo {{ $i + 1 }}"
                             x-show="activeImage === {{ $i }}"
                             class="w-full h-full object-cover"
                             loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                    @endforeach

                    @if($vehicle->images->count() > 1)
                        <button @click="activeImage = (activeImage - 1 + images.length) % images.length"
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/90 hover:bg-white text-gray-800 rounded-full flex items-center justify-center shadow-lg transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click="activeImage = (activeImage + 1) % images.length"
                                class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/90 hover:bg-white text-gray-800 rounded-full flex items-center justify-center shadow-lg transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                        <span class="absolute bottom-3 right-3 bg-black/50 text-white text-xs font-medium px-3 py-1 rounded-full backdrop-blur-sm">
                            <span x-text="activeImage + 1"></span> / {{ $vehicle->images->count() }}
                        </span>
                    @endif

                    {{-- Status badge on image --}}
                    @if($vehicle->status === 'vendu')
                        <span class="absolute top-4 left-4 text-white text-xs font-semibold px-3 py-1.5 rounded-lg uppercase tracking-wide" style="background:#0D2D6D;">
                            {{ __('vehicle.sold_badge') }}
                        </span>
                    @endif
                </div>

                @if($vehicle->images->count() > 1)
                    <div class="flex gap-2 overflow-x-auto pb-1">
                        @foreach($vehicle->images as $i => $img)
                            <button @click="activeImage = {{ $i }}"
                                    :class="activeImage === {{ $i }} ? 'ring-2 ring-offset-1' : 'opacity-55 hover:opacity-80'"
                                    class="shrink-0 w-16 h-12 rounded-xl overflow-hidden transition-all"
                                    style="{{ $i === 0 ? '' : '' }}"
                                    :style="activeImage === {{ $i }} ? 'ring-color:#0D2D6D' : ''">
                                <img src="{{ Storage::url($img->image_path) }}"
                                     alt="{{ $vehicle->brand?->name }} {{ $vehicle->model }} — photo {{ $i + 1 }}"
                                     class="w-full h-full object-cover"
                                     loading="lazy">
                            </button>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-center" style="aspect-ratio:16/9;">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h6l2-1zM15 6h2l3 10-2 1h-3V6z"/>
                        </svg>
                        <p class="text-sm text-gray-300 font-medium">{{ __('vehicle.no_photo_available') }}</p>
                    </div>
                </div>
            @endif

            {{-- Tabs --}}
            <h2 class="text-sm font-bold uppercase tracking-widest mb-1" style="color:#0D2D6D;">{{ __('vehicle.tech_specs') }}</h2>
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                <div class="flex border-b border-gray-100 overflow-x-auto">
                    @foreach(['specs'=>__('vehicle.tab_specs'),'etat'=>__('vehicle.tab_condition')] as $key=>$label)
                        <button @click="activeTab = '{{ $key }}'"
                                :class="activeTab === '{{ $key }}'
                                    ? 'border-b-2 font-semibold'
                                    : 'text-gray-400 hover:text-gray-600'"
                                :style="activeTab === '{{ $key }}' ? 'border-color:#0D2D6D; color:#0D2D6D;' : ''"
                                class="px-6 py-4 text-sm shrink-0 transition-colors">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                {{-- Specs --}}
                <div x-show="activeTab === 'specs'" class="p-6">
                    @php
                    $_colorKeys = ['beige','bleu','brun','jaune','or','vert','gris','orange','rouge','noir','argent','violet','blanc'];
                    $_fmtColor  = function($val) use ($_colorKeys) {
                        if (!$val) return '—';
                        $p = explode('_', $val, 2);
                        if (!in_array($p[0], $_colorKeys)) return $val;
                        $lbl = __('color.' . $p[0]);
                        if (isset($p[1]) && in_array($p[1], ['mate','metallique'])) {
                            $lbl .= ' ' . __('color.finish.' . $p[1]);
                        }
                        return $lbl;
                    };
                    @endphp
                    @php $specs = [
                        __('vehicle.spec_brand')    => $vehicle->brand?->name ?? '—',
                        __('vehicle.spec_model')    => trim($vehicle->model.' '.($vehicle->version??'')),
                        __('vehicle.year')          => $vehicle->year,
                        __('vehicle.mileage')       => number_format($vehicle->mileage,0,',',' ').' km',
                        __('vehicle.fuel')          => ucfirst(str_replace('_',' ',$vehicle->fuel_type)),
                        __('vehicle.transmission')  => ucfirst(str_replace('_',' ',$vehicle->transmission??'—')),
                        __('vehicle.power')         => $vehicle->power_hp ? $vehicle->power_hp.' ch / '.$vehicle->power_kw.' kW' : '—',
                        __('vehicle.spec_cylinder') => $vehicle->cylinder ? number_format($vehicle->cylinder,0,',',' ').' cm³' : '—',
                        __('vehicle.spec_doors')    => $vehicle->doors ?? '—',
                        __('vehicle.spec_seats')    => $vehicle->seats ?? '—',
                        __('vehicle.spec_color_ext')=> $_fmtColor($vehicle->exterior_color),
                        __('vehicle.spec_color_int')=> $_fmtColor($vehicle->interior_color),
                        __('vehicle.spec_emission') => $vehicle->emission_standard ?? '—',
                        __('vehicle.vin')           => $vehicle->vin ?? '—',
                    ]; @endphp
                    <div class="grid sm:grid-cols-2 gap-x-10">
                        @foreach($specs as $k => $v)
                            <div class="flex items-center justify-between py-3 border-b border-gray-50 text-sm last:border-0">
                                <span class="text-gray-400 font-medium">{{ $k }}</span>
                                <span class="font-semibold text-right ml-4" style="color:#0D2D6D;">{{ $v }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Equipment --}}
                <div x-show="activeTab === 'equipment'" class="p-6">
                    @if($vehicle->exterior_extras || $vehicle->interior_extras)
                        <div class="grid sm:grid-cols-2 gap-8">
                            @if($vehicle->exterior_extras)
                                <div>
                                    <h4 class="font-semibold text-sm mb-4" style="color:#0D2D6D;">{{ __('vehicle.extras_exterior') }}</h4>
                                    <ul class="space-y-2.5">
                                        @foreach($vehicle->exterior_extras as $item)
                                            <li class="flex items-center gap-2.5 text-sm text-gray-600">
                                                <span class="w-4 h-4 rounded-full flex items-center justify-center shrink-0" style="background:#EEF2FF;">
                                                    <svg class="w-2.5 h-2.5" style="color:#0D2D6D;" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </span>
                                                {{ $item }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if($vehicle->interior_extras)
                                <div>
                                    <h4 class="font-semibold text-sm mb-4" style="color:#0D2D6D;">{{ __('vehicle.extras_interior') }}</h4>
                                    <ul class="space-y-2.5">
                                        @foreach($vehicle->interior_extras as $item)
                                            <li class="flex items-center gap-2.5 text-sm text-gray-600">
                                                <span class="w-4 h-4 rounded-full flex items-center justify-center shrink-0" style="background:#EEF2FF;">
                                                    <svg class="w-2.5 h-2.5" style="color:#0D2D6D;" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </span>
                                                {{ $item }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-sm text-gray-300 font-medium">{{ __('vehicle.no_extras') }}</p>
                        </div>
                    @endif
                </div>

                {{-- État --}}
                <div x-show="activeTab === 'etat'" class="p-6">
                    @php
                    $vatLabels = ['recuperable'=>__('vehicle.vat_rec_full'),'non_recuperable'=>__('vehicle.vat_non_rec_full')];
                    $etatInfo = [
                        __('vehicle.cond_vat')      => $vehicle->vat_status ? ($vatLabels[$vehicle->vat_status]??'—') : '—',
                        __('vehicle.cond_warranty') => $vehicle->warranty ? __('vehicle.val_included') : __('vehicle.val_no'),
                        __('vehicle.cond_service')  => $vehicle->full_service ? __('vehicle.val_done') : __('vehicle.val_no'),
                        __('vehicle.cond_book')     => $vehicle->service_book ? __('vehicle.val_present') : __('vehicle.val_no'),
                        __('vehicle.cond_safety')   => $vehicle->safety_compliant ? __('vehicle.val_compliant') : '—',
                        __('vehicle.cond_smoker')   => $vehicle->non_smoker ? __('vehicle.val_yes') : __('vehicle.val_no'),
                        __('vehicle.cond_owners')   => $vehicle->previous_owners ?? '—',
                    ]; @endphp
                    <div class="grid sm:grid-cols-2 gap-x-10">
                        @foreach($etatInfo as $k => $v)
                            <div class="flex items-center justify-between py-3 border-b border-gray-50 text-sm last:border-0">
                                <span class="text-gray-400 font-medium">{{ $k }}</span>
                                <span class="font-semibold" style="color:#0D2D6D;">{{ $v }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Description --}}
            @if($vehicle->description)
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="font-semibold text-sm mb-3" style="color:#0D2D6D;">{{ __('vehicle.description_title') }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $vehicle->description }}</p>
                </div>
            @endif
        </div>

        {{-- ─── RIGHT SIDEBAR ─── --}}
        <div class="space-y-4">

            {{-- Price card --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 top-[84px]">

                @if($vehicle->brand)
                    <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ $vehicle->brand->name }}</span>
                @endif
                <h1 class="text-xl font-bold mt-0.5 mb-1" style="color:#0D2D6D;">
                    @if($vehicle->brand){{ $vehicle->brand->name }} @endif{{ $vehicle->model }}
                    @if($vehicle->version)
                        <span class="font-normal text-gray-400 text-base">{{ $vehicle->version }}</span>
                    @endif
                </h1>

                {{-- Price --}}
                <div class="py-4 border-t border-b border-gray-100 my-4">
                    @if($vehicle->ancien_prix && $vehicle->ancien_prix > $vehicle->price)
                        <p class="text-sm text-gray-400 line-through leading-none mb-1">
                            {{ number_format($vehicle->ancien_prix, 0, ',', ' ') }} €
                        </p>
                        @php $discount = round((($vehicle->ancien_prix - $vehicle->price) / $vehicle->ancien_prix) * 100); @endphp
                        <span class="inline-block text-xs font-bold text-white bg-red-500 px-2 py-1 rounded-md mb-2 leading-none">
                            -{{ $discount }}%
                        </span>
                    @endif
                    <p class="text-3xl font-bold" style="color:#0D2D6D;">
                        {{ number_format($vehicle->price, 0, ',', ' ') }} €
                    </p>
                    @if($vehicle->vat_status)
                        <p class="text-xs text-gray-400 mt-0.5 font-medium">
                            {{ $vehicle->vat_status === 'recuperable' ? __('vehicle.vat_rec_full') : __('vehicle.vat_non_rec_full') }}
                        </p>
                    @endif
                </div>

                {{-- Key specs --}}
                <div class="grid grid-cols-2 gap-2 mb-4">
                    @foreach([
                        ['icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','val'=>$vehicle->year,'label'=>__('vehicle.label_year')],
                        ['icon'=>'M13 10V3L4 14h7v7l9-11h-7z','val'=>number_format($vehicle->mileage,0,',',' ').' km','label'=>__('vehicle.label_km')],
                        ['icon'=>'M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h6l2-1zM15 6h2l3 10-2 1h-3V6z','val'=>ucfirst(str_replace('_',' ',$vehicle->fuel_type)),'label'=>__('vehicle.label_fuel')],
                        ['icon'=>'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4','val'=>$vehicle->transmission ? ucfirst(str_replace('_',' ',$vehicle->transmission)) : '—','label'=>__('vehicle.label_gearbox')],
                    ] as $spec)
                        <div class="rounded-xl p-3 text-center" style="background:#F7F8FA;">
                            <svg class="w-4 h-4 mx-auto mb-1 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $spec['icon'] }}"/>
                            </svg>
                            <p class="text-xs font-semibold" style="color:#0D2D6D;">{{ $spec['val'] }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $spec['label'] }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- Features --}}
                @php $features = array_filter([
                    $vehicle->warranty     ? __('vehicle.badge_warranty') : null,
                    $vehicle->full_service ? __('vehicle.badge_service')  : null,
                    $vehicle->service_book ? __('vehicle.badge_book')     : null,
                ]); @endphp
                @if($features)
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($features as $f)
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $f }}
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Status --}}
                <div class="mb-5">
                    @if($vehicle->status === 'actif')
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            {{ __('vehicle.status_available') }}
                        </span>
                    @elseif($vehicle->status === 'vendu')
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1.5 rounded-lg">
                            {{ __('vehicle.status_sold') }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Quick contact form --}}
            @php
            $vehicleRef      = $vehicle->vin ? 'VIN : ' . $vehicle->vin : 'Réf. #' . $vehicle->id;
            $vehicleName     = trim(($vehicle->brand?->name ?? '') . ' ' . $vehicle->model);
            $vehiclePrice    = number_format($vehicle->price, 0, ',', ' ') . ' €';
            $vehicleUrl      = url()->current();
            $waPrefilledMsg  = __('vehicle.whatsapp_prefilled_msg', [
                'vehicle' => $vehicleName,
                'year'    => $vehicle->year,
                'price'   => $vehiclePrice,
                'ref'     => $vehicleRef,
                'url'     => $vehicleUrl,
            ]);
            $waUrl = 'https://wa.me/491726994705?text=' . rawurlencode($waPrefilledMsg);
            @endphp

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5"
                 x-data="{
                     requestType: {{ json_encode(in_array(old('type'), ['quote','test_drive','contact']) ? old('type') : 'quote') }},
                     waUrl: {{ json_encode($waUrl) }},
                     waTrackUrl: {{ json_encode(route('vehicles.whatsapp', ['locale' => $loc, 'vehicle' => $vehicle->id])) }},
                     csrfToken: '{{ csrf_token() }}'
                 }">
                <h3 class="font-semibold text-sm mb-4" style="color:#0D2D6D;">{{ __('vehicle.quick_message') }}</h3>

                @if(session('success'))
                    <div class="mb-4 bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs px-3 py-2.5 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-100 text-red-600 text-xs px-3 py-2.5 rounded-xl space-y-0.5">
                        @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
                    </div>
                @endif

                {{-- Channel selector --}}
                <div class="grid grid-cols-2 gap-1.5 mb-3">
                    @php $types = [
                        'quote'      => __('vehicle.req_quote'),
                        'test_drive' => __('vehicle.req_test_drive'),
                        'contact'    => __('vehicle.req_info'),
                        'whatsapp'   => __('vehicle.req_whatsapp'),
                    ]; @endphp
                    @foreach($types as $val => $label)
                        @if($val === 'whatsapp')
                            <button type="button"
                                    @click="window.open(waUrl, '_blank'); fetch(waTrackUrl, {method:'POST', headers:{'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json'}}).catch(function(){}); requestType = 'whatsapp';"
                                    class="flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold text-white transition-all col-span-2"
                                    style="background:#25D366; border:1px solid #1ebe5d;"
                                    onmouseenter="this.style.background='#128C7E'; this.style.borderColor='#0e7a6e';"
                                    onmouseleave="this.style.background='#25D366'; this.style.borderColor='#1ebe5d';">
                                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.524 5.847L.057 23.882l6.19-1.624A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.845 0-3.574-.5-5.063-1.37l-.363-.214-3.755.985.999-3.648-.236-.376A9.94 9.94 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                                </svg>
                                {{ $label }}
                            </button>
                        @else
                            <button type="button" @click="requestType = '{{ $val }}'"
                                    :style="requestType === '{{ $val }}' ? 'background:#EEF2FF; color:#0D2D6D; border-color:#0D2D6D;' : ''"
                                    class="px-3 py-2 border border-gray-200 rounded-lg text-xs font-medium text-gray-500 hover:border-gray-300 transition-all">
                                {{ $label }}
                            </button>
                        @endif
                    @endforeach
                </div>

                {{-- Indication WhatsApp Business --}}
                <p class="text-[11px] text-gray-400 leading-snug -mt-1 mb-3">
                    {{ __('vehicle.whatsapp_business_hint') }}
                </p>

                {{-- Standard form : quote / test_drive / contact --}}
                <form action="{{ route('contact.store', ['locale' => $loc]) }}" method="POST" class="space-y-2.5" x-show="requestType !== 'whatsapp'">
                    @csrf
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                    <input type="hidden" name="type" x-bind:value="requestType">

                    <input type="text" name="name" placeholder="{{ __('vehicle.placeholder_name') }}" required value="{{ old('name') }}"
                           class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none transition-colors">
                    <input type="email" name="email" placeholder="{{ __('contact.label_email') }} *" required value="{{ old('email') }}"
                           class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none transition-colors">
                    <input type="tel" name="phone" placeholder="{{ __('vehicle.placeholder_phone') }}" value="{{ old('phone') }}"
                           class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none transition-colors">
                    <textarea name="message" rows="3" required placeholder="{{ __('vehicle.placeholder_message') }}"
                              class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none transition-colors resize-none">{{ old('message') }}</textarea>

                    <label class="flex items-start gap-2 text-xs text-gray-500 cursor-pointer">
                        <input type="checkbox" name="consent" required class="mt-0.5 shrink-0 accent-[#0D2D6D]">
                        <span>{{ __('vehicle.consent_label') }}</span>
                    </label>

                    <button type="submit"
                            class="w-full text-white text-sm font-semibold py-3 rounded-xl transition-opacity hover:opacity-90"
                            style="background:#0D2D6D;">
                        {{ __('vehicle.send_btn') }}
                    </button>
                </form>

                {{-- WhatsApp : confirmation après clic --}}
                <div x-show="requestType === 'whatsapp'" style="display:none">
                    <div class="flex items-center gap-2.5 rounded-xl px-4 py-3 mt-1 text-white" style="background:#25D366;">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.524 5.847L.057 23.882l6.19-1.624A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.845 0-3.574-.5-5.063-1.37l-.363-.214-3.755.985.999-3.648-.236-.376A9.94 9.94 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                        </svg>
                        <p class="text-xs font-medium text-white">{{ __('vehicle.whatsapp_opening') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Similar vehicles --}}
    @if($similarVehicles->isNotEmpty())
        <div class="mt-14">
            <h2 class="text-xl font-bold mb-6" style="color:#0D2D6D;">{{ __('vehicle.similar_title') }}</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($similarVehicles as $similar)
                    <x-vehicle-card :vehicle="$similar" :locale="$loc"/>
                @endforeach
            </div>
        </div>
    @endif
</div>

@endsection
