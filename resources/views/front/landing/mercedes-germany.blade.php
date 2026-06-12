@extends('layouts.app')
@section('title',       'Mercedes Germany | Buy Mercedes-Benz Directly from Germany | BARQAWI Cars')
@section('description', 'Buy a Mercedes-Benz directly from Germany with BARQAWI Cars. Discover C-Class, E-Class, GLE, GLC and AMG models at German market prices with export service to France and Europe.')

@push('structured_data')
@php
$breadcrumbLd = [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',             'item' => route('home', ['locale' => 'en'])],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Mercedes Germany', 'item' => url()->current()],
    ],
];
$faqItems = [
    ['q' => 'Which Mercedes-Benz models can I buy from Germany?',
     'a' => 'BARQAWI Cars sources the full Mercedes-Benz lineup from Germany: A-Class, B-Class, C-Class (W205/W206), E-Class (W213), S-Class, GLA, GLC, GLE, GLS, and performance AMG models (C 43, C 63, E 53, E 63, GLE 53, G 63). We also source Mercedes-EQ electric vehicles (EQC, EQA, EQE, EQS). Contact us with your specific model and requirements.'],
    ['q' => 'Is Mercedes-Benz cheaper in Germany than in France?',
     'a' => 'Yes. Mercedes-Benz is headquartered in Stuttgart and manufactures vehicles in Sindelfingen, Bremen and other German plants. German-market pricing is typically 10–20% lower than French equivalents, especially for well-equipped AMG-Line, 4MATIC and AMG Performance models which command a larger premium in the French market.'],
    ['q' => 'What is the most popular Mercedes to buy from Germany?',
     'a' => 'The E-Class (W213) Estate and the GLE are BARQAWI\'s most-exported Mercedes-Benz models. The E-Class Estate with 400d 4MATIC and AMG-Line specification is particularly sought after, offering significant savings versus French market pricing. GLE 350de plug-in hybrid models with low mileage and warranty are also in high demand.'],
    ['q' => 'Can I buy a Mercedes-AMG from Germany?',
     'a' => 'Yes. Germany is the primary market for Mercedes-AMG vehicles. AMG C 43, C 63, E 53, E 63 S, GLE 53 and G 63 are more plentiful and better priced in Germany than anywhere else in Europe. BARQAWI Cars has specific experience sourcing AMG models with full documentation and verified performance specifications.'],
    ['q' => 'Does Mercedes warranty transfer when buying from Germany?',
     'a' => 'Mercedes-Benz manufacturer warranty is Europe-wide and transfers with the vehicle regardless of country of origin. Vehicles with remaining factory warranty (typically 2 years from first registration) retain coverage in France. Certified Mercedes-Benz Pre-Owned vehicles include a 12-month dealer warranty. BARQAWI verifies warranty status for every vehicle.'],
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
        <span class="text-gray-600 font-medium">Mercedes Germany</span>
    </div>
</div>

{{-- Hero --}}
<section style="background:linear-gradient(135deg,#0D2D6D 0%,#1a4a9e 100%);" class="text-white py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="inline-block text-xs font-black uppercase tracking-widest mb-4 px-3 py-1.5 rounded-full" style="background:rgba(227,6,19,0.9);">Mercedes-Benz Export Specialist · Stuttgart, Germany</span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight mb-5">Buy Mercedes from Germany —<br>Mercedes-Benz<br>at Source Prices</h1>
            <p class="text-white/80 text-lg leading-relaxed mb-8 max-w-2xl">Mercedes-Benz is headquartered in Stuttgart — just minutes from BARQAWI Cars. We give you direct access to the German market's finest Mercedes-Benz vehicles: C-Class, E-Class, GLE, S-Class and AMG at 10–20% below French market prices.</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('vehicles.index', ['locale' => 'en', 'brand' => 'Mercedes-Benz']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:opacity-90 hover:shadow-lg" style="background:#E30613; color:#fff;">Browse Mercedes Vehicles</a>
                <a href="{{ route('contact', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:bg-white/10" style="border:2px solid rgba(255,255,255,0.4); color:#fff;">Request a Mercedes</a>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-12 max-w-lg">
            @foreach([['num'=>'Stuttgart','label'=>'Mercedes HQ — 20 min away'],['num'=>'10–20%','label'=>'Saving vs France'],['num'=>'AMG','label'=>'Performance models']] as $s)
            <div class="text-center p-4 rounded-xl" style="background:rgba(255,255,255,0.08);">
                <div class="text-xl font-black text-white">{{ $s['num'] }}</div>
                <div class="text-xs text-white/60 mt-1">{{ $s['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Why Mercedes from Germany --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Why Germany</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Why Buy a Mercedes-Benz from Germany?</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['title'=>'Manufactured Near Fellbach',  'text'=>'Mercedes-Benz HQ and the Sindelfingen plant are 20 minutes from BARQAWI Cars. We have direct access to the German used Mercedes market and dealer network.'],
                ['title'=>'AMG Models at Best Prices',   'text'=>'AMG C 43, C 63, E 53, E 63, GLE 53 and G 63 are most plentiful and competitively priced in Germany — the home market of the AMG performance division.'],
                ['title'=>'Estate & 4MATIC Availability','text'=>'E-Class and C-Class estates with 4MATIC AWD are Germany\'s most popular body style. Far more available than in France with a wider range of specifications.'],
                ['title'=>'Europe-Wide Warranty',        'text'=>'Mercedes-Benz manufacturer warranty applies across Europe. Vehicles within warranty retain coverage in France with no additional registration required.'],
                ['title'=>'Full Service Records',        'text'=>'German Mercedes owners maintain rigorous service records via the official Mercedes me service system. Complete histories are standard on well-cared-for vehicles.'],
                ['title'=>'EQ Electric Vehicles',        'text'=>'Germany leads Europe in Mercedes-EQ adoption. EQC, EQA, EQB, EQE and EQS are available at competitive prices with battery health documentation.'],
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
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Mercedes Range</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Popular Mercedes-Benz Models from Germany</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach([
                ['model'=>'Mercedes C-Class',    'gen'=>'W205/W206 · 2014–present','text'=>'BARQAWI\'s most-sourced Mercedes. C 220d and C 300de Estate with AMG-Line, panoramic roof and head-up display at 12–18% below French market prices.'],
                ['model'=>'Mercedes E-Class',    'gen'=>'W213 · 2016–present',      'text'=>'Executive sedan and Estate (T-Model). E 220d, E 400d and E 350de plug-in hybrid in Estate form with 4MATIC — the benchmark German premium vehicle.'],
                ['model'=>'Mercedes GLE',        'gen'=>'V167 · 2018–present',      'text'=>'Large luxury SUV. GLE 300d, 350de and 400d 4MATIC available with AMG-Line, 7-seat configuration and full MBUX infotainment at excellent prices.'],
                ['model'=>'Mercedes GLC',        'gen'=>'X254 · 2022–present',      'text'=>'Mid-size SUV — Germany\'s most popular SUV segment. GLC 220d, 300d and 300e plug-in with AMG-Line and latest-generation MBUX.'],
                ['model'=>'Mercedes S-Class',    'gen'=>'W222/W223 · 2013–present', 'text'=>'Flagship luxury sedan. S 350d, S 400d and S 560 4MATIC with full options including Burmester sound, rear entertainment and executive packages.'],
                ['model'=>'Mercedes-AMG',        'gen'=>'C 43 · E 53 · GLE 53 · G 63','text'=>'BARQAWI\'s AMG sourcing covers the full AMG performance range. Germany offers the best availability and pricing for all AMG models.'],
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
                See All Available Mercedes →
            </a>
        </div>
    </div>
</section>

{{-- Process --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Process</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">How to Buy a Mercedes from Germany</h2>
        </div>
        <div class="max-w-3xl mx-auto space-y-4">
            @foreach([
                ['num'=>'01','title'=>'Define your Mercedes',        'text'=>'Tell us model, class, engine, colour, options (AMG-Line, 4MATIC, panoramic). Specific requirements help us source exactly what you want faster.'],
                ['num'=>'02','title'=>'Sourcing in the Stuttgart area','text'=>'We leverage our proximity to Stuttgart (Mercedes HQ) to source vehicles from authorised Mercedes dealers, certified pre-owned programmes and the private market.'],
                ['num'=>'03','title'=>'History verification',         'text'=>'We check VIN history, confirm TÜV validity, verify service records via the official Mercedes service system, and inspect for any prior damage.'],
                ['num'=>'04','title'=>'Export documentation',         'text'=>'We prepare COC, purchase invoice, Abmeldebescheinigung, and all documents required for French ANTS registration. Warranty documentation included.'],
                ['num'=>'05','title'=>'Delivery to France',           'text'=>'Road transport to France in 3–5 days. Delivered to your address with the complete document pack. We provide a registration checklist for ANTS.'],
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
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Frequently Asked Questions — Mercedes Germany</h2>
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
                ['url' => route('landing.audi_germany',          ['locale'=>'en']), 'label' => 'Audi Germany'],
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
        <h2 class="text-2xl sm:text-3xl font-black text-white mb-4">Ready to Buy a Mercedes from Germany?</h2>
        <p class="text-white/70 max-w-xl mx-auto mb-8 leading-relaxed">BARQAWI Cars is located 20 minutes from Mercedes-Benz HQ in Stuttgart. Tell us which model you want — we'll source it, verify it and deliver it to France with full documentation.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('vehicles.index', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:opacity-90 transition-all" style="background:#E30613; color:#fff;">Browse Mercedes Catalogue</a>
            <a href="{{ route('contact', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:bg-white/10 transition-all" style="border:2px solid rgba(255,255,255,0.4); color:#fff;">Request a Mercedes</a>
            <a href="https://wa.me/491726994705?text={{ rawurlencode('Hello, I am looking for a Mercedes-Benz from Germany.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:opacity-90 transition-colors" style="background:#25D366; color:#fff;">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.524 5.847L.057 23.882l6.19-1.624A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.845 0-3.574-.5-5.063-1.37l-.363-.214-3.755.985.999-3.648-.236-.376A9.94 9.94 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection
