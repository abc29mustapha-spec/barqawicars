@extends('layouts.app')
@section('title',       'Audi Germany | Buy Audi Directly from Germany | BARQAWI Cars')
@section('description', 'Buy an Audi directly from Germany with BARQAWI Cars. Wide selection of Audi A4, A6, Q5, Q7, RS and S models at competitive German prices with export service to France and Europe.')

@push('structured_data')
@php
$breadcrumbLd = [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',         'item' => route('home', ['locale' => 'en'])],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Audi Germany', 'item' => url()->current()],
    ],
];
$faqItems = [
    ['q' => 'Which Audi models can I buy from Germany?',
     'a' => 'BARQAWI Cars sources the full Audi lineup from Germany: A3 (compact), A4 (sedan/Avant), A6 (executive), A8 (flagship), Q3, Q5, Q7, Q8, and performance RS/S models (RS3, RS4, RS6, S4, S6, S8). We also source Audi e-tron electric vehicles. Availability varies by model; contact us with your specific requirements.'],
    ['q' => 'Is Audi cheaper in Germany than in France?',
     'a' => 'Yes. Audi is manufactured in Ingolstadt and Neckarsulm in Germany. German-market vehicles benefit from the most competitive pricing in Europe. Savings of 10–20% versus equivalent French-market vehicles are typical, particularly for Avant estates (more popular in Germany) and RS/S models.'],
    ['q' => 'What makes Audi Avant (estate) from Germany a good buy?',
     'a' => 'The Audi A4 and A6 Avant are extremely popular in Germany but command a premium in France where estate cars are less common in the dealer network. German Avant specimens often come with higher specification levels (S-Line, sport suspension, panoramic roofs) at prices lower than comparable French-market examples.'],
    ['q' => 'Can I get an Audi with quattro from Germany?',
     'a' => 'Absolutely. quattro all-wheel drive is standard on most Audi RS and S models, and available on many A-series and Q-series vehicles. German supply of quattro-equipped Audis is significantly greater than in France, meaning better availability and more competitive pricing.'],
    ['q' => 'How do I import an Audi from Germany to France?',
     'a' => 'BARQAWI Cars handles the complete process: vehicle sourcing, history check, purchase, COC certificate, Abmeldebescheinigung (deregistration), road transport to France and delivery with full document pack. You then submit documents to the French ANTS portal for carte grise registration. We provide a complete document checklist.'],
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
        <span class="text-gray-600 font-medium">Audi Germany</span>
    </div>
</div>

{{-- Hero --}}
<section style="background:linear-gradient(135deg,#0D2D6D 0%,#1a4a9e 100%);" class="text-white py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="inline-block text-xs font-black uppercase tracking-widest mb-4 px-3 py-1.5 rounded-full" style="background:rgba(227,6,19,0.9);">Audi Export Specialist · Ingolstadt Region, Germany</span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight mb-5">Buy Audi from Germany —<br>Audi Vehicles at<br>German Market Prices</h1>
            <p class="text-white/80 text-lg leading-relaxed mb-8 max-w-2xl">Audi is built in Germany. Buy directly from the source with BARQAWI Cars and access the full Audi range — A-series, Q-series, RS and S models — with 10–20% savings versus French-market prices.</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('vehicles.index', ['locale' => 'en', 'brand' => 'Audi']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:opacity-90 hover:shadow-lg" style="background:#E30613; color:#fff;">Browse Audi Vehicles</a>
                <a href="{{ route('contact', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:bg-white/10" style="border:2px solid rgba(255,255,255,0.4); color:#fff;">Request an Audi</a>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-12 max-w-lg">
            @foreach([['num'=>'10–20%','label'=>'Price saving vs France'],['num'=>'Full','label'=>'Audi lineup available'],['num'=>'2–3 wks','label'=>'Delivery to France']] as $s)
            <div class="text-center p-4 rounded-xl" style="background:rgba(255,255,255,0.08);">
                <div class="text-xl font-black text-white">{{ $s['num'] }}</div>
                <div class="text-xs text-white/60 mt-1">{{ $s['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Why Audi from Germany --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Why Germany</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Why Buy an Audi from Germany?</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['title'=>'Built in Germany',            'text'=>'Audi\'s main production facilities are in Ingolstadt and Neckarsulm. German-specification vehicles have complete documentation and factory-standard equipment levels.'],
                ['title'=>'Avant Estates at Source',     'text'=>'Germany is the primary market for Audi Avant estate variants. Far more available than in France, often with higher spec and lower prices.'],
                ['title'=>'RS & S Model Availability',   'text'=>'Performance RS3, RS4, RS6, RS7, RS Q8, S4, S6 — Germany has the highest supply and most competitive prices for Audi performance models in Europe.'],
                ['title'=>'10–20% Lower Prices',         'text'=>'German Audi pricing is consistently more competitive than French equivalents. Savings are greatest on Avant, S-Line and RS variants.'],
                ['title'=>'quattro All-Wheel Drive',      'text'=>'quattro AWD is standard on all RS/S models and widely available on A-series and Q-series. Germany offers far more quattro inventory than France.'],
                ['title'=>'Full Service Histories',       'text'=>'German Audi owners typically maintain full Audi dealer service records. Scheckheft (service book) completion is higher than the European average.'],
            ] as $c)
            <div class="rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="font-bold text-sm mb-2" style="color:#0D2D6D;">{{ $c['title'] }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed">{{ $c['text'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Popular Models --}}
<section class="py-14" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Audi Range</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Popular Audi Models from Germany</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach([
                ['model'=>'Audi A4 / A4 Avant', 'gen'=>'B9 · 2015–present', 'text'=>'The most-sourced Audi from Germany. S-Line Avant variants with 40 TDI or 45 TFSI are in constant demand, often 15% below French prices.'],
                ['model'=>'Audi A6 / A6 Avant', 'gen'=>'C8 · 2018–present', 'text'=>'Executive sedan and estate. 55 TFSI and 50 TDI variants with Matrix LED, head-up display and adaptive suspension available at excellent prices.'],
                ['model'=>'Audi Q5',             'gen'=>'FY · 2016–present', 'text'=>'BARQAWI\'s most-exported Audi SUV. 40 TDI quattro and 45 TFSI e plug-in hybrid are consistently well-priced in Germany versus France.'],
                ['model'=>'Audi Q7',             'gen'=>'4M · 2015–present', 'text'=>'7-seat luxury SUV. 55 TFSI and 50 TDI e hybrid versions with full options and low mileage available at significant savings.'],
                ['model'=>'Audi RS4 / RS6',      'gen'=>'B9/C8 · RS models',  'text'=>'Germany\'s most sought-after Audi performance estates. RS4 Avant and RS6 Avant are emblematic German vehicles rarely found at competitive prices in France.'],
                ['model'=>'Audi e-tron / Q8 e-tron','gen'=>'GE/GE · electric','text'=>'Pre-owned Audi electric vehicles with battery health certification, remaining warranty and German market pricing advantages.'],
            ] as $m)
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="font-black text-sm" style="color:#0D2D6D;">{{ $m['model'] }}</h3>
                    <span class="text-[10px] font-semibold text-gray-400 shrink-0 ml-2 mt-0.5">{{ $m['gen'] }}</span>
                </div>
                <p class="text-xs text-gray-500 leading-relaxed">{{ $m['text'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('vehicles.index', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3 rounded-xl transition-all hover:shadow-md" style="background:#0D2D6D; color:#fff;">
                See All Available Audis →
            </a>
        </div>
    </div>
</section>

{{-- Process --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Process</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">How to Import an Audi from Germany</h2>
        </div>
        <div class="max-w-3xl mx-auto space-y-4">
            @foreach([
                ['num'=>'01','title'=>'Define your Audi',            'text'=>'Share model, generation, engine, transmission, colour and any specific options (S-Line, quattro, Avant). The more specific, the faster we find your match.'],
                ['num'=>'02','title'=>'Sourcing & verification',     'text'=>'We locate matching vehicles in Germany, verify VIN history, check for accident records, validate TÜV status and review the full service book.'],
                ['num'=>'03','title'=>'Detailed offer',              'text'=>'You receive a complete quote: vehicle price, BARQAWI export fee, transport cost and total delivered price. Fully transparent, no hidden costs.'],
                ['num'=>'04','title'=>'Purchase & export documents', 'text'=>'We buy the vehicle, collect original Fahrzeugbrief, prepare COC, invoice, Abmeldebescheinigung and all documents needed for French registration.'],
                ['num'=>'05','title'=>'Delivery to France',          'text'=>'Road transport to France in 3–5 days. Delivered to your address with the complete document pack for ANTS carte grise registration.'],
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
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Frequently Asked Questions — Audi Germany</h2>
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
        <p class="text-xs font-black uppercase tracking-widest mb-4 text-gray-400">Related Pages</p>
        <div class="flex flex-wrap gap-3">
            @foreach([
                ['url' => route('landing.used_cars_germany',     ['locale'=>'en']), 'label' => 'Used Cars Germany'],
                ['url' => route('landing.car_export_germany',    ['locale'=>'en']), 'label' => 'Car Export Germany'],
                ['url' => route('landing.bmw_germany',           ['locale'=>'en']), 'label' => 'BMW Germany'],
                ['url' => route('landing.mercedes_germany',      ['locale'=>'en']), 'label' => 'Mercedes Germany'],
                ['url' => route('landing.import_germany_france', ['locale'=>'en']), 'label' => 'Import Car Germany → France'],
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
        <h2 class="text-2xl sm:text-3xl font-black text-white mb-4">Ready to Buy an Audi from Germany?</h2>
        <p class="text-white/70 max-w-xl mx-auto mb-8 leading-relaxed">Tell us your target Audi. BARQAWI Cars will locate it in Germany, verify its history and deliver it to France with all documentation ready for registration.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('vehicles.index', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:opacity-90 transition-all" style="background:#E30613; color:#fff;">Browse Audi Catalogue</a>
            <a href="{{ route('contact', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:bg-white/10 transition-all" style="border:2px solid rgba(255,255,255,0.4); color:#fff;">Request an Audi</a>
            <a href="https://wa.me/491726994705?text={{ rawurlencode('Hello, I am looking for an Audi from Germany.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:opacity-90 transition-colors" style="background:#25D366; color:#fff;">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.524 5.847L.057 23.882l6.19-1.624A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.845 0-3.574-.5-5.063-1.37l-.363-.214-3.755.985.999-3.648-.236-.376A9.94 9.94 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection
