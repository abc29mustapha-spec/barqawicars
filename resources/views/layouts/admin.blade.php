<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('admin.dashboard')) — BARQAWI</title>
    <meta name="robots" content="noindex, nofollow">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-100 antialiased font-sans"
      x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

{{-- Mobile overlay --}}
<div x-show="sidebarOpen"
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-black/50 z-20 lg:hidden"
     x-transition:enter="transition-opacity duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="display:none;">
</div>

<div class="flex h-screen overflow-hidden">

{{-- ═══════════ SIDEBAR ═══════════ --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed lg:relative inset-y-0 left-0 z-30 w-64 bg-slate-900 flex flex-col
              transition-transform duration-200 ease-in-out flex-shrink-0">

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-5 h-16 border-b border-white/5 shrink-0">
        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h6l2-1zM15 6h2l3 10-2 1h-3V6z"/>
            </svg>
        </div>
        <div>
            <div class="text-white font-extrabold text-sm tracking-wide">BARQAWI</div>
            <div class="text-white/30 text-[10px] font-semibold uppercase tracking-widest">{{ __('admin.admin_badge') }}</div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto sidebar-scroll">

        @php
        $navLink = fn($route, $label, $icon, $matchPattern = null) =>
            ['route' => $route, 'label' => $label, 'icon' => $icon,
             'active' => request()->routeIs($matchPattern ?? $route)];

        $isAdmin = auth()->user()->isAdmin();
        $links = array_filter([
            $navLink('admin.dashboard',       __('admin.nav_dashboard'), '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'),
            $navLink('admin.vehicules.index', __('admin.nav_vehicles'),  '<path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h6l2-1zM15 6h2l3 10-2 1h-3V6z"/>',  'admin.vehicules.*'),
            $isAdmin ? $navLink('admin.marques.index', __('admin.nav_brands'), '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>',  'admin.marques.*') : null,
            $navLink('admin.leads.index',     __('admin.nav_leads'),     '<path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z"/>',                                                              'admin.leads.*'),
        ]);
        @endphp

        @foreach($links as $link)
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ $link['active'] ? 'bg-blue-600 text-white' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    {!! $link['icon'] !!}
                </svg>
                <span>{{ $link['label'] }}</span>
                @if($link['route'] === 'admin.leads.index')
                    @php $pl = \App\Models\Lead::where('current_status','new')->count(); @endphp
                    @if($pl > 0)
                        <span class="ml-auto bg-blue-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $pl }}</span>
                    @endif
                @endif
            </a>
        @endforeach

        @if(auth()->user()->isAdmin())
            <div class="pt-4 pb-1">
                <div class="text-white/20 text-[10px] font-bold uppercase tracking-widest px-3">{{ __('admin.nav_admin') }}</div>
            </div>

            @php
            $adminLinks = [
                $navLink('admin.utilisateurs.index', __('admin.nav_users'),  '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>', 'admin.utilisateurs.*'),
                $navLink('admin.audit-logs',         __('admin.nav_audit'),  '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>'),
            ];
            @endphp
            @foreach($adminLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                          {{ $link['active'] ? 'bg-blue-600 text-white' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        {!! $link['icon'] !!}
                    </svg>
                    <span>{{ $link['label'] }}</span>
                </a>
            @endforeach
        @endif
    </nav>

    {{-- Language switcher + User + logout --}}
    <div class="px-3 pb-4 shrink-0 border-t border-white/5 pt-3 space-y-2">

        {{-- Lang switcher --}}
        @php
        $flagSvgs = [
            'de' => '<path d="M24 9H0V3h24v6z" fill="#191919"/><path d="M24 15H0V9h24v6z" fill="#ED0000"/><path d="M24 21H0v-6h24v6z" fill="#FC0"/>',
            'fr' => '<path fill="#ED2939" d="M16 3h8v18h-8z"/><path fill="#fff" d="M8 3h8v18H8z"/><path fill="#002395" d="M0 3h8v18H0z"/>',
            'en' => '<path fill="#002B7F" d="M0 3h24v18H0z"/><path d="M0 21h3.2L24 5.455V3h-3.2L0 18.544V21z" fill="#fff"/><path fill="#fff" d="M9 3h6v18H9z"/><path fill="#fff" d="M0 9h24v6H0z"/><path fill="#CE1126" d="M0 10.499h24v3H0z"/><path fill="#CE1126" d="M10.5 3h3v18h-3z"/>',
        ];
        $currentLocale = app()->getLocale();
        @endphp
        <div class="flex items-center gap-1 px-2">
            <span class="text-white/20 text-[10px] font-bold uppercase tracking-widest shrink-0">{{ __('admin.lang_label') }}</span>
            <div class="flex items-center gap-1 ml-auto">
                @foreach(['fr','de','en'] as $lang)
                    <form action="{{ route('admin.lang') }}" method="POST">
                        @csrf
                        <input type="hidden" name="lang" value="{{ $lang }}">
                        <button type="submit"
                                class="w-7 h-5 rounded overflow-hidden transition-all {{ $currentLocale === $lang ? 'ring-2 ring-blue-400 ring-offset-1 ring-offset-slate-900 opacity-100' : 'opacity-40 hover:opacity-70' }}">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                {!! $flagSvgs[$lang] !!}
                            </svg>
                        </button>
                    </form>
                @endforeach
            </div>
        </div>

        {{-- User info --}}
        <div class="flex items-center gap-2.5 px-2 py-2">
            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-[11px] font-extrabold shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="min-w-0">
                <div class="text-white text-xs font-semibold truncate">{{ auth()->user()->name }}</div>
                <div class="text-white/30 text-[10px] uppercase tracking-wide">{{ auth()->user()->role }}</div>
            </div>
        </div>

        {{-- Logout --}}
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/40
                           hover:text-white hover:bg-white/8 transition-colors font-medium">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                {{ __('admin.logout') }}
            </button>
        </form>
    </div>
</aside>

{{-- ═══════════ MAIN ═══════════ --}}
<div class="flex-1 flex flex-col overflow-hidden min-w-0">

    {{-- Topbar --}}
    <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 shrink-0">
        <div class="flex items-center gap-3">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="hidden sm:flex items-center gap-1.5 text-sm">
                <span class="text-gray-400 font-medium">{{ __('admin.admin_badge') }}</span>
                <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="font-semibold text-gray-800">@yield('breadcrumb', __('admin.dashboard'))</span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @php $pendingLeads = \App\Models\Lead::where('current_status','new')->count(); @endphp
            @if($pendingLeads > 0)
                <a href="{{ route('admin.leads.index', ['status'=>'new']) }}"
                   class="hidden sm:flex items-center gap-1.5 bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1.5 rounded-full hover:bg-blue-100 transition-colors">
                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                    {{ $pendingLeads > 1 ? __('admin.pending_new_pl', ['count' => $pendingLeads]) : __('admin.pending_new', ['count' => $pendingLeads]) }}
                </a>
            @endif
            <div class="flex items-center gap-2 pl-3 border-l border-gray-200">
                <div class="w-8 h-8 bg-slate-900 rounded-full flex items-center justify-center text-white text-[11px] font-extrabold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="hidden md:block">
                    <div class="text-xs font-bold text-gray-800">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-gray-400 uppercase tracking-wide">{{ auth()->user()->role }}</div>
                </div>
            </div>
        </div>
    </header>

    {{-- Page --}}
    <main class="flex-1 overflow-y-auto p-5 sm:p-6">

        @if(session('success'))
            <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3 rounded-xl mb-5 alert-anim">
                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3 rounded-xl mb-5 alert-anim">
                <div class="flex items-center gap-2 font-semibold mb-1.5">
                    <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('admin.validation_errors') }}
                </div>
                <ul class="list-disc list-inside space-y-0.5 ml-2">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>

</div>{{-- end flex wrap --}}

@stack('scripts')
</body>
</html>
