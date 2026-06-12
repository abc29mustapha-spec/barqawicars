@extends('layouts.app')
@section('title',       'BMW Germany | Buy BMW from Germany | BARQAWI Cars')
@section('description', 'Buy a BMW from Germany with BARQAWI Cars. Full range — 3 Series to M models — at 10–25% below French market prices. Delivery to France in 2–3 weeks.')
@section('keywords',    'BMW Germany, buy BMW from Germany, BMW import Germany France, used BMW Germany, BMW M Germany, BMW cheaper Germany France')

@push('structured_data')
@php
$breadcrumbLd = [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',        'item' => route('home', ['locale' => 'en'])],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'BMW Germany', 'item' => url()->current()],
    ],
];
$faqItems = [
    ['q' => 'Why is BMW cheaper in Germany than in France?',
     'a' => 'BMW\'s main production facilities are in Munich, Dingolfing and Regensburg. Being the home market, Germany has the highest supply of BMW vehicles, creating natural price competition between dealers and private sellers. French importers also pay logistical premiums built into dealer margins. The result is typically 10–25% lower prices in Germany for comparable specifications.'],
    ['q' => 'Which BMW models are most commonly sourced from Germany?',
     'a' => 'BARQAWI Cars most frequently exports BMW 3 Series (G20 — especially 320d and M340i Touring), BMW X3 (xDrive30d and M40i), BMW X5 (xDrive40d and xDrive45e), BMW 5 Series (530d and M550i Touring) and BMW M models (M3 Competition, M4 Competition, M5). All models are available in the full range of specifications, including options rarely found in France.'],
    ['q' => 'Does BMW warranty transfer when buying from Germany?',
     'a' => 'Yes. BMW\'s manufacturer warranty (2 years for new vehicles from date of first registration) is valid throughout Europe, including France. A German BMW within its original warranty period retains full coverage in France without any re-registration of the warranty. BMW Premium Selection certified pre-owned vehicles include an additional 12-month dealer warranty.'],
    ['q' => 'Can I buy a BMW M model from Germany through BARQAWI?',
     'a' => 'Yes. Germany is the single largest market for BMW M performance vehicles in Europe. M3 Competition, M4 Competition, M4 CSL, M5 Competition and M8 Competition are more plentiful and better priced in Germany than anywhere else. BARQAWI Cars specialises in sourcing M models with verified specifications, correct Competition packages and full TÜV documentation.'],
    ['q' => 'How long does delivery take for a BMW from Germany to France?',
     'a' => 'From vehicle agreement to delivery at your address in France, the process typically takes 2–3 weeks: 3–5 days to source and finalise the purchase, 2–3 days for export documentation (COC, Abmeldung, invoice), and 3–5 days road transport. We keep you updated throughout and confirm the delivery date at least 48 hours in advance.'],
    ['q' => 'Can I order a new BMW from Germany through BARQAWI?',
     'a' => 'BARQAWI Cars specialises in pre-owned vehicles. For nearly-new BMWs (under 12 months old, low mileage), we source certified stock from German BMW dealers. For factory-order new vehicles, we recommend contacting a German BMW dealer directly. We can refer you to trusted partners in the Stuttgart area.'],
    ['q' => 'What is the BMW Premium Selection programme?',
     'a' => 'BMW Premium Selection is BMW\'s certified pre-owned programme. Vehicles must pass a 100+ point inspection by an authorised BMW technician, have a valid service history, be under a certain age and mileage threshold. They come with a 12-month unlimited mileage dealer warranty and roadside assistance. BARQAWI actively sources Premium Selection vehicles from German BMW dealerships.'],
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
        <span class="text-gray-600 font-medium">BMW Germany</span>
    </div>
</div>

{{-- Hero --}}
<section style="background:linear-gradient(135deg,#0D2D6D 0%,#1c3a7e 100%);" class="text-white py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="inline-block text-xs font-black uppercase tracking-widest mb-4 px-3 py-1.5 rounded-full" style="background:rgba(227,6,19,0.9);">BMW Export Specialist · Fellbach — 45 min from Munich</span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight mb-5">Buy BMW from Germany —<br>Premium BMW Vehicles<br>at German Market Prices</h1>
            <p class="text-white/80 text-lg leading-relaxed mb-8 max-w-2xl">
                BMW is <em>Bayerische Motoren Werke</em> — Bavarian Motor Works. Buying directly from Germany means buying from the home market of the brand: the widest selection, the most competitive prices (10–25% below France) and the best access to M performance models.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('vehicles.index', ['locale' => 'en', 'brand' => 'BMW']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:opacity-90 hover:shadow-lg" style="background:#E30613; color:#fff;">Browse BMW Vehicles</a>
                <a href="{{ route('contact', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:bg-white/10" style="border:2px solid rgba(255,255,255,0.4); color:#fff;">Request a BMW</a>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-12 max-w-2xl">
            @foreach([
                ['num'=>'Bavaria','label'=>'BMW home territory'],
                ['num'=>'10–25%','label'=>'Price saving vs France'],
                ['num'=>'M & CPO','label'=>'Performance & Premium Selection'],
                ['num'=>'2–3 wks','label'=>'Delivery to France'],
            ] as $s)
            <div class="text-center p-4 rounded-xl" style="background:rgba(255,255,255,0.08);">
                <div class="text-lg font-black text-white">{{ $s['num'] }}</div>
                <div class="text-xs text-white/60 mt-1 leading-snug">{{ $s['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Why Buy BMW at the Bavarian Source --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">BMW-Specific Advantages</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Germany — Home of BMW: Why Buy at the Source?</h2>
            <p class="text-gray-500 mt-3 leading-relaxed">
                These are not generic "Germany is cheap" arguments. These are advantages specific to buying a BMW from its home country.
            </p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['title' => 'Built in Bavaria — Bought in Bavaria',
                 'text'  => 'BMW\'s main plants are in Munich, Dingolfing and Regensburg — all within the German domestic market. German-registered vehicles are factory-spec with complete German Scheckheft (service book) and VIN-traceable history from the first owner.'],
                ['title' => 'BMW M GmbH — M Models at Source',
                 'text'  => 'BMW M GmbH is based in Garching bei München, 20 minutes from BMW HQ. Germany is the primary retail market for every M model. M3 Competition, M4 CSL, M5 and M8 Competition are more plentiful and significantly better priced in Germany than anywhere else in Europe.'],
                ['title' => 'BMW Premium Selection (CPO)',
                 'text'  => 'BMW\'s certified pre-owned programme — BMW Premium Selection — is most extensive and best-priced in Germany. Vehicles pass a 100+ point inspection, include 12-month unlimited-mileage warranty and roadside assistance. BARQAWI actively sources Premium Selection stock.'],
                ['title' => 'Configuration Breadth Only Available in Germany',
                 'text'  => 'German BMW buyers order heavily optioned vehicles. Individual colour combinations, M Sport Plus packages, Bowers & Wilkins audio, sky lounge panoramic roofs — configurations rarely found in French dealer stock are standard fare in the German used market.'],
                ['title' => '10–25% Lower Prices, Verified',
                 'text'  => 'Based on regular market comparisons, German BMW prices are consistently 10–25% lower than French-market equivalents. The saving is largest on M models, full-equipment versions and nearly-new vehicles (12–36 months). See the comparison table below.'],
                ['title' => 'Complete Digital Service Records',
                 'text'  => 'Most German BMW owners use the BMW Online Service History (OSH) system — digital service records accessible by VIN. BARQAWI verifies OSH completeness for every vehicle, giving you verifiable full service history rather than a paper service book that can be falsified.'],
            ] as $c)
            <div class="rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="font-bold text-sm mb-2" style="color:#0D2D6D;">{{ $c['title'] }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed">{{ $c['text'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Price Comparison Table --}}
<section class="py-14" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Price Comparison</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">BMW Germany vs France — Real Price Examples</h2>
            <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                Indicative prices based on market observations Q2 2026. BARQAWI total includes vehicle, export fee and road transport to France.
            </p>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-sm bg-white">
            <table class="w-full text-sm">
                <thead>
                    <tr style="background:#0D2D6D; color:#fff;">
                        <th class="text-left px-5 py-4 font-bold text-xs">BMW Model</th>
                        <th class="text-center px-4 py-4 font-bold text-xs">Year</th>
                        <th class="text-right px-4 py-4 font-bold text-xs whitespace-nowrap">Germany</th>
                        <th class="text-right px-4 py-4 font-bold text-xs whitespace-nowrap">BARQAWI All-in*</th>
                        <th class="text-right px-4 py-4 font-bold text-xs whitespace-nowrap">French Market</th>
                        <th class="text-right px-5 py-4 font-bold text-xs whitespace-nowrap">Net Saving</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach([
                        ['model'=>'BMW 320d xDrive Touring M Sport',    'year'=>'2022','de'=>'28 500','allin'=>'30 800','fr'=>'37 500','save'=>'6 700','pct'=>'18%'],
                        ['model'=>'BMW X3 xDrive30d M Sport (G01)',      'year'=>'2021','de'=>'35 900','allin'=>'38 200','fr'=>'46 500','save'=>'8 300','pct'=>'18%'],
                        ['model'=>'BMW X5 xDrive40d M Sport (G05)',      'year'=>'2021','de'=>'54 000','allin'=>'57 000','fr'=>'70 000','save'=>'13 000','pct'=>'19%'],
                        ['model'=>'BMW 530d Touring M Sport (G31)',      'year'=>'2022','de'=>'41 500','allin'=>'44 000','fr'=>'52 000','save'=>'8 000','pct'=>'15%'],
                        ['model'=>'BMW M3 Competition (G80)',             'year'=>'2022','de'=>'76 000','allin'=>'78 800','fr'=>'95 000','save'=>'16 200','pct'=>'17%'],
                        ['model'=>'BMW X5 M Competition (F95)',           'year'=>'2021','de'=>'98 000','allin'=>'101 500','fr'=>'122 000','save'=>'20 500','pct'=>'17%'],
                    ] as $r)
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-3.5 font-medium text-gray-800 text-xs">{{ $r['model'] }}</td>
                        <td class="px-4 py-3.5 text-center text-gray-500 text-xs">{{ $r['year'] }}</td>
                        <td class="px-4 py-3.5 text-right text-gray-600 text-xs whitespace-nowrap">{{ $r['de'] }} €</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-xs whitespace-nowrap" style="color:#0D2D6D;">{{ $r['allin'] }} €</td>
                        <td class="px-4 py-3.5 text-right text-gray-400 text-xs line-through whitespace-nowrap">{{ $r['fr'] }} €</td>
                        <td class="px-5 py-3.5 text-right text-xs whitespace-nowrap">
                            <span class="inline-flex items-center gap-1 font-black px-2.5 py-1 rounded-lg" style="background:#DCFCE7; color:#166534;">
                                −{{ $r['save'] }} € <span class="font-semibold">({{ $r['pct'] }})</span>
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="text-xs text-gray-400 mt-3 text-center">* BARQAWI all-in = German vehicle price + export service fee (€890–€1,490) + road transport to France (€700–€1,100). French carte grise and contrôle technique not included. Prices indicative.</p>
        <div class="text-center mt-6">
            <a href="{{ route('landing.import_germany_france', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-semibold px-5 py-2.5 rounded-xl border border-gray-300 bg-white hover:border-gray-400 hover:shadow-sm transition-all text-gray-700">
                See the complete cost breakdown for importing to France →
            </a>
        </div>
    </div>
</section>

{{-- Popular Models --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">BMW Range</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Popular BMW Models from Germany</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach([
                ['model'=>'BMW 3 Series',  'gen'=>'G20 · 2019–present', 'text'=>'Europe\'s best-selling premium sedan. Most popular BARQAWI export: 320d Touring M Sport and M340i xDrive. German stock is 3× larger than France with far greater spec diversity.'],
                ['model'=>'BMW 5 Series',  'gen'=>'G30/G60 · 2017–present','text'=>'Executive sedan and Touring estate. 530d, M550i and the new 520d G60 are in constant demand. German M Sport Touring specimens save €8,000–€12,000 versus France.'],
                ['model'=>'BMW X3',        'gen'=>'G01 · 2017–present', 'text'=>'BARQAWI\'s most-exported BMW SUV. xDrive30d M Sport is the sweet spot: full equipment, below-budget French market pricing. TÜV HU often valid 24 months.'],
                ['model'=>'BMW X5',        'gen'=>'G05 · 2018–present', 'text'=>'xDrive40d and xDrive45e plug-in hybrid. 7-seat configuration more common in German stock. X5 M Competition available through our Munich dealer network.'],
                ['model'=>'BMW 7 Series',  'gen'=>'G70 · 2022–present', 'text'=>'Flagship luxury sedan with electric driving range. 740d and 750e xDrive with executive rear lounge — configurations rarely found in France at comparable prices.'],
                ['model'=>'BMW M Series',  'gen'=>'M3 · M4 · M5 · M8',  'text'=>'Germany is the primary retail market for BMW M. M3 G80, M4 CSL, M5 Competition and M8 Competition all sourceable. Verified Competition packages, BMW OSH service records.'],
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
                See All Available BMWs →
            </a>
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="py-14" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Client Experiences</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">BMW Buyers Through BARQAWI Cars</h2>
        </div>
        <div class="grid sm:grid-cols-3 gap-5">
            @foreach([
                [
                    'initial' => 'T.L.',
                    'name'    => 'Thomas L.',
                    'city'    => 'Strasbourg (67)',
                    'vehicle' => 'BMW M340i xDrive Touring, 2022',
                    'saving'  => '€9,500 saved',
                    'quote'   => 'I wanted an M340i with M Sport Pro pack, Frozen Grey, head-up display. This spec didn\'t exist in France below €52,000. BARQAWI found it in Munich at €41,000. Delivered in 17 days. Exactly as described. Fenomenal service.',
                    'date'    => 'February 2026',
                ],
                [
                    'initial' => 'R.M.',
                    'name'    => 'Rachid M.',
                    'city'    => 'Casablanca, Morocco',
                    'vehicle' => 'BMW X5 xDrive40d 7-Seat, 2021',
                    'saving'  => '7-seat spec unavailable locally',
                    'quote'   => 'BARQAWI sourced exactly the X5 I needed — 7 seats, xDrive40d, TÜV valid 2 years, full service history from a Munich BMW dealer. Delivered to Casablanca in 5.5 weeks including sea freight. All customs paperwork handled.',
                    'date'    => 'November 2025',
                ],
                [
                    'initial' => 'M.D.',
                    'name'    => 'Marie-France D.',
                    'city'    => 'Lyon (69)',
                    'vehicle' => 'BMW 530d Touring M Sport, 2022',
                    'saving'  => '€8,200 saved',
                    'quote'   => 'French stock for the 530d Touring was terrible — either high mileage or poorly equipped. In Germany there were 50+ matching my criteria. Got the exact config I wanted, €8,200 cheaper than the only French dealer offering it. Recommend BARQAWI to everyone.',
                    'date'    => 'March 2026',
                ],
            ] as $t)
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex flex-col">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center text-white font-black text-sm shrink-0" style="background:#0D2D6D;">
                        {{ $t['initial'] }}
                    </div>
                    <div>
                        <p class="font-bold text-sm" style="color:#0D2D6D;">{{ $t['name'] }}</p>
                        <p class="text-xs text-gray-400">{{ $t['city'] }}</p>
                    </div>
                    <span class="ml-auto text-xs font-black px-2.5 py-1 rounded-lg shrink-0 text-center leading-snug" style="background:#DCFCE7; color:#166534;">{{ $t['saving'] }}</span>
                </div>
                <p class="text-xs text-gray-500 leading-relaxed mb-4 flex-1">"{{ $t['quote'] }}"</p>
                <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-[11px] text-gray-400 font-medium">{{ $t['vehicle'] }}</span>
                    <span class="text-[11px] text-gray-400">{{ $t['date'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Process --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Process</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Your BMW Germany Purchase — Step by Step</h2>
        </div>
        <div class="max-w-3xl mx-auto space-y-4">
            @foreach([
                ['num'=>'01','title'=>'Define your BMW precisely',
                 'text'=>'Model, generation (e.g. G20 not F30), engine, xDrive or RWD, gearbox, colour, M Sport / M Sport Pro / M Performance package. The more precise, the faster we find the match.'],
                ['num'=>'02','title'=>'BARQAWI locates and verifies',
                 'text'=>'We search German BMW dealers, BMW Premium Selection programmes and private-seller channels. VIN verified via BMW OSH (digital service history), TÜV validity confirmed, DEKRA report reviewed.'],
                ['num'=>'03','title'=>'Transparent all-in offer',
                 'text'=>'You receive: German price, BARQAWI export fee, road transport cost and all-in delivered price in France. All costs disclosed upfront. We never add hidden fees after agreement.'],
                ['num'=>'04','title'=>'Purchase and export documentation',
                 'text'=>'We purchase the vehicle, collect original Fahrzeugbrief, obtain COC if not present, register deregistration (Abmeldung) at the KBA and prepare the complete ANTS registration pack.'],
                ['num'=>'05','title'=>'Delivery to France',
                 'text'=>'Enclosed road transport to France in 3–5 days. Vehicle delivered to your address with the complete document pack. We remain available for ANTS registration support.'],
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
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Frequently Asked Questions — BMW Germany</h2>
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
                ['url' => route('landing.import_germany_france', ['locale'=>'en']), 'label' => 'Import Car Germany → France'],
                ['url' => route('landing.used_cars_germany',     ['locale'=>'en']), 'label' => 'Used Cars Germany'],
                ['url' => route('landing.car_export_germany',    ['locale'=>'en']), 'label' => 'Car Export Germany'],
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
        <h2 class="text-2xl sm:text-3xl font-black text-white mb-4">Ready to Buy a BMW from Germany?</h2>
        <p class="text-white/70 max-w-xl mx-auto mb-8 leading-relaxed">Tell us which BMW model you are looking for. BARQAWI Cars will source it in Germany, verify the service history and deliver it to France with all documents ready for registration.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('vehicles.index', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:opacity-90 transition-all" style="background:#E30613; color:#fff;">Browse BMW Catalogue</a>
            <a href="{{ route('contact', ['locale' => 'en']) }}" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:bg-white/10 transition-all" style="border:2px solid rgba(255,255,255,0.4); color:#fff;">Request a BMW</a>
            <a href="https://wa.me/491726994705?text={{ rawurlencode('Hello, I am looking for a BMW from Germany.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:opacity-90 transition-colors" style="background:#25D366; color:#fff;">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.524 5.847L.057 23.882l6.19-1.624A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.845 0-3.574-.5-5.063-1.37l-.363-.214-3.755.985.999-3.648-.236-.376A9.94 9.94 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection
