<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('admin.login_heading') }} — BARQAWI Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 flex antialiased font-sans">

@php
$flagSvgs = [
    'de' => '<path d="M24 9H0V3h24v6z" fill="#191919"/><path d="M24 15H0V9h24v6z" fill="#ED0000"/><path d="M24 21H0v-6h24v6z" fill="#FC0"/>',
    'fr' => '<path fill="#ED2939" d="M16 3h8v18h-8z"/><path fill="#fff" d="M8 3h8v18H8z"/><path fill="#002395" d="M0 3h8v18H0z"/>',
    'en' => '<path fill="#002B7F" d="M0 3h24v18H0z"/><path d="M0 21h3.2L24 5.455V3h-3.2L0 18.544V21z" fill="#fff"/><path fill="#fff" d="M9 3h6v18H9z"/><path fill="#fff" d="M0 9h24v6H0z"/><path fill="#CE1126" d="M0 10.499h24v3H0z"/><path fill="#CE1126" d="M10.5 3h3v18h-3z"/>',
];
$currentLocale = app()->getLocale();
@endphp

{{-- Left decorative panel --}}
<div class="hidden lg:flex lg:w-96 xl:w-[440px] bg-slate-900 flex-col justify-between p-10 shrink-0 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20"
         style="background:radial-gradient(circle at 30% 70%, #2563eb 0%, transparent 60%)"></div>

    {{-- Brand --}}
    <div class="relative flex items-center gap-3">
        <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h6l2-1zM15 6h2l3 10-2 1h-3V6z"/>
            </svg>
        </div>
        <div>
            <div class="text-white font-extrabold tracking-wide">BARQAWI</div>
            <div class="text-white/30 text-[10px] uppercase tracking-widest font-semibold">{{ __('admin.login_panel_label') }}</div>
        </div>
    </div>

    {{-- Hero --}}
    <div class="relative">
        <h1 class="text-3xl font-extrabold text-white leading-tight mb-4">
            <span class="text-blue-400">{{ __('admin.login_tagline') }}</span>
        </h1>
        <p class="text-white/50 text-sm leading-relaxed mb-8">
            {{ __('admin.login_desc') }}
        </p>
        <div class="space-y-3">
            @foreach([__('admin.login_feat_1'), __('admin.login_feat_2'), __('admin.login_feat_3'), __('admin.login_feat_4')] as $f)
                <div class="flex items-center gap-3 text-sm text-white/60">
                    <div class="w-5 h-5 bg-blue-600/30 border border-blue-500/40 rounded flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 text-blue-400" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    {{ $f }}
                </div>
            @endforeach
        </div>
    </div>

    <p class="relative text-white/20 text-xs">{{ __('admin.login_copyright', ['year' => date('Y')]) }}</p>
</div>

{{-- Right form panel --}}
<div class="flex-1 flex items-center justify-center p-6 min-h-screen">
    <div class="w-full max-w-sm">

        {{-- Language switcher --}}
        <div class="flex items-center justify-center gap-2 mb-6">
            @foreach(['fr','de','en'] as $lang)
                <form action="{{ route('admin.lang') }}" method="POST">
                    @csrf
                    <input type="hidden" name="lang" value="{{ $lang }}">
                    <button type="submit"
                            class="w-8 h-6 rounded overflow-hidden transition-all {{ $currentLocale === $lang ? 'ring-2 ring-blue-500 ring-offset-1 opacity-100' : 'opacity-35 hover:opacity-60' }}">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            {!! $flagSvgs[$lang] !!}
                        </svg>
                    </button>
                </form>
            @endforeach
        </div>

        {{-- Mobile brand --}}
        <div class="lg:hidden flex items-center gap-3 mb-8 justify-center">
            <div class="w-9 h-9 bg-slate-900 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h6l2-1zM15 6h2l3 10-2 1h-3V6z"/>
                </svg>
            </div>
            <span class="font-extrabold text-slate-900 text-lg">BARQAWI</span>
        </div>

        <div class="mb-8">
            <h2 class="text-2xl font-extrabold text-slate-900 mb-1">{{ __('admin.login_heading') }}</h2>
            <p class="text-sm text-gray-500">{{ __('admin.login_subtitle') }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-6 alert-anim">
                    @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('admin.label_email') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="admin@barqawi.ch"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('admin.label_password') }}</label>
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                           class="w-4 h-4 rounded accent-blue-600 cursor-pointer">
                    <label for="remember" class="text-sm text-gray-600 cursor-pointer select-none">{{ __('admin.remember_me') }}</label>
                </div>
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl text-sm transition-colors">
                    {{ __('admin.login_btn') }}
                </button>
                <div class="text-center">
                    <a href="{{ route('admin.password.request') }}"
                       class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                        {{ __('admin.forgot_password') }}
                    </a>
                </div>
            </form>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}"
               class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
                {{ __('admin.back_to_site') }}
            </a>
        </div>
    </div>
</div>

</body>
</html>
