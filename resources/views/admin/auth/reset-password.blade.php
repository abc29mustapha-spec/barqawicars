<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('admin.reset_pw_heading') }} — BARQAWI Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 flex antialiased font-sans">

{{-- Panneau décoratif gauche --}}
<div class="hidden lg:flex lg:w-96 xl:w-[440px] bg-slate-900 flex-col justify-between p-10 shrink-0 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20"
         style="background:radial-gradient(circle at 30% 70%, #2563eb 0%, transparent 60%)"></div>

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

    <div class="relative">
        <h1 class="text-3xl font-extrabold text-white leading-tight mb-4">
            <span class="text-blue-400">{{ __('admin.reset_pw_tagline') }}</span>
        </h1>
        <p class="text-white/50 text-sm leading-relaxed">{{ __('admin.reset_pw_desc') }}</p>
    </div>

    <p class="relative text-white/20 text-xs">{{ __('admin.login_copyright', ['year' => date('Y')]) }}</p>
</div>

{{-- Panneau droit — formulaire --}}
<div class="flex-1 flex items-center justify-center p-6 min-h-screen">
    <div class="w-full max-w-sm">

        <div class="mb-8">
            <h2 class="text-2xl font-extrabold text-slate-900 mb-1">{{ __('admin.reset_pw_heading') }}</h2>
            <p class="text-sm text-gray-500">{{ __('admin.reset_pw_subtitle') }}</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-6">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('admin.label_email') }}</label>
                    <input type="email" value="{{ $email }}" disabled
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('admin.label_new_pw_r') }}</label>
                    <input type="password" name="password" required placeholder="••••••••" minlength="8"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('admin.label_confirm_r') }}</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors">
                </div>
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl text-sm transition-colors">
                    {{ __('admin.btn_reset_pw') }}
                </button>
            </form>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('admin.login') }}"
               class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
                {{ __('admin.back_to_login') }}
            </a>
        </div>
    </div>
</div>

</body>
</html>
