@extends('layouts.app')
@section('title',       'Car Export Germany | Vehicle Export Service from Germany | BARQAWI Cars')
@section('description', 'Professional car export from Germany to France, Morocco, Algeria and Europe. BARQAWI Cars in Fellbach — sourcing, documentation, transport from Germany.')
@section('keywords',    'car export germany, vehicle export from germany, export voiture allemagne, car export germany france, car export germany morocco, car export germany algeria, mandataire germany')

@push('structured_data')
@php
$breadcrumbLd = [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',              'item' => route('home', ['locale' => 'en'])],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Car Export Germany','item' => url()->current()],
    ],
];
$faqItems = [
    ['q' => 'Which countries does BARQAWI export cars to from Germany?',
     'a' => 'BARQAWI Cars exports vehicles from Germany to France, Morocco, Algeria, Tunisia, Switzerland, Belgium, the Netherlands, Spain and many other countries worldwide. We adapt documentation and logistics to each destination — EU exports require COC and Abmeldung, while non-EU exports require customs declarations, a bill of lading and destination-specific compliance documents.'],
    ['q' => 'How much does car export from Germany cost?',
     'a' => 'Export costs depend on the destination and transport method. Road export to France: €700–€1,100. Belgium/Netherlands: €600–€900. Switzerland: €700–€1,000 plus Swiss customs duties. North Africa (Morocco, Algeria, Tunisia): €1,800–€3,000 including road pre-carriage and sea freight from Mediterranean ports. BARQAWI service fee (€890–€1,490) covers sourcing, documentation and coordination. Request a personalised quote for your specific vehicle and destination.'],
    ['q' => 'What customs duties apply when exporting a car from Germany to North Africa?',
     'a' => 'For Morocco: import duty is typically 2.5% for EU-manufactured vehicles (under Euro-Med Agreement), plus domestic taxes (TVA, TPV). For Algeria: customs duty varies by vehicle age and engine size — typically 5–30% plus local taxes. For Tunisia: duties vary but are generally 10–50% depending on vehicle type. BARQAWI prepares all customs documentation and can refer you to local customs agents in each country.'],
    ['q' => 'How long does car export from Germany take?',
     'a' => 'Export timeline depends on destination. France: 3–7 days road transport. Belgium/Netherlands: 2–5 days. Switzerland: 5–10 days including customs clearance. Morocco/Algeria/Tunisia: 3–6 weeks, including road pre-carriage to Spanish or French Mediterranean ports, sea freight (RoRo), port clearance and final delivery. We provide a detailed timeline estimate at the quotation stage.'],
    ['q' => 'Is car export from Germany to Europe VAT-free for professionals?',
     'a' => 'Professional buyers (VAT-registered entities) purchasing vehicles in Germany for export to another EU country can benefit from zero German VAT on the purchase under intra-EU export rules (§ 6a UStG). This is a significant advantage for mandataires and resellers. BARQAWI can structure transactions for VAT-registered professionals across Europe. Contact us with your fiscal details for a professional export assessment.'],
    ['q' => 'What documents does BARQAWI prepare for car export?',
     'a' => 'For every export, BARQAWI Cars prepares: Certificate of Conformity (COC), original purchase invoice, German deregistration certificate (Abmeldebescheinigung), Zulassungsbescheinigung Teil II (vehicle title), vehicle history report (DEKRA/TÜV), and for non-EU destinations: export customs declaration, CMR international waybill, and bill of lading coordination for sea freight. All documents translated or apostilled on request.'],
    ['q' => 'Can BARQAWI export electric vehicles from Germany?',
     'a' => 'Yes. BARQAWI Cars exports electric and hybrid vehicles from Germany, including BMW i-series (i4, iX, i7), Mercedes EQ (EQC, EQS), Audi e-tron, Volkswagen ID.4 and Tesla models available in Germany. We provide battery state-of-health reports, remaining warranty documentation and guidance on charging standards (Type 2 / CCS) compatibility in the destination country.'],
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
        <span class="text-gray-600 font-medium">Car Export Germany</span>
    </div>
</div>

{{-- Hero --}}
<section style="background:linear-gradient(135deg,#0D2D6D 0%,#1a4a9e 100%);" class="text-white py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="inline-block text-xs font-black uppercase tracking-widest mb-4 px-3 py-1.5 rounded-full" style="background:rgba(227,6,19,0.9);">Vehicle Export Specialist · Fellbach, Germany</span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight mb-5">
                Car Export Germany —<br>Professional Vehicle Export<br>to France, North Africa &amp; Europe
            </h1>
            <p class="text-white/80 text-lg leading-relaxed mb-8 max-w-2xl">
                Based in Fellbach near Stuttgart, BARQAWI Cars has been exporting vehicles from Germany since 2012. We serve private buyers, mandataires and professional resellers across France, Morocco, Algeria, Tunisia, Switzerland and beyond — handling every step from sourcing to door-to-door delivery.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('vehicles.index', ['locale' => 'en']) }}"
                   class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:opacity-90 hover:shadow-lg"
                   style="background:#E30613; color:#fff;">Browse Available Vehicles</a>
                <a href="{{ route('contact', ['locale' => 'en']) }}"
                   class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:bg-white/10"
                   style="border:2px solid rgba(255,255,255,0.4); color:#fff;">Get a Free Quote</a>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-12 max-w-2xl">
            @foreach([
                ['num' => '10+',  'label' => 'Years export experience'],
                ['num' => '6+',   'label' => 'Destination countries served'],
                ['num' => 'B2B',  'label' => 'Professional & mandataire service'],
                ['num' => '100%', 'label' => 'Document handled by BARQAWI'],
            ] as $s)
            <div class="text-center p-4 rounded-xl" style="background:rgba(255,255,255,0.08);">
                <div class="text-xl font-black text-white">{{ $s['num'] }}</div>
                <div class="text-xs text-white/60 mt-1 leading-snug">{{ $s['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Export Cost Guide --}}
<section class="py-14" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Export Pricing Guide</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">
                Car Export from Germany — Cost by Destination
            </h2>
            <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                Indicative costs for a standard passenger vehicle (€20,000–€50,000 range). BARQAWI service fee (€890–€1,490) covers sourcing, all documentation and coordination. Transport costs below are additional.
            </p>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-sm bg-white">
            <table class="w-full text-sm">
                <thead>
                    <tr style="background:#0D2D6D; color:#fff;">
                        <th class="text-left px-5 py-4 font-bold text-xs">Destination</th>
                        <th class="text-right px-4 py-4 font-bold text-xs whitespace-nowrap">Transport Cost</th>
                        <th class="text-center px-4 py-4 font-bold text-xs whitespace-nowrap">Customs Duties</th>
                        <th class="text-center px-4 py-4 font-bold text-xs whitespace-nowrap">Delivery Time</th>
                        <th class="text-left px-5 py-4 font-bold text-xs">Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach([
                        ['dest'=>'France 🇫🇷',          'transport'=>'€700–€1,100',  'customs'=>'0% (EU)',        'time'=>'3–7 days',    'note'=>'Road transport. ANTS registration support included.'],
                        ['dest'=>'Belgium / Netherlands 🇧🇪🇳🇱','transport'=>'€600–€900',   'customs'=>'0% (EU)',        'time'=>'2–5 days',    'note'=>'Road transport. EU single market — no border formalities.'],
                        ['dest'=>'Switzerland 🇨🇭',       'transport'=>'€700–€1,000',  'customs'=>'7.7% VAT + fees', 'time'=>'5–10 days',   'note'=>'Non-EU. Swiss customs clearance. VAT refund possible for resellers.'],
                        ['dest'=>'Morocco 🇲🇦',           'transport'=>'€1,800–€2,500','customs'=>'2.5–10%',        'time'=>'3–5 weeks',   'note'=>'Road + RoRo sea freight. Euro-Med Agreement rates apply.'],
                        ['dest'=>'Algeria 🇩🇿',           'transport'=>'€2,000–€3,000','customs'=>'5–30% + taxes',  'time'=>'4–6 weeks',   'note'=>'Road + sea freight. Duty varies by vehicle age and engine.'],
                        ['dest'=>'Tunisia 🇹🇳',           'transport'=>'€1,800–€2,500','customs'=>'10–50%',         'time'=>'3–5 weeks',   'note'=>'Road + sea freight. Local customs agent coordination included.'],
                    ] as $r)
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-3.5 font-semibold text-gray-800 text-xs">{{ $r['dest'] }}</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-xs whitespace-nowrap" style="color:#0D2D6D;">{{ $r['transport'] }}</td>
                        <td class="px-4 py-3.5 text-center text-xs whitespace-nowrap">
                            @if($r['customs'] === '0% (EU)')
                                <span class="inline-flex items-center font-black px-2.5 py-1 rounded-lg" style="background:#DCFCE7; color:#166534;">{{ $r['customs'] }}</span>
                            @else
                                <span class="text-gray-600">{{ $r['customs'] }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-center text-gray-600 text-xs whitespace-nowrap">{{ $r['time'] }}</td>
                        <td class="px-5 py-3.5 text-xs text-gray-500">{{ $r['note'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="text-xs text-gray-400 mt-3 text-center">* Customs duties are indicative and subject to change. BARQAWI recommends verifying current rates with local customs authorities. All prices exclude local taxes at destination.</p>
        <div class="text-center mt-6">
            <a href="{{ route('landing.import_germany_france', ['locale' => 'en']) }}"
               class="inline-flex items-center gap-2 text-sm font-semibold px-5 py-2.5 rounded-xl border border-gray-300 bg-white hover:border-gray-400 hover:shadow-sm transition-all text-gray-700">
                See the full France import guide (ANTS, COC, TVA rules) →
            </a>
        </div>
    </div>
</section>

{{-- Destinations --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Destinations</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Where We Export German Cars To</h2>
            <p class="text-gray-500 mt-3 leading-relaxed">BARQAWI Cars adapts documentation and logistics to each destination's specific requirements — whether EU single market or non-EU customs territory.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['country'=>'France',         'flag'=>'🇫🇷', 'desc'=>'Our primary export market. No customs duties, straightforward registration via ANTS. Delivery 3–7 days from Germany. Complete COC and Abmeldung pack included.'],
                ['country'=>'Morocco',        'flag'=>'🇲🇦', 'desc'=>'Full export pack + customs declaration + sea freight coordination from Algeciras or Sète. Most popular African destination. Local customs agent network in Casablanca.'],
                ['country'=>'Algeria',        'flag'=>'🇩🇿', 'desc'=>'Complete Algerian customs documentation. Vehicles shipped from French or Spanish Mediterranean ports. Coordination with Algiers and Oran port agents.'],
                ['country'=>'Tunisia',        'flag'=>'🇹🇳', 'desc'=>'Export documentation compliant with Tunisian customs regulations. Sea freight coordination included. Network in Tunis and Sfax.'],
                ['country'=>'Switzerland',    'flag'=>'🇨🇭', 'desc'=>'Non-EU export with Swiss customs clearance support. VAT refund assistance for Swiss professional buyers. Road transport to CH border in 1 day.'],
                ['country'=>'Other Countries','flag'=>'🌍',  'desc'=>'We export worldwide. Contact us with your destination for a tailored logistics and documentation plan, including RoRo sea freight for distant markets.'],
            ] as $c)
            <div class="rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow flex gap-4">
                <span class="text-3xl shrink-0">{{ $c['flag'] }}</span>
                <div>
                    <h3 class="font-bold text-sm mb-1.5" style="color:#0D2D6D;">{{ $c['country'] }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $c['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- B2B Professional Section --}}
<section class="py-14" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Professional &amp; B2B</p>
                <h2 class="text-2xl sm:text-3xl font-black mb-5" style="color:#0D2D6D;">
                    Export Services for Mandataires &amp; Professional Resellers
                </h2>
                <p class="text-gray-500 leading-relaxed mb-6">
                    BARQAWI Cars works with mandataires, professional car dealers and importers who purchase multiple vehicles per month from Germany. Our B2B service provides volume sourcing, batch documentation and preferential logistics rates — structured for repeat professional buyers.
                </p>
                <ul class="space-y-4">
                    @foreach([
                        ['Volume Sourcing',          'We source 1–20 vehicles per month to your specification. Access to dealer auctions, fleet disposals and manufacturer surplus stocks not available to private buyers.'],
                        ['EU VAT Structuring',        'VAT-registered EU professionals can purchase vehicles in Germany with zero German VAT under intra-EU export rules (§ 6a UStG). BARQAWI structures transactions accordingly.'],
                        ['Batch Documentation',      'Multiple vehicles, single shipment. We consolidate COC, Abmeldung and invoice packs for batch exports — reducing administrative overhead for high-volume buyers.'],
                        ['Preferential Transport',   'Volume exporters benefit from dedicated transporter slots and reduced per-vehicle road freight costs versus single-vehicle export rates.'],
                        ['Dedicated Account Manager','B2B clients receive a named BARQAWI account manager, priority response and monthly vehicle market reports for their target brands.'],
                    ] as [$title, $text])
                    <li class="flex gap-4">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 mt-0.5" style="background:#0D2D6D;">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <div>
                            <span class="font-bold text-sm" style="color:#0D2D6D;">{{ $title }}</span>
                            <span class="text-gray-500 text-sm"> — {{ $text }}</span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                <h3 class="font-bold text-base mb-5" style="color:#0D2D6D;">Professional Export Package</h3>
                <div class="space-y-3 mb-6">
                    @foreach([
                        'Volume sourcing (1–20 vehicles/month)',
                        'Intra-EU VAT-free purchase structuring',
                        'Batch COC + Abmeldung documentation',
                        'Consolidated road transport',
                        'Customs declarations for non-EU exports',
                        'Dedicated account manager',
                        'Monthly market reports by brand',
                    ] as $feat)
                    <div class="flex items-center gap-3 p-3 rounded-xl" style="background:#F7F8FA;">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center shrink-0" style="background:#0D2D6D;">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span class="text-sm font-medium text-gray-700">{{ $feat }}</span>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('contact', ['locale' => 'en']) }}"
                   class="flex items-center justify-between w-full px-4 py-3.5 rounded-xl text-sm font-bold text-white transition-opacity hover:opacity-90" style="background:#0D2D6D;">
                    Discuss a B2B Partnership
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Services --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Our Services</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Full-Service Car Export from Germany</h2>
            <p class="text-gray-500 mt-3 leading-relaxed">From vehicle selection to delivery, BARQAWI Cars manages every step of the export process so you don't have to.</p>
        </div>
        <div class="grid lg:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <ul class="space-y-4">
                @foreach([
                    ['Vehicle Sourcing',          'We find vehicles matching your specifications within our network of German dealers, auction houses and private sellers.'],
                    ['History &amp; Condition Check', 'DEKRA/TÜV report, vehicle history (Fahrzeugbrief), previous owners, accident history — all verified before purchase.'],
                    ['Export Documentation',      'COC, invoice, Abmeldung, customs declaration, bill of lading — every document your destination country requires.'],
                    ['Transport &amp; Logistics',     'Road transport for EU destinations, sea freight (RoRo or container) for non-EU. Door-to-door or port delivery.'],
                    ['Post-Delivery Support',     'We remain available after delivery for registration questions, technical issues or warranty claims.'],
                ] as [$title, $text])
                <li class="flex gap-4">
                    <span class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 mt-0.5" style="background:#0D2D6D;">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <div>
                        <span class="font-bold text-sm" style="color:#0D2D6D;">{!! $title !!}</span>
                        <span class="text-gray-500 text-sm"> — {!! $text !!}</span>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-sm mb-4" style="color:#0D2D6D;">Documents We Handle</h3>
                <div class="space-y-3">
                    @foreach([
                        'Certificate of Conformity (COC)',
                        'German Purchase Invoice (Kaufvertrag)',
                        'Title — Zulassungsbescheinigung Teil II',
                        'Deregistration — Abmeldebescheinigung',
                        'Customs Export Declaration (non-EU)',
                        'Bill of Lading / CMR Waybill',
                    ] as $doc)
                    <div class="flex items-center gap-3 p-3 rounded-xl" style="background:#F7F8FA;">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center shrink-0" style="background:#0D2D6D;">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span class="text-sm font-medium text-gray-700">{{ $doc }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="py-14" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Client Experiences</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">Export Clients — From France to North Africa</h2>
            <p class="text-gray-500 mt-3 text-sm">Private buyers, mandataires and professionals who exported their vehicle from Germany with BARQAWI Cars.</p>
        </div>
        <div class="grid sm:grid-cols-3 gap-5">
            @foreach([
                [
                    'initial' => 'S.B.',
                    'name'    => 'Sofiane B.',
                    'city'    => 'Oran, Algeria',
                    'vehicle' => 'Mercedes E 220d AMG-Line, 2021',
                    'saving'  => 'Full customs handled',
                    'quote'   => 'I was worried about the Algerian customs process — I had tried to import a car before and it was a nightmare. BARQAWI prepared every document correctly from the start. The car arrived at Oran port and cleared customs without issues. Professional service from start to finish.',
                    'date'    => 'January 2026',
                ],
                [
                    'initial' => 'A.K.',
                    'name'    => 'Ahmed K.',
                    'city'    => 'Lyon (69), France — mandataire',
                    'vehicle' => '3–4 vehicles/month (mixed brands)',
                    'saving'  => 'B2B volume partnership',
                    'quote'   => 'I\'ve been working with BARQAWI for 18 months as a professional mandataire. They understand the VAT structuring I need for intra-EU purchases, consolidate the paperwork for batch shipments, and their response time is excellent. The only German exporter I trust for volume.',
                    'date'    => 'March 2026',
                ],
                [
                    'initial' => 'P.S.',
                    'name'    => 'Patricia S.',
                    'city'    => 'Geneva, Switzerland',
                    'vehicle' => 'Audi Q7 55 TFSI quattro, 2022',
                    'saving'  => 'CHF 12,000 saved',
                    'quote'   => 'Buying a German car for Switzerland is complicated by Swiss customs. BARQAWI handled the German side completely and guided me through the Swiss import declaration. The Q7 I got was €15,000 cheaper in Germany than in Switzerland — after all costs, I saved CHF 12,000. Excellent.',
                    'date'    => 'February 2026',
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
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">How Car Export from Germany Works</h2>
        </div>
        <div class="max-w-3xl mx-auto space-y-4">
            @foreach([
                ['num'=>'01','title'=>'Initial consultation',
                 'text'=>'Contact us with your requirements: destination country, vehicle type, brand preferences, budget. We provide a detailed cost estimate — vehicle, BARQAWI fee, transport, duties — within 24 hours.'],
                ['num'=>'02','title'=>'Vehicle identification &amp; verification',
                 'text'=>'We locate matching vehicles in Germany, perform full history checks (DEKRA/TÜV, Scheckheft, accident history via DAT) and present verified options at transparent prices.'],
                ['num'=>'03','title'=>'Purchase &amp; collection',
                 'text'=>'Once agreed, we purchase the vehicle, collect original documents from the seller (Fahrzeugbrief, COC, service book) and register the deregistration (Abmeldung) at the German KBA.'],
                ['num'=>'04','title'=>'Export documentation',
                 'text'=>'We prepare all paperwork for your destination: EU exports (COC, Abmeldung, invoice) or non-EU exports (customs declaration, CMR waybill, bill of lading). All documents verified for completeness.'],
                ['num'=>'05','title'=>'Transport coordination',
                 'text'=>'EU destinations: enclosed road transport, 2–7 days. Non-EU: road pre-carriage to port + RoRo sea freight booking from Algeciras, Sète or Marseille, typically 10–21 sailing days.'],
                ['num'=>'06','title'=>'Delivery &amp; handover',
                 'text'=>'Vehicle delivered to your door or port of arrival. Full document pack handed over. We remain available for registration support, warranty questions and any post-delivery issues.'],
            ] as $s)
            <div class="flex gap-5 p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                <span class="text-3xl font-black shrink-0 leading-none mt-0.5" style="color:#EEF2FF; -webkit-text-stroke:2px #0D2D6D;">{{ $s['num'] }}</span>
                <div>
                    <h3 class="font-bold text-sm mb-1" style="color:#0D2D6D;">{!! $s['title'] !!}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">{!! $s['text'] !!}</p>
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
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">
                Frequently Asked Questions — Car Export Germany
            </h2>
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
                ['url' => route('landing.used_cars_germany',     ['locale'=>'en']), 'label' => 'Used Cars Germany'],
                ['url' => route('landing.bmw_germany',           ['locale'=>'en']), 'label' => 'BMW Germany'],
                ['url' => route('landing.audi_germany',          ['locale'=>'en']), 'label' => 'Audi Germany'],
                ['url' => route('landing.mercedes_germany',      ['locale'=>'en']), 'label' => 'Mercedes Germany'],
                ['url' => route('vehicles.index',                ['locale'=>'en']), 'label' => 'All Vehicles'],
                ['url' => route('export',                        ['locale'=>'en']), 'label' => 'Export Service'],
                ['url' => route('about',                         ['locale'=>'en']), 'label' => 'About BARQAWI'],
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
        <h2 class="text-2xl sm:text-3xl font-black text-white mb-4">
            Export Your Car from Germany — Get a Free Quote
        </h2>
        <p class="text-white/70 max-w-xl mx-auto mb-8 leading-relaxed">
            Contact BARQAWI Cars in Fellbach. Private buyers and professionals welcome. We respond within 24 hours with a detailed export cost estimate for your vehicle and destination.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact', ['locale' => 'en']) }}"
               class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:opacity-90 transition-all"
               style="background:#E30613; color:#fff;">Request a Quote</a>
            <a href="{{ route('vehicles.index', ['locale' => 'en']) }}"
               class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:bg-white/10 transition-all"
               style="border:2px solid rgba(255,255,255,0.4); color:#fff;">Browse Vehicles</a>
            <a href="https://wa.me/491726994705?text={{ rawurlencode('Hello, I would like a quote for car export from Germany.') }}"
               target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl hover:opacity-90 transition-colors"
               style="background:#25D366; color:#fff;">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.524 5.847L.057 23.882l6.19-1.624A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.845 0-3.574-.5-5.063-1.37l-.363-.214-3.755.985.999-3.648-.236-.376A9.94 9.94 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection
