@extends('layouts.app')
@section('title',       'Used Cars Germany | Quality Pre-Owned Vehicles from the German Market | BARQAWI Cars')
@section('description', 'Browse quality used cars from Germany. BARQAWI Cars offers a wide selection of pre-owned vehicles — BMW, Mercedes, Audi, VW — with full export service to France, Morocco, Algeria and Europe.')

@push('structured_data')
@php
$breadcrumbLd = [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',             'item' => route('home', ['locale' => 'en'])],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Used Cars Germany','item' => url()->current()],
    ],
];
$faqItems = [
    ['q' => 'What types of used cars are available in Germany?',
     'a' => 'Germany offers an exceptionally wide range of pre-owned vehicles: sedans, SUVs, estate cars, coupes, convertibles, vans and electric vehicles. Premium brands such as BMW, Mercedes-Benz, Audi and Volkswagen are particularly abundant, with comprehensive service histories and documented maintenance records. BARQAWI Cars sources vehicles across all segments and budgets.'],
    ['q' => 'Why are used cars from Germany considered higher quality?',
     'a' => 'German used cars are renowned for strict maintenance culture, comprehensive service records, and rigorous pre-sale technical inspections (TÜV Hauptuntersuchung). Most privately-owned German vehicles are well-maintained and serviced at authorised dealerships. Motorway mileage (Autobahn) is generally less wear-intensive than urban driving, contributing to better mechanical condition.'],
    ['q' => 'How do I buy a used car from Germany without travelling there?',
     'a' => 'BARQAWI Cars handles the entire process remotely. We source the vehicle, inspect it, verify its history via Fahrzeughistorie (vehicle history report), prepare all export documents and arrange transport. You receive a ready-to-register vehicle in France or at your delivery address without needing to visit Germany.'],
    ['q' => 'What mileage ranges are typical for German used cars?',
     'a' => 'German used cars span a wide range: nearly new low-mileage vehicles under 30,000 km, mid-range vehicles between 50,000 and 100,000 km, and high-mileage vehicles exceeding 150,000 km. German Autobahn mileage is generally less damaging to the engine than stop-and-go urban driving. We can source vehicles matching your specific mileage preferences.'],
    ['q' => 'What budget do I need to buy a used car from Germany?',
     'a' => 'BARQAWI Cars works across all budget levels, from compact economy vehicles under €8,000 to luxury and performance cars exceeding €100,000. The German used car market offers exceptional value at every price point. Contact us with your target budget and requirements and we will identify available options.'],
];
$faqLd = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(fn($i) => ['@type' => 'Question', 'name' => $i['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $i['a']]], $faqItems),
];
@endphp
<script type="application/ld+json">{!! json_encode($breadcrumbLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
<script type="application/ld+json">{!! json_encode($faqLd,        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')
@php $loc = $locale ?? app()->getLocale(); @endphp

{{-- Breadcrumb --}}
<div class="border-b border-gray-100" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 text-sm text-gray-500 flex items-center gap-2 flex-wrap">
        <a href="{{ route('home', ['locale' => 'en']) }}" class="hover:opacity-70 transition-opacity font-medium" style="color:#0D2D6D;">Home</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-600 font-medium">Used Cars Germany</span>
    </div>
</div>

{{-- Hero --}}
<section style="background:linear-gradient(135deg,#0D2D6D 0%,#1a4a9e 100%);" class="text-white py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="inline-block text-xs font-black uppercase tracking-widest mb-4 px-3 py-1.5 rounded-full" style="background:rgba(227,6,19,0.9);">Pre-Owned Vehicle Specialist · Fellbach, Germany</span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight mb-5">Used Cars Germany —<br>Quality Pre-Owned Vehicles<br>from the German Market</h1>
            <p class="text-white/80 text-lg leading-relaxed mb-8 max-w-2xl">Germany is Europe's largest used car market. BARQAWI Cars gives you direct access to the best pre-owned vehicles — BMW, Mercedes-Benz, Audi, Volkswagen — with full export support to France and beyond.</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('vehicles.index', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:opacity-90 hover:shadow-lg" style="background:#E30613; color:#fff;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h6l2-1zM15 6h2l3 10-2 1h-3V6z"/></svg>
                    Browse Catalogue
                </a>
                <a href="{{ route('contact', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:bg-white/10" style="border:2px solid rgba(255,255,255,0.4); color:#fff;">Contact BARQAWI</a>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-12 max-w-lg">
            @foreach([['num'=>'500+','label'=>'Vehicles/year'],['num'=>'50+','label'=>'Brands available'],['num'=>'30+','label'=>'Countries served']] as $s)
            <div class="text-center p-4 rounded-xl" style="background:rgba(255,255,255,0.08);">
                <div class="text-2xl font-black text-white">{{ $s['num'] }}</div>
                <div class="text-xs text-white/60 mt-1">{{ $s['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Why Germany --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Why Germany</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Why Buy Used Cars from Germany?</h2>
            <p class="text-gray-500 mt-3 leading-relaxed">Six compelling reasons to source your next vehicle from the German used car market.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['title'=>'Competitive Prices',     'text'=>'Premium brands are often 10–25% cheaper in Germany than in France or the UK, even after accounting for export and transport costs.'],
                ['title'=>'Huge Selection',          'text'=>'Germany lists hundreds of thousands of used cars at any given time — the widest choice in Europe, including rare trims and factory-specified options.'],
                ['title'=>'Strict Maintenance Culture','text'=>'Most German owners service their vehicles rigorously. Service books are generally complete and TÜV inspections ensure a baseline mechanical standard.'],
                ['title'=>'Premium Brands at Origin','text'=>'BMW, Mercedes-Benz, Audi, Volkswagen and Porsche are manufactured in Germany. Buying at source means factory-spec vehicles with original documentation.'],
                ['title'=>'Electric & Hybrid Stock', 'text'=>'Germany leads Europe in electric vehicle adoption. Finding used EVs and plug-in hybrids with warranty, low mileage and realistic prices is far easier in Germany.'],
                ['title'=>'EU Seamless Import',      'text'=>'As EU member states, Germany and France have no customs duties between them. Import is a straightforward administrative process for any EU resident.'],
            ] as $c)
            <div class="rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="font-bold text-sm mb-2" style="color:#0D2D6D;">{{ $c['title'] }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed">{{ $c['text'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Categories --}}
<section class="py-14" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Vehicle Categories</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">What We Source from Germany</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach([
                ['cat'=>'German Premium Brands',  'brands'=>'BMW · Mercedes-Benz · Audi · Porsche','text'=>'Full range of premium German vehicles with complete documentation and service histories.'],
                ['cat'=>'SUVs & Crossovers',       'brands'=>'BMW X · Mercedes GLE/GLC · Audi Q','text'=>'High-demand SUVs in excellent condition, many with low mileage and full options.'],
                ['cat'=>'Electric Vehicles',       'brands'=>'BMW i · Mercedes EQ · Audi e-tron','text'=>'Pre-owned EVs from Germany with battery health reports and remaining warranty coverage.'],
                ['cat'=>'Estate & Family Cars',    'brands'=>'BMW Touring · Mercedes Estate · Audi Avant','text'=>'Practical, spacious estate cars highly sought in France but less common on the French market.'],
                ['cat'=>'Sport & Performance',     'brands'=>'BMW M · Mercedes AMG · Audi RS/S','text'=>'Performance models sourced directly from the German market where supply is greatest.'],
                ['cat'=>'Budget & Volume Brands',  'brands'=>'VW · Opel · Ford · Skoda · Toyota','text'=>'Reliable everyday vehicles at very competitive prices for buyers seeking value over prestige.'],
            ] as $c)
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <h3 class="font-bold text-sm mb-1" style="color:#0D2D6D;">{{ $c['cat'] }}</h3>
                <p class="text-[11px] font-semibold mb-2" style="color:#E30613;">{{ $c['brands'] }}</p>
                <p class="text-xs text-gray-500 leading-relaxed">{{ $c['text'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- How It Works --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Process</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">How to Buy a Used Car from Germany</h2>
        </div>
        <div class="max-w-3xl mx-auto space-y-4">
            @foreach([
                ['num'=>'01','title'=>'Tell us what you need',      'text'=>'Share your requirements — brand, model, budget, mileage — by phone, email or WhatsApp. We respond within 24 hours with available options.'],
                ['num'=>'02','title'=>'We source the vehicle',       'text'=>'We identify matching vehicles in our German dealer and private-seller network. We verify history, inspect condition, and send you a detailed offer.'],
                ['num'=>'03','title'=>'Confirm the purchase',        'text'=>'Agree on the price and pay a deposit. We handle the German purchase contract and collect all original documents from the seller.'],
                ['num'=>'04','title'=>'Export documentation',        'text'=>'We prepare: COC (Certificate of Conformity), purchase invoice, Abmeldebescheinigung (deregistration) and all transport paperwork.'],
                ['num'=>'05','title'=>'Transport & delivery',        'text'=>'The vehicle is transported by road transporter from Germany to France (typically 3–5 days). We confirm delivery and hand over all documents.'],
            ] as $s)
            <div class="flex gap-5 p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                <span class="text-3xl font-black shrink-0 leading-none mt-0.5" style="color:#EEF2FF; -webkit-text-stroke:2px #0D2D6D;">{{ $s['num'] }}</span>
                <div>
                    <h3 class="font-bold text-sm mb-1" style="color:#0D2D6D;">{{ $s['title'] }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $s['text'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="py-14" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">FAQ</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Frequently Asked Questions</h2>
        </div>
        <div class="max-w-3xl mx-auto space-y-3">
            @foreach($faqItems as $faq)
            <div class="border border-gray-100 rounded-2xl overflow-hidden bg-white" x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-sm pr-4" style="color:#0D2D6D;">{{ $faq['q'] }}</span>
                    <svg class="w-4 h-4 shrink-0 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="px-5 pb-4">
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Related Pages --}}
<section class="py-10 border-t border-gray-100" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-black uppercase tracking-widest mb-4 text-gray-400">Related Services</p>
        <div class="flex flex-wrap gap-3">
            @foreach([
                ['url' => route('landing.import_germany_france', ['locale'=>'en']), 'label' => 'Import Car Germany → France'],
                ['url' => route('landing.car_export_germany',    ['locale'=>'en']), 'label' => 'Car Export Germany'],
                ['url' => route('landing.bmw_germany',           ['locale'=>'en']), 'label' => 'BMW Germany'],
                ['url' => route('landing.audi_germany',          ['locale'=>'en']), 'label' => 'Audi Germany'],
                ['url' => route('landing.mercedes_germany',      ['locale'=>'en']), 'label' => 'Mercedes Germany'],
                ['url' => route('vehicles.index',                ['locale'=>'en']), 'label' => 'All Vehicles'],
            ] as $p)
            <a href="{{ $p['url'] }}" class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2.5 rounded-xl border border-gray-200 bg-white hover:border-gray-300 hover:shadow-sm transition-all text-gray-700">
                {{ $p['label'] }}
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-14" style="background:#0D2D6D;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl sm:text-3xl font-black text-white mb-4">Find Your Used Car from Germany Today</h2>
        <p class="text-white/70 max-w-xl mx-auto mb-8 leading-relaxed">Tell us what you are looking for. Our team in Fellbach will source it, handle all paperwork, and deliver it to you.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('vehicles.index', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:opacity-90 transition-all" style="background:#E30613; color:#fff;">Browse Vehicles</a>
            <a href="{{ route('contact', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:bg-white/10 transition-all" style="border:2px solid rgba(255,255,255,0.4); color:#fff;">Send a Request</a>
            <a href="https://wa.me/491726994705?text={{ rawurlencode('Hello, I am looking for a used car from Germany.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:opacity-90 transition-colors" style="background:#25D366; color:#fff;">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.524 5.847L.057 23.882l6.19-1.624A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.845 0-3.574-.5-5.063-1.37l-.363-.214-3.755.985.999-3.648-.236-.376A9.94 9.94 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection
