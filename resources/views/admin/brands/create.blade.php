@extends('layouts.admin')
@section('title', __('admin.new_brand_title'))
@section('breadcrumb', __('admin.bc_new_brand'))
@section('content')

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <h1 class="text-xl font-extrabold text-slate-900">{{ __('admin.new_brand_title') }}</h1>
    <a href="{{ route('admin.marques.index') }}"
       class="inline-flex items-center bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
        {{ __('admin.btn_back') }}
    </a>
</div>

<div class="max-w-lg">
    <form action="{{ route('admin.marques.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white border border-gray-200 rounded-xl p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('admin.label_brand_name') }}</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                   placeholder="{{ __('admin.ph_brand_name') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors {{ $errors->has('name') ? 'border-red-400' : '' }}">
            @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('admin.label_logo') }}</label>
            <input type="file" name="logo" accept="image/jpeg,image/png,image/webp,image/svg+xml"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-600
                          file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold
                          file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 outline-none focus:border-blue-500">
            <p class="text-xs text-gray-400 mt-1">{{ __('admin.logo_hint') }}</p>
            @error('logo')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                {{ __('admin.btn_create_brand') }}
            </button>
            <a href="{{ route('admin.marques.index') }}"
               class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                {{ __('admin.btn_cancel') }}
            </a>
        </div>
    </form>
</div>

@endsection
