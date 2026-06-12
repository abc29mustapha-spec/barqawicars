@extends('layouts.admin')
@section('title', __('admin.edit_user_title', ['name' => $user->name]))
@section('breadcrumb', __('admin.bc_edit_user'))
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-extrabold text-slate-900">{{ __('admin.edit_user_title', ['name' => $user->name]) }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $user->email }}</p>
    </div>
    <a href="{{ route('admin.utilisateurs.index') }}" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">{{ __('admin.btn_back') }}</a>
</div>

<div class="max-w-lg">
    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <form action="{{ route('admin.utilisateurs.update', $user) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('admin.label_fullname') }}</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('admin.label_email_f') }}</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('admin.label_role') }}</label>
                <select name="role" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 transition-colors">
                    <option value="commercial" {{ old('role', $user->role) === 'commercial' ? 'selected' : '' }}>{{ __('admin.role_commercial') }}</option>
                    <option value="admin"      {{ old('role', $user->role) === 'admin'      ? 'selected' : '' }}>{{ __('admin.role_admin') }}</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 rounded accent-blue-600 cursor-pointer">
                <label for="is_active" class="text-sm text-gray-700 cursor-pointer select-none">{{ __('admin.label_active_acc') }}</label>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-400 mb-3">{{ __('admin.keep_password') }}</p>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('admin.label_new_pw') }}</label>
                        <input type="password" name="password" minlength="8"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('admin.label_confirm_new') }}</label>
                        <input type="password" name="password_confirmation"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors">
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">
                    {{ __('admin.btn_save') }}
                </button>
                <a href="{{ route('admin.utilisateurs.index') }}" class="text-sm text-gray-400 hover:text-gray-600">{{ __('admin.btn_cancel') }}</a>
            </div>
        </form>
    </div>
</div>

@endsection
