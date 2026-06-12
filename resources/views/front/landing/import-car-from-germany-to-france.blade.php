@extends('layouts.app')
@section('title',       'Import Car from Germany to France | BARQAWI Cars')
@section('description', 'Import your car from Germany to France with BARQAWI Cars. Zero customs duties, COC accepted for French ANTS registration. Saving of 10–25% versus French market, all-in.')
@section('keywords',    'import car germany france, importer voiture allemagne france, carte grise voiture allemagne, COC germany france, ANTS import voiture, TVA import voiture allemagne')

@push('structured_data')
@php
$breadcrumbLd = [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',
         'item'  => route('home', ['locale' => 'en'])],
        ['@type' => 'ListItem', 'position' => 2,
         'name'  => 'Import Car from Germany to France',
         'item'  => url()->current()],
    ],
];
$faqItems = [
    ['q' => 'How long does it take to import a car from Germany to France?',
     'a' => 'The full process takes 2 to 4 weeks on average: 3–5 days to source and verify the vehicle in Germany, 3–5 days for export documentation (COC, invoice, Abmeldung), 3–5 days road transport, and 5–10 days for French ANTS registration. BARQAWI Cars coordinates every step and provides a delivery timeline before you commit.'],
    ['q' => 'Do I pay customs duties when importing a car from Germany to France?',
     'a' => 'No. Germany and France are both EU member states. There are zero customs duties on vehicles purchased in Germany and imported to France. The vehicle circulates freely within the EU single market. There is no import declaration required at the French border for EU-origin vehicles.'],
    ['q' => 'Do I have to pay VAT when importing a used car from Germany to France?',
     'a' => 'If the vehicle is older than 6 months AND has more than 6,000 km at the time of purchase, it is classified as a used vehicle under EU VAT rules. No additional French VAT (20%) is due in France. For newer or low-mileage vehicles, French TVA applies. VAT-registered businesses may recover input tax under certain conditions.'],
    ['q' => 'What documents are required to register a German car in France (carte grise)?',
     'a' => 'To register a German car in France via the ANTS portal, you need: Certificate of Conformity (COC), original German purchase invoice, Zulassungsbescheinigung Teil II (German title), Abmeldebescheinigung (deregistration proof), valid ID, French insurance certificate, and completed CERFA 13750. BARQAWI Cars provides all German documents; you only handle the French insurance and ANTS submission.'],
    ['q' => 'Is the contrôle technique required after importing from Germany?',
     'a' => 'Yes, if the vehicle is more than 4 years old you will need a valid contrôle technique (CT) to obtain the French carte grise. A German TÜV Hauptuntersuchung is not accepted in France. However, if the TÜV is valid, the vehicle is mechanically inspected and a French CT generally passes without issue. BARQAWI advises on CT timing as part of the delivery process.'],
    ['q' => 'What is the total cost to import a car from Germany to France?',
     'a' => 'Total cost = German vehicle price + BARQAWI export service fee (€890–€1,490 depending on vehicle value) + road transport (€700–€1,100) + French carte grise fee (variable by region and horsepower, typically €200–€900) + contrôle technique (~€80). On a €30,000 vehicle, total additional costs are typically €2,000–€3,000, leaving a net saving of €4,000–€8,000 versus the French market.'],
    ['q' => 'Is it cheaper to buy a car in Germany than in France?',
     'a' => 'Yes, consistently. Premium brands such as BMW, Mercedes-Benz, Audi and Volkswagen are typically 12–25% cheaper in Germany than equivalent French-market vehicles. This saving is amplified on high-trim specifications, M/AMG/RS performance models, and estate variants which are more abundant and less expensive in Germany.'],
    ['q' => 'Can BARQAWI Cars handle the entire import process for me?',
     'a' => 'Yes. BARQAWI Cars, based in Fellbach near Stuttgart, handles the full process remotely: vehicle sourcing and history verification, German purchase, COC and all export documents, road transport to France, and a complete registration checklist for the ANTS portal. You receive a ready-to-register vehicle at your door without travelling to Germany.'],
];
$faqLd = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(fn($i) => [
        '@type'          => 'Question',
        'name'           => $i['q'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $i['a']],
    ], $faqItems),
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
        <span class="text-gray-600 font-medium">Import Car from Germany to France</span>
    </div>
</div>

{{-- Hero --}}
<section style="background:linear-gradient(135deg,#0D2D6D 0%,#1a4a9e 100%);" class="text-white py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="inline-block text-xs font-black uppercase tracking-widest mb-4 px-3 py-1.5 rounded-full" style="background:rgba(227,6,19,0.9);">
                Vehicle Import Specialist · Fellbach (Stuttgart), Germany
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight mb-5">
                Import Car from<br>Germany to France
            </h1>
            <p class="text-white/80 text-lg leading-relaxed mb-8 max-w-2xl">
                BARQAWI Cars guides you through every step of importing a vehicle from Germany to France — sourcing, COC, Abmeldung, transport and ANTS registration support. Zero customs duties. Net saving of 10–25% versus French market, all-in.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('vehicles.index', ['locale' => 'en']) }}"
                   class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:opacity-90 hover:shadow-lg"
                   style="background:#E30613; color:#fff;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h6l2-1zM15 6h2l3 10-2 1h-3V6z"/></svg>
                    View Available Vehicles
                </a>
                <a href="{{ route('contact', ['locale' => 'en']) }}"
                   class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:bg-white/10"
                   style="border:2px solid rgba(255,255,255,0.4); color:#fff;">
                    Get a Free Quote
                </a>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-12 max-w-2xl">
            @foreach([
                ['num' => '0%',    'label' => 'Customs duties Germany → France'],
                ['num' => '2–3w',  'label' => 'Average delivery time to France'],
                ['num' => '10–25%','label' => 'Saving vs French market (all-in)'],
                ['num' => '10+',   'label' => 'Years of export experience'],
            ] as $stat)
            <div class="text-center p-4 rounded-xl" style="background:rgba(255,255,255,0.08);">
                <div class="text-xl font-black text-white">{{ $stat['num'] }}</div>
                <div class="text-xs text-white/60 mt-1 leading-snug">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Why Import from Germany to France (France-specific) --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">France-Specific Advantages</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">
                Why Importing from Germany to France Makes Sense
            </h2>
            <p class="text-gray-500 mt-3 leading-relaxed">
                France and Germany share the EU single market. The administrative and financial conditions for a French buyer are exceptionally favourable.
            </p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['title' => 'Zero Customs Duties',
                 'text'  => 'Germany and France are both EU member states. There are no customs duties, no import declaration and no border formalities on vehicles bought in Germany and driven or transported to France.'],
                ['title' => 'COC Accepted Directly for Carte Grise',
                 'text'  => 'The Certificate of Conformity (COC) issued by the German manufacturer is accepted directly by the French ANTS portal. No additional type approval or homologation procedure is required for EU-spec vehicles.'],
                ['title' => 'No TVA on Used Vehicles (EU Rule)',
                 'text'  => 'If the vehicle is over 6 months old AND has more than 6,000 km, French TVA (20%) is not applicable. This rule uniquely benefits French private buyers purchasing used cars from Germany.'],
                ['title' => 'ANTS Digital Registration',
                 'text'  => 'French carte grise applications are submitted entirely online via ants.gouv.fr. No visit to the prefecture is needed. BARQAWI provides the complete document checklist; most applications are approved within 5–10 working days.'],
                ['title' => 'Contrôle Technique Straightforward',
                 'text'  => 'A German TÜV is not accepted in France, but a French CT is required to complete registration if the vehicle is over 4 years old. German vehicles generally pass the CT without difficulty given the rigorous German pre-sale inspection standard.'],
                ['title' => 'Net Saving After All Costs',
                 'text'  => 'Even after BARQAWI\'s service fee, transport (€700–€1,100) and French registration costs (carte grise + CT), the all-in price remains 10–20% below equivalent French-market vehicles. See the comparison table below.'],
            ] as $card)
            <div class="rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="font-bold text-sm mb-2" style="color:#0D2D6D;">{{ $card['title'] }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed">{{ $card['text'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Price Comparison Table --}}
<section class="py-14" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Real Prices</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">
                Germany vs France — Total Cost Comparison
            </h2>
            <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                Indicative prices based on typical market observations (Q2 2026). All-in price includes German vehicle + BARQAWI fee + transport + French carte grise + contrôle technique.
            </p>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-sm bg-white">
            <table class="w-full text-sm">
                <thead>
                    <tr style="background:#0D2D6D; color:#fff;">
                        <th class="text-left px-5 py-4 font-bold text-xs">Vehicle</th>
                        <th class="text-right px-4 py-4 font-bold text-xs whitespace-nowrap">Germany (DE)</th>
                        <th class="text-right px-4 py-4 font-bold text-xs whitespace-nowrap">All-in France</th>
                        <th class="text-right px-4 py-4 font-bold text-xs whitespace-nowrap">French Market</th>
                        <th class="text-right px-5 py-4 font-bold text-xs whitespace-nowrap">Net Saving</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach([
                        ['model'=>'BMW 320d xDrive Touring (2022)','de'=>'27 500','allin'=>'30 200','fr'=>'36 500','save'=>'6 300','pct'=>'17%'],
                        ['model'=>'Mercedes E 220d Estate AMG-Line (2022)','de'=>'38 500','allin'=>'41 800','fr'=>'51 900','save'=>'10 100','pct'=>'19%'],
                        ['model'=>'Audi Q5 40 TDI quattro S-Line (2022)','de'=>'36 000','allin'=>'38 800','fr'=>'46 500','save'=>'7 700','pct'=>'17%'],
                        ['model'=>'BMW X5 xDrive40d M Sport (2021)','de'=>'53 000','allin'=>'56 500','fr'=>'70 000','save'=>'13 500','pct'=>'19%'],
                        ['model'=>'Volkswagen Tiguan 2.0 TDI DSG (2021)','de'=>'22 000','allin'=>'24 300','fr'=>'29 000','save'=>'4 700','pct'=>'16%'],
                    ] as $r)
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-3.5 font-medium text-gray-800 text-xs">{{ $r['model'] }}</td>
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
        <p class="text-xs text-gray-400 mt-3 text-center">* All-in price = German vehicle + BARQAWI service (€890–€1,490) + transport (€700–€1,100) + carte grise + contrôle technique. Indicative — varies by region and vehicle.</p>
    </div>
</section>

{{-- How BARQAWI Helps --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Our Services</p>
                <h2 class="text-2xl sm:text-3xl font-black mb-5" style="color:#0D2D6D;">
                    How BARQAWI Cars Handles Your Import to France
                </h2>
                <p class="text-gray-500 leading-relaxed mb-6">
                    Based in Fellbach (10 minutes from Stuttgart), BARQAWI Cars has specialised in vehicle export to France since 2012. We handle every administrative and logistical step so your German vehicle arrives at your door ready to register.
                </p>
                <ul class="space-y-4">
                    @foreach([
                        ['Vehicle sourcing',          'We identify vehicles matching your specifications within our network of German dealers and private sellers. TÜV validity verified.'],
                        ['Export documentation',      'We prepare all required documents: COC from manufacturer, Kaufvertrag (invoice), Abmeldebescheinigung (deregistration) — everything the ANTS portal requires.'],
                        ['Transport to France',       'Door-to-door road transport on an enclosed car transporter. Delivery 3–5 days after collection from Germany.'],
                        ['ANTS registration support', 'We provide a complete ANTS document checklist with step-by-step instructions. Most French clients obtain their carte grise within 5–10 working days.'],
                        ['Full import support',       'From first contact to delivery, we are available by phone, email and WhatsApp to answer questions and resolve any administrative issues.'],
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
                <h3 class="font-bold text-base mb-5" style="color:#0D2D6D;">Quick Request</h3>
                <p class="text-sm text-gray-500 mb-5">Tell us what you are looking for and we will respond within 24 hours with available options and a price estimate.</p>
                <div class="space-y-3">
                    <a href="{{ route('vehicles.index', ['locale' => 'en']) }}"
                       class="flex items-center justify-between w-full px-4 py-3.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90" style="background:#0D2D6D;">
                        Browse Available Vehicles
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('export', ['locale' => 'en']) }}"
                       class="flex items-center justify-between w-full px-4 py-3.5 rounded-xl text-sm font-semibold transition-colors" style="border:2px solid #0D2D6D; color:#0D2D6D;">
                        Export Services
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="https://wa.me/491726994705?text={{ rawurlencode('Hello, I would like to import a car from Germany to France.') }}"
                       target="_blank" rel="noopener"
                       class="flex items-center justify-between w-full px-4 py-3.5 rounded-xl text-sm font-semibold text-white transition-colors hover:opacity-90" style="background:#25D366;">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.524 5.847L.057 23.882l6.19-1.624A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.845 0-3.574-.5-5.063-1.37l-.363-.214-3.755.985.999-3.648-.236-.376A9.94 9.94 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                            Chat on WhatsApp
                        </span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Steps --}}
<section class="py-14" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Process</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">
                Steps to Import a Vehicle from Germany to France
            </h2>
        </div>
        <div class="max-w-3xl mx-auto space-y-4">
            @foreach([
                ['num' => '01', 'title' => 'Define your vehicle',
                 'text' => 'Share your requirements — brand, model, engine, budget, mileage — by WhatsApp, email or phone. We respond within 24 hours with matching options from our German network.'],
                ['num' => '02', 'title' => 'Receive a complete offer',
                 'text' => 'We send a detailed offer: German vehicle price, BARQAWI service fee, transport cost and all-in delivered price in France. No hidden charges. Full transparency before you commit.'],
                ['num' => '03', 'title' => 'Confirm and pay deposit',
                 'text' => 'A deposit secures the vehicle. We handle the German purchase contract (Kaufvertrag) and collect all original documents from the seller, including the Fahrzeugbrief.'],
                ['num' => '04', 'title' => 'Export documentation',
                 'text' => 'We obtain the COC from the manufacturer if not already present, prepare the Abmeldebescheinigung (deregistration at German KBA) and compile the complete ANTS document pack for France.'],
                ['num' => '05', 'title' => 'Transport to France',
                 'text' => 'The vehicle is collected on an enclosed car transporter. Road delivery to France typically takes 3–5 days. We provide real-time tracking and confirm delivery date in advance.'],
                ['num' => '06', 'title' => 'French registration (ANTS)',
                 'text' => 'You submit the document pack via ants.gouv.fr. We provide a step-by-step checklist and remain available for any questions. Carte grise is typically issued within 5–10 working days.'],
            ] as $step)
            <div class="flex gap-5 p-5 rounded-2xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition-all">
                <span class="text-3xl font-black shrink-0 leading-none mt-0.5" style="color:#EEF2FF; -webkit-text-stroke:2px #0D2D6D;">{{ $step['num'] }}</span>
                <div>
                    <h3 class="font-bold text-sm mb-1" style="color:#0D2D6D;">{{ $step['title'] }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $step['text'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Required Documents --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Documentation</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">
                Required Documents for French Registration
            </h2>
            <p class="text-gray-500 mt-3 text-sm">BARQAWI Cars prepares all German documents. You handle the French insurance certificate and ANTS online submission.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 max-w-5xl mx-auto">
            @foreach([
                ['doc' => 'Certificate of Conformity (COC)',
                 'who' => 'BARQAWI obtains',
                 'desc' => 'Issued by the manufacturer. Accepted directly by the French ANTS portal. No homologation required for EU-spec vehicles from Germany.'],
                ['doc' => 'German Purchase Invoice (Kaufvertrag)',
                 'who' => 'BARQAWI prepares',
                 'desc' => 'Original invoice from the German seller showing price, VAT status, VIN and both parties\' information. Required by ANTS.'],
                ['doc' => 'Zulassungsbescheinigung Teil II',
                 'who' => 'BARQAWI collects',
                 'desc' => 'The German vehicle title (Fahrzeugbrief). Surrendered to the German KBA upon deregistration. Must be original.'],
                ['doc' => 'Abmeldebescheinigung',
                 'who' => 'BARQAWI handles',
                 'desc' => 'Proof of deregistration from the German KBA. Confirms the vehicle is no longer registered in Germany. Required by ANTS.'],
                ['doc' => 'Valid ID / Passport',
                 'who' => 'You provide',
                 'desc' => 'Required for both the German purchase and the French ANTS registration application (identity verification).'],
                ['doc' => 'French Insurance Certificate',
                 'who' => 'You provide',
                 'desc' => 'Your French insurer issues a provisional certificate valid during the registration period. Most insurers issue this same day.'],
            ] as $doc)
            <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
                <div class="flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center shrink-0 mt-0.5" style="background:#0D2D6D;">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <div>
                        <div class="font-bold text-sm mb-0.5" style="color:#0D2D6D;">{{ $doc['doc'] }}</div>
                        <div class="text-[10px] font-black uppercase tracking-wider mb-1.5" style="color:#E30613;">{{ $doc['who'] }}</div>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $doc['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="py-14" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">Client Experiences</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">What Our Clients Say</h2>
            <p class="text-gray-500 mt-3 text-sm">French clients who imported their vehicle from Germany through BARQAWI Cars.</p>
        </div>
        <div class="grid sm:grid-cols-3 gap-5">
            @foreach([
                [
                    'initial' => 'K.B.',
                    'name'    => 'Karim B.',
                    'city'    => 'Paris (75019)',
                    'vehicle' => 'BMW 520d Touring M Sport, 2021',
                    'saving'  => '€8,200 saved',
                    'quote'   => 'The ANTS registration was much simpler than I expected — the document pack from BARQAWI was complete and correct. Carte grise obtained in 8 days. Total from first WhatsApp to delivery at my door: 19 days. I\'d do it again without hesitation.',
                    'date'    => 'March 2026',
                ],
                [
                    'initial' => 'S.M.',
                    'name'    => 'Sophie M.',
                    'city'    => 'Bordeaux (33)',
                    'vehicle' => 'Audi Q5 40 TDI quattro, 2022',
                    'saving'  => '€7,500 saved',
                    'quote'   => 'I was worried about buying a car abroad for the first time. BARQAWI explained every step and handled all the German paperwork. The COC was already in the car on delivery. No issues at all with registration. Professional and reassuring.',
                    'date'    => 'January 2026',
                ],
                [
                    'initial' => 'N.A.',
                    'name'    => 'Nordine A.',
                    'city'    => 'Marseille (13)',
                    'vehicle' => 'Mercedes E 220d Estate AMG-Line, 2022',
                    'saving'  => '€11,400 saved',
                    'quote'   => 'BARQAWI found the exact spec I wanted in 3 days — AMG-Line Estate with panoramic and head-up display, which was impossible to find in France at that price. Delivered in Marseille in perfect condition. Highly recommended.',
                    'date'    => 'April 2026',
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
                    <span class="ml-auto text-xs font-black px-2.5 py-1 rounded-lg shrink-0" style="background:#DCFCE7; color:#166534;">{{ $t['saving'] }}</span>
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

{{-- FAQ --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#E30613;">FAQ</p>
            <h2 class="text-2xl sm:text-3xl font-black" style="color:#0D2D6D;">
                Frequently Asked Questions — Import Germany to France
            </h2>
        </div>
        <div class="max-w-3xl mx-auto space-y-3">
            @foreach($faqItems as $faq)
            <div class="border border-gray-100 rounded-2xl overflow-hidden" x-data="{ open: false }">
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

{{-- Related Pages Cluster --}}
<section class="py-10 border-t border-gray-100" style="background:#F7F8FA;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-black uppercase tracking-widest mb-4 text-gray-400">Related Services</p>
        <div class="flex flex-wrap gap-3">
            @foreach([
                ['url' => route('landing.used_cars_germany',  ['locale'=>'en']), 'label' => 'Used Cars Germany'],
                ['url' => route('landing.car_export_germany', ['locale'=>'en']), 'label' => 'Car Export Germany'],
                ['url' => route('landing.bmw_germany',        ['locale'=>'en']), 'label' => 'BMW Germany'],
                ['url' => route('landing.audi_germany',       ['locale'=>'en']), 'label' => 'Audi Germany'],
                ['url' => route('landing.mercedes_germany',   ['locale'=>'en']), 'label' => 'Mercedes Germany'],
                ['url' => route('vehicles.index',             ['locale'=>'en']), 'label' => 'Vehicle Catalogue'],
                ['url' => route('export',                     ['locale'=>'en']), 'label' => 'Export Services'],
                ['url' => route('about',                      ['locale'=>'en']), 'label' => 'About BARQAWI'],
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
            Ready to Import Your Car from Germany to France?
        </h2>
        <p class="text-white/70 max-w-xl mx-auto mb-8 leading-relaxed">
            Contact BARQAWI Cars in Fellbach. We respond within 24 hours with a personalised quote and delivery timeline.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('vehicles.index', ['locale' => 'en']) }}"
               class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:opacity-90"
               style="background:#E30613; color:#fff;">View Available Vehicles</a>
            <a href="{{ route('contact', ['locale' => 'en']) }}"
               class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:bg-white/10"
               style="border:2px solid rgba(255,255,255,0.4); color:#fff;">Send a Request</a>
            <a href="https://wa.me/491726994705?text={{ rawurlencode('Hello, I would like to import a car from Germany to France.') }}"
               target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 text-sm font-bold px-6 py-3.5 rounded-xl transition-colors hover:opacity-90"
               style="background:#25D366; color:#fff;">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.524 5.847L.057 23.882l6.19-1.624A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.845 0-3.574-.5-5.063-1.37l-.363-.214-3.755.985.999-3.648-.236-.376A9.94 9.94 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                WhatsApp
            </a>
        </div>
    </div>
</section>

@endsection
