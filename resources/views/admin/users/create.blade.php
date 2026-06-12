@extends('layouts.admin')
@section('title', __('admin.new_user_title'))
@section('breadcrumb', __('admin.bc_new_user'))
@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-extrabold text-slate-900">{{ __('admin.new_user_title') }}</h1>
    <a href="{{ route('admin.utilisateurs.index') }}" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">{{ __('admin.btn_back') }}</a>
</div>

<div class="max-w-lg">
    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <form action="{{ route('admin.utilisateurs.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('admin.label_fullname') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors {{ $errors->has('name') ? 'border-red-400' : '' }}">
                @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('admin.label_email_f') }}</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors {{ $errors->has('email') ? 'border-red-400' : '' }}">
                @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('admin.label_role') }}</label>
                <select name="role" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 transition-colors">
                    <option value="commercial" {{ old('role') === 'commercial' ? 'selected' : '' }}>{{ __('admin.role_commercial') }}</option>
                    <option value="admin"      {{ old('role') === 'admin'      ? 'selected' : '' }}>{{ __('admin.role_admin') }}</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('admin.label_password_f') }}</label>
                <input type="password" name="password" required minlength="8"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('admin.label_confirm_pw') }}</label>
                <input type="password" name="password_confirmation" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors">
            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">
                    {{ __('admin.btn_create_user') }}
                </button>
                <a href="{{ route('admin.utilisateurs.index') }}" class="text-sm text-gray-400 hover:text-gray-600">{{ __('admin.btn_cancel') }}</a>
            </div>
        </form>
    </div>
</div>

@endsection
