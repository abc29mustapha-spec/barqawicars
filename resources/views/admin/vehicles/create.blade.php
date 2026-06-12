@extends('layouts.admin')
@section('title', __('admin.add_vehicle_title'))
@section('breadcrumb', __('admin.bc_new_v'))
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-extrabold text-slate-900">{{ __('admin.add_vehicle_title') }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ __('admin.add_vehicle_sub') }}</p>
    </div>
    <a href="{{ route('admin.vehicules.index') }}" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">{{ __('admin.btn_back') }}</a>
</div>

<form action="{{ route('admin.vehicules.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.vehicles._form')

    <div class="flex items-center gap-3">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-colors">
            {{ __('admin.btn_create_v') }}
        </button>
        <a href="{{ route('admin.vehicules.index') }}" class="text-sm text-gray-400 hover:text-gray-600">{{ __('admin.btn_cancel') }}</a>
    </div>
</form>

@endsection
