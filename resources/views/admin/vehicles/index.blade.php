@extends('layouts.admin')
@section('title', __('admin.nav_vehicles'))
@section('breadcrumb', __('admin.nav_vehicles'))
@section('content')

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
        <h1 class="text-xl font-extrabold text-slate-900">{{ __('admin.vehicles') }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ __('admin.vehicles_count', ['count' => $vehicles->total()]) }}</p>
    </div>
    @if(auth()->user()->isAdmin())
    <div class="flex items-center gap-2 flex-wrap">
        <button onclick="document.getElementById('importBox').classList.toggle('hidden')"
                class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            {{ __('admin.btn_import_csv') }}
        </button>
        <a href="{{ route('admin.vehicules.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            {{ __('admin.btn_new_vehicle') }}
        </a>
    </div>
    @endif
</div>

{{-- Import panel (admin only) --}}
@if(auth()->user()->isAdmin())
<div id="importBox" class="hidden bg-white border border-gray-200 rounded-xl p-5 mb-5">
    <div class="flex items-start justify-between mb-4">
        <div>
            <div class="font-bold text-slate-900 text-sm">{{ __('admin.import_csv_title') }}</div>
            <p class="text-xs text-gray-500 mt-0.5">{{ __('admin.import_csv_desc') }}</p>
        </div>
        <a href="{{ route('admin.vehicules.import.template') }}"
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors whitespace-nowrap">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            {{ __('admin.btn_download_tpl') }}
        </a>
    </div>
    <form action="{{ route('admin.vehicules.import') }}" method="POST" enctype="multipart/form-data"
          class="flex gap-3 flex-wrap items-end">
        @csrf
        <div class="flex-1 min-w-52">
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('admin.label_csv_file') }}</label>
            <input type="file" name="import_file" accept=".csv,.txt" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-600 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 outline-none focus:border-blue-500">
        </div>
        <button type="submit"
                class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            {{ __('admin.btn_run_import') }}
        </button>
    </form>
    <div class="mt-4 bg-gray-50 border border-gray-100 rounded-lg p-3 text-xs text-gray-500 leading-relaxed">
        <span class="font-semibold text-gray-700">{{ __('admin.csv_cols_label') }} :</span>
        brand_id, model, vehicle_type, condition, seller_type, year, mileage, price, ancien_prix, fuel_type, status<br>
        <span class="font-semibold text-gray-700">brand_id :</span> ID numérique de la marque (voir liste Marques) &nbsp;|&nbsp;
        <span class="font-semibold text-gray-700">ancien_prix :</span> optionnel — prix barré<br>
        <span class="font-semibold text-gray-700">vehicle_type :</span> berline · break · citadine · suv_pickup · cabriolet_roadster · monospace_minibus · sport_coupe · autre<br>
        <span class="font-semibold text-gray-700">condition :</span> neuf · occasion &nbsp;|&nbsp;
        <span class="font-semibold text-gray-700">status :</span> actif · inactif · vendu &nbsp;|&nbsp;
        <span class="font-semibold text-gray-700">vat_status :</span> recuperable · non_recuperable &nbsp;|&nbsp;
        <span class="font-semibold text-gray-700">Booléens :</span> 1 ou 0
    </div>
</div>
@endif

@if(session('import_errors') && count(session('import_errors')) > 0)
    <div class="bg-amber-50 border border-amber-200 text-amber-800 text-xs px-4 py-3 rounded-xl mb-5">
        <p class="font-semibold mb-1">{{ __('admin.skipped_lines') }}</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach(session('import_errors') as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
@endif

{{-- Filters --}}
<div class="bg-white border border-gray-200 rounded-xl p-4 mb-5">
    <form method="GET" action="{{ route('admin.vehicules.index') }}" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-44">
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">{{ __('admin.btn_filter') }}</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('admin.ph_search_vehicle') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors">
        </div>
        <div class="w-36">
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">{{ __('admin.filter_status_v') }}</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-blue-500 transition-colors">
                <option value="">{{ __('admin.filter_all_v') }}</option>
                <option value="actif"   {{ request('status')==='actif'   ?'selected':'' }}>{{ __('admin.status_actif') }}</option>
                <option value="inactif" {{ request('status')==='inactif' ?'selected':'' }}>{{ __('admin.status_inactif') }}</option>
                <option value="vendu"   {{ request('status')==='vendu'   ?'selected':'' }}>{{ __('admin.status_vendu') }}</option>
            </select>
        </div>
        <div class="w-36">
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">{{ __('admin.filter_condition_v') }}</label>
            <select name="condition" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-blue-500 transition-colors">
                <option value="">{{ __('admin.filter_all_cond') }}</option>
                <option value="neuf"     {{ request('condition')==='neuf'    ?'selected':'' }}>{{ __('admin.cond_neuf') }}</option>
                <option value="occasion" {{ request('condition')==='occasion'?'selected':'' }}>{{ __('admin.cond_occasion') }}</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">{{ __('admin.btn_filter') }}</button>
        @if(request()->hasAny(['search','status','condition']))
            <a href="{{ route('admin.vehicules.index') }}" class="text-sm text-gray-400 hover:text-gray-600 py-2">{{ __('admin.btn_clear') }}</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    @if($vehicles->isEmpty())
        <div class="text-center py-20">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h6l2-1zM15 6h2l3 10-2 1h-3V6z"/>
            </svg>
            <p class="text-gray-400 font-medium text-sm">{{ __('admin.no_vehicle_found') }}</p>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.vehicules.create') }}" class="inline-flex mt-3 text-sm font-semibold text-blue-600 hover:text-blue-700">{{ __('admin.btn_add') }}</a>
            @endif
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px]">
                <thead>
                    <tr class="bg-gray-50 border-b-2 border-gray-200">
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-5 py-3.5">{{ __('admin.col_vehicle_list') }}</th>
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_year_km') }}</th>
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_price') }}</th>
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_status') }}</th>
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_export') }}</th>
                        <th class="text-right text-[11px] font-bold uppercase tracking-wider text-gray-500 px-5 py-3.5">{{ __('admin.col_actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($vehicles as $vehicle)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    @if($vehicle->mainImage)
                                        <img src="{{ Storage::url($vehicle->mainImage->image_path) }}"
                                             class="w-14 h-10 object-cover rounded-lg border border-gray-200 shrink-0">
                                    @else
                                        <div class="w-14 h-10 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $vehicle->brand?->name }} {{ $vehicle->model }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $vehicle->version ?: '—' }} · {{ ucfirst(str_replace('_',' ',$vehicle->fuel_type)) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="font-semibold text-sm text-slate-800">{{ $vehicle->year }}</div>
                                <div class="text-xs text-gray-400">{{ number_format($vehicle->mileage,0,',',' ') }} km</div>
                            </td>
                            <td class="px-4 py-3.5 font-extrabold text-slate-900 text-sm whitespace-nowrap">
                                {{ number_format($vehicle->price,0,',',' ') }} €
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex text-xs font-bold px-2.5 py-1 rounded-full status-{{ $vehicle->status }}">
                                    {{ ucfirst($vehicle->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                @if($vehicle->export_available)
                                    <span class="inline-flex text-xs font-bold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700">{{ __('admin.col_export') }}</span>
                                @else
                                    <span class="text-gray-300 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.vehicules.show',$vehicle) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">{{ __('admin.btn_view') }}</a>
                                    @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.vehicules.edit',$vehicle) }}" class="text-xs font-semibold text-gray-500 hover:text-gray-700">{{ __('admin.btn_edit') }}</a>
                                    <form action="{{ route('admin.vehicules.destroy',$vehicle) }}" method="POST"
                                          onsubmit="return confirm('{{ __('admin.confirm_del_v') }}')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-red-400 hover:text-red-600 transition-colors">{{ __('admin.btn_del_short') }}</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100 flex items-center justify-between flex-wrap gap-3">
            <span class="text-xs text-gray-500">{{ __('admin.vehicles_count', ['count' => $vehicles->total()]) }}</span>
            {{ $vehicles->links() }}
        </div>
    @endif
</div>

@endsection
