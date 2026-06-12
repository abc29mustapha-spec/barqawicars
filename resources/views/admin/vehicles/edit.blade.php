@extends('layouts.admin')
@section('title', __('admin.edit_vehicle_title', ['name' => ($vehicle->brand?->name ?? '').' '.$vehicle->model]))
@section('breadcrumb', __('admin.bc_edit_v'))
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-extrabold text-slate-900">{{ __('admin.edit_vehicle_title', ['name' => ($vehicle->brand?->name ?? '').' '.$vehicle->model]) }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $vehicle->year }} · {{ number_format($vehicle->price,0,',',' ') }} €</p>
    </div>
    <a href="{{ route('admin.vehicules.show',$vehicle) }}" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">{{ __('admin.btn_back_to_v') }}</a>
</div>

<form action="{{ route('admin.vehicules.update',$vehicle) }}" method="POST">
    @csrf @method('PUT')
    @include('admin.vehicles._form')
    <div class="flex items-center gap-3">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-colors">
            {{ __('admin.btn_save_v') }}
        </button>
        <a href="{{ route('admin.vehicules.show',$vehicle) }}" class="text-sm text-gray-400 hover:text-gray-600">{{ __('admin.btn_cancel') }}</a>
    </div>
</form>

@endsection
