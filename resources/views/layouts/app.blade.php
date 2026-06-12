<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $loc = $locale ?? app()->getLocale();

        // Canonical : URL propre + filtres SEO significatifs (brand/type/carburant/état/boîte)
        // Exclut : page, sort, prix, kilométrage, année, couleur, TVA — évite les URLs thin-content
        $seoFilters = array_filter(request()->only(['brand', 'vehicle_type', 'fuel_type', 'condition', 'transmission']));
        $pageUrl    = url()->current() . ($seoFilters ? '?' . http_build_query($seoFilters) : '');

        // Query string complet (sans page) — conservé lors du changement de langue
        $filterQueryString = http_build_query(request()->except('page'));

        // Fallback OG image
        $ogDefaultImage = file_exists(public_path('images/og-default.jpg'))
            ? asset('images/og-default.jpg')
            : asset('images/logobarqawinew.png');
    @endphp

    <title>@yield('title', 'BARQAWI Fahrzeughandel')</title>
    <meta name="description" content="@yield('description', __('seo.default_description', [], $loc))">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <meta name="keywords" content="@yield('keywords', 'véhicules occasion, voiture import export, Fellbach, BARQAWI, Gebrauchtwagen, used cars Europe')">
    <link rel="canonical" href="{{ $pageUrl }}">

    {{-- Hreflang multilingue — inclut les filtres SEO du canonical --}}
    @php
        $hreflangQuery = parse_url($pageUrl, PHP_URL_QUERY) ? '?' . parse_url($pageUrl, PHP_URL_QUERY) : '';
    @endphp
    @foreach(['de','fr','en'] as $lang)
        <link rel="alternate" hreflang="{{ $lang }}"
              href="{{ url(preg_replace('#^/(de|fr|en)(/|$)#', '/'.$lang.'$2', parse_url($pageUrl, PHP_URL_PATH))) . $hreflangQuery }}">
    @endforeach
    <link rel="alternate" hreflang="x-default"
          href="{{ url(preg_replace('#^/(de|fr|en)(/|$)#', '/de$2', parse_url($pageUrl, PHP_URL_PATH))) . $hreflangQuery }}">

    {{-- Open Graph --}}
    <meta property="og:type"        content="@yield('og_type', 'website')">
    <meta property="og:title"       content="@yield('title', 'BARQAWI Fahrzeughandel')">
    <meta property="og:description" content="@yield('description', __('seo.default_description', [], $loc))">
    <meta property="og:url"         content="{{ $pageUrl }}">
    <meta property="og:image"       content="@yield('og_image', $ogDefaultImage)">
    <meta property="og:site_name"   content="BARQAWI Fahrzeughandel">
    <meta property="og:locale"      content="{{ ['de'=>'de_DE','fr'=>'fr_FR','en'=>'en_US'][$loc] ?? 'de_DE' }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('title', 'BARQAWI Fahrzeughandel')">
    <meta name="twitter:description" content="@yield('description', __('seo.default_description', [], $loc))">
    <meta name="twitter:image"       content="@yield('og_image', $ogDefaultImage)">

    <meta name="theme-color" content="#0D2D6D">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon-32x32.png') }}">
    {{-- Google Fonts — non-bloquant : preconnect + preload + onload swap --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style"
          href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
          onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    </noscript>
    @stack('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
    // ── AutoDealer JSON-LD dynamique (remplace @verbatim) ─────────────────
    // Converti en tableau PHP pour permettre l'ajout conditionnel de aggregateRating
    $autoDealer = [
        '@context'    => 'https://schema.org',
        '@type'       => 'AutoDealer',
        'name'        => 'BARQAWI Fahrzeughandel',
        'url'         => 'https://barqawi-cars.de',
        'logo'        => 'https://barqawi-cars.de/images/logobarqawinew.webp',
        'image'       => 'https://barqawi-cars.de/images/og-default.jpg',
        'description' => 'Spécialiste en véhicules d\'occasion et neufs à Fellbach, Allemagne. Import et export vers l\'Afrique et le monde entier.',
        'telephone'   => '+4971164589240',
        'email'       => 'info@barqawi-cars.de',
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Salierstr. 44',
            'addressLocality' => 'Fellbach',
            'addressRegion'   => 'BW',
            'postalCode'      => '70736',
            'addressCountry'  => 'DE',
        ],
        'geo' => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => 48.8094,
            'longitude' => 9.2760,
        ],
        'openingHoursSpecification' => [
            ['@type' => 'OpeningHoursSpecification',
             'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday'],
             'opens' => '09:00', 'closes' => '18:00'],
            ['@type' => 'OpeningHoursSpecification',
             'dayOfWeek' => ['Saturday'],
             'opens' => '09:00', 'closes' => '14:00'],
        ],
        'priceRange'         => '€ – €€€',
        'currenciesAccepted' => 'EUR',
        'paymentAccepted'    => 'Cash, Virement bancaire, Carte bancaire',
        'foundingDate'       => '2012',
        'legalName'          => 'BARQAWI Vente et courtage de véhicules',
        'areaServed'         => ['Fellbach', 'Stuttgart', 'Baden-Württemberg', 'Deutschland'],
        'hasMap'             => 'https://www.google.com/maps/place/Salierstr.+44,+70736+Fellbach',
        'sameAs' => [
            'https://www.google.com/maps/place/Salierstr.+44,+70736+Fellbach',
            'https://www.facebook.com/barqawicars',
        ],
    ];

    // AggregateRating : injecté uniquement si des avis publiés existent
    // Mis en cache 1h pour éviter une requête SQL sur chaque page
    $reviewStats = \Illuminate\Support\Facades\Cache::remember('barqawi_review_stats', 3600, function () {
        if (!class_exists(\App\Models\Review::class)) return null;
        $reviews = \App\Models\Review::published()->get();
        $count   = $reviews->count();
        return $count > 0
            ? ['count' => $count, 'avg' => round($reviews->avg('rating'), 1)]
            : null;
    });

    if ($reviewStats) {
        $autoDealer['aggregateRating'] = [
            '@type'       => 'AggregateRating',
            'ratingValue' => $reviewStats['avg'],
            'reviewCount' => $reviewStats['count'],
            'bestRating'  => 5,
            'worstRating' => 1,
        ];
    }
    @endphp
    <script type="application/ld+json">{!! json_encode($autoDealer, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
    @stack('structured_data')

    {{-- Google Analytics 4 — injecté uniquement en production et si l'ID est défini --}}
    @if(!app()->isLocal() && config('services.google_analytics_id'))
    @php $gaId = config('services.google_analytics_id'); @endphp
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $gaId }}');
    </script>
    @endif
</head>
<body class="bg-white text-gray-800 antialiased font-sans">

{{-- ═══════════════════════ HEADER ═══════════════════════ --}}
<header x-data="{ open: false, langOpen: false }" class="sticky top-0 z-50 bg-white shadow-sm" style="border-bottom:2px solid #F0F2F5;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-[76px]">

            {{-- Logo --}}
            @php
            $loc = $locale ?? app()->getLocale();
            $currentLang = $locale ?? app()->getLocale();
            $flagSvgs = [
                'de' => '<path d="M24 9H0V3h24v6z" fill="#191919"/><path d="M24 15H0V9h24v6z" fill="#ED0000"/><path d="M24 21H0v-6h24v6z" fill="#FC0"/><path d="M.5 20.5v-17h23v17H.5z" fill="none" stroke="#000" stroke-opacity="0.098"/>',
                'fr' => '<path fill="#ED2939" d="M16 3h8v18h-8z"/><path fill="#fff" d="M8 3h8v18H8z"/><path fill="#002395" d="M0 3h8v18H0z"/><path d="M.5 20.5v-17h23v17H.5z" fill="none" stroke="#000" stroke-opacity="0.098"/>',
                'en' => '<path fill="#002B7F" d="M0 3h24v18H0z"/><path d="M0 21h3.2L24 5.455V3h-3.2L0 18.544V21z" fill="#fff"/><path d="M24 21h-3L0 6.273V3h2.4L24 18.544V21z" fill="#fff"/><path fill="#fff" d="M9 3h6v18H9z"/><path fill="#fff" d="M0 9h24v6H0z"/><path fill="#CE1126" d="M0 10.499h24v3H0z"/><path fill="#CE1126" d="M10.5 3h3v18h-3zM0 21h1.6L9 15H7.5L0 21zM15 9h1.5L24 3h-1.5L15 9zM24 21v-1.637l-6-4.364h-2.251L24 21zM0 3v1.636L6 9h2.251L0 3z"/><path d="M.5 20.5v-17h23v17H.5z" fill="none" stroke="#000" stroke-opacity="0.1"/>',
            ];
            $langLabels = ['de'=>'DE','fr'=>'FR','en'=>'EN'];
            @endphp

            <a href="{{ route('home', ['locale' => $loc]) }}" class="flex items-center shrink-0">
                <picture>
                    <source srcset="{{ asset('images/logobarqawinew.webp') }}" type="image/webp">
                    <img src="{{ asset('images/logobarqawinew.png') }}"
                         alt="BARQAWI" width="191" height="80"
                         class="h-10 w-auto object-contain">
                </picture>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden lg:flex items-center gap-1">
                @php $navLinks = [
                    ['route'=>'home',          'label'=>__('nav.home')],
                    ['route'=>'vehicles.index','label'=>__('nav.vehicles')],
                    ['route'=>'export',        'label'=>__('nav.export')],
                    ['route'=>'about',         'label'=>__('nav.about')],
                ]; @endphp
                @foreach($navLinks as $link)
                    @php $active = request()->routeIs($link['route']); @endphp
                    <a href="{{ route($link['route'], ['locale' => $loc]) }}"
                       class="px-4 py-2 text-sm rounded-xl transition-all
                              {{ $active
                                 ? 'font-semibold'
                                 : 'font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}"
                       style="{{ $active ? 'color:#0D2D6D; background:#EEF2FF;' : '' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- Right: flags + CTA --}}
            <div class="hidden lg:flex items-center gap-4">

                {{-- Flag language switcher --}}
                <div class="flex items-center gap-0.5 p-1 rounded-xl bg-gray-50 border border-gray-100">
                    @foreach(['de','fr','en'] as $lang)
                        @php $isActive = $currentLang === $lang; @endphp
                        <a href="{{ route(Route::currentRouteName() ?? 'home', array_merge(request()->route()->parameters(), ['locale' => $lang])) . ($filterQueryString ? '?' . $filterQueryString : '') }}"
                           class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-all
                                  {{ $isActive ? 'bg-white shadow-sm' : 'text-gray-400 hover:text-gray-600' }}"
                           style="{{ $isActive ? 'color:#0D2D6D;' : '' }}"
                           title="{{ ['de'=>'Deutsch','fr'=>'Français','en'=>'English'][$lang] }}">
                            <svg width="18" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                 class="rounded-sm shrink-0" style="border:1px solid rgba(0,0,0,0.08); overflow:hidden;">
                                {!! $flagSvgs[$lang] !!}
                            </svg>
                            <span>{{ $langLabels[$lang] }}</span>
                        </a>
                    @endforeach
                </div>

                {{-- Divider --}}
                <div class="w-px h-6 bg-gray-200"></div>

                {{-- CTA --}}
                <a href="{{ route('contact', ['locale' => $loc]) }}"
                   class="flex items-center gap-2 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all hover:shadow-md hover:opacity-95 active:scale-95"
                   style="background:#E30613;">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ __('layout.contact_btn') }}
                </a>
            </div>

            {{-- Burger --}}
            <button @click="open = !open" class="lg:hidden p-2 rounded-lg text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition-colors">
                <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-transition class="lg:hidden border-t border-gray-100 bg-white">
        <div class="px-4 py-4 space-y-1">
            @foreach($navLinks as $link)
                <a href="{{ route($link['route'], ['locale' => $loc]) }}"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors
                          {{ request()->routeIs($link['route']) ? 'bg-gray-50 font-semibold' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   style="{{ request()->routeIs($link['route']) ? 'color:#0D2D6D;' : '' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach

            {{-- Mobile flags --}}
            <div class="pt-3 border-t border-gray-100 flex items-center gap-2">
                @foreach(['de','fr','en'] as $lang)
                    @php $isActive = $currentLang === $lang; @endphp
                    <a href="{{ route(Route::currentRouteName() ?? 'home', array_merge(request()->route()->parameters(), ['locale' => $lang])) . ($filterQueryString ? '?' . $filterQueryString : '') }}"
                       class="flex items-center gap-2 flex-1 justify-center px-3 py-2.5 rounded-xl border text-sm font-medium transition-all
                              {{ $isActive ? 'border-gray-300 bg-gray-50' : 'border-gray-100 text-gray-400 hover:border-gray-200 hover:text-gray-600' }}"
                       style="{{ $isActive ? 'color:#0D2D6D;' : '' }}">
                        <svg width="20" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                             class="rounded-sm shrink-0" style="border:1px solid rgba(0,0,0,0.08);">
                            {!! $flagSvgs[$lang] !!}
                        </svg>
                        {{ $langLabels[$lang] }}
                    </a>
                @endforeach
            </div>

            <a href="{{ route('contact', ['locale' => $loc]) }}"
               class="mt-2 flex items-center justify-center gap-2 text-white text-sm font-semibold px-5 py-3 rounded-xl"
               style="background:#E30613;">
                {{ __('layout.contact_btn') }}
            </a>
        </div>
    </div>
</header>

<main>@yield('content')</main>

{{-- ═══════════════════════ FOOTER ═══════════════════════ --}}
<footer style="background:#0D2D6D;" class="text-white/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-10">

            <div>
                <picture>
                    <source srcset="{{ asset('images/logobarqawinew.webp') }}" type="image/webp">
                    <img src="{{ asset('images/logobarqawinew.png') }}"
                         alt="BARQAWI" width="191" height="80"
                         class="h-8 w-auto object-contain brightness-0 invert opacity-80 mb-4">
                </picture>
                <p class="text-sm leading-relaxed">{{ __('footer.tagline') }}</p>
            </div>

            <div>
                <h4 class="text-white font-semibold text-sm mb-5">{{ __('footer.navigation') }}</h4>
                @php $loc = $locale ?? app()->getLocale(); @endphp
                <ul class="space-y-2.5 text-sm">
                    @foreach([
                        ['route'=>'home','label'=>__('nav.home')],
                        ['route'=>'vehicles.index','label'=>__('nav.vehicles')],
                        ['route'=>'export','label'=>__('nav.export')],
                        ['route'=>'about','label'=>__('nav.about')],
                        ['route'=>'contact','label'=>__('nav.contact')],
                    ] as $l)
                        <li><a href="{{ route($l['route'], ['locale'=>$loc]) }}" class="hover:text-white transition-colors">{{ $l['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold text-sm mb-5">{{ __('footer.contact_info') }}</h4>
                <ul class="space-y-2.5 text-sm">
                    <li>📍 Salierstr. 44, D – 70736 Fellbach, Deutschland</li>
                    <li><a href="tel:+4971164589240" class="hover:text-white transition-colors">0711 – 645 89 240</a></li>
                    <li><a href="tel:+491726994705" class="hover:text-white transition-colors">0172 – 699 47 05</a></li>
                    <li><a href="mailto:info@barqawi-cars.de" class="hover:text-white transition-colors">info@barqawi-cars.de</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold text-sm mb-5">{{ __('footer.legal') }}</h4>
                <ul class="space-y-2.5 text-sm mb-6">
                    <li><a href="{{ route('legal', ['locale' => $loc]) }}" class="hover:text-white transition-colors">{{ __('footer.legal_notice') }}</a></li>
                    <li><a href="{{ route('terms', ['locale' => $loc]) }}" class="hover:text-white transition-colors">{{ __('footer.terms') }}</a></li>
                    <li><a href="{{ route('privacy', ['locale' => $loc]) }}" class="hover:text-white transition-colors">{{ __('footer.privacy') }}</a></li>
                </ul>
                {{-- Footer flag switcher --}}
                <div class="flex gap-2 flex-wrap">
                    @foreach(['de','fr','en'] as $lang)
                        <a href="{{ route(Route::currentRouteName() ?? 'home', array_merge(request()->route()->parameters(), ['locale' => $lang])) . ($filterQueryString ? '?' . $filterQueryString : '') }}"
                           class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg border text-xs font-semibold transition-colors
                                  {{ ($locale ?? app()->getLocale()) === $lang ? 'border-white/30 bg-white/15 text-white' : 'border-white/10 text-white/40 hover:text-white hover:border-white/25' }}">
                            <svg width="16" height="12" viewBox="0 0 24 24" fill="none" class="rounded-sm shrink-0" style="border:1px solid rgba(255,255,255,0.15);">
                                {!! $flagSvgs[$lang] !!}
                            </svg>
                            {{ $langLabels[$lang] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="border-t border-white/10 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-white/30">
            <span>{{ __('footer.rights', ['year' => date('Y')]) }}</span>
            {{-- Social links — cohérents avec sameAs JSON-LD --}}
            <div class="flex items-center gap-2">
                <a href="https://www.facebook.com/barqawicars"
                   target="_blank" rel="noopener noreferrer"
                   aria-label="BARQAWI Cars sur Facebook"
                   class="w-8 h-8 rounded-lg flex items-center justify-center bg-white/8 hover:bg-white/20 text-white/50 hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                <a href="https://www.linkedin.com/company/barqawi-cars"
                   target="_blank" rel="noopener noreferrer"
                   aria-label="BARQAWI Cars sur LinkedIn"
                   class="w-8 h-8 rounded-lg flex items-center justify-center bg-white/8 hover:bg-white/20 text-white/50 hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </a>
                <a href="https://www.google.com/maps/place/Salierstr.+44,+70736+Fellbach"
                   target="_blank" rel="noopener noreferrer"
                   aria-label="BARQAWI Cars sur Google Maps"
                   class="w-8 h-8 rounded-lg flex items-center justify-center bg-white/8 hover:bg-white/20 text-white/50 hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
