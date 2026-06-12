@extends('layouts.admin')
@section('title', __('admin.dashboard'))
@section('breadcrumb', __('admin.dashboard'))
@section('content')

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
        <h1 class="text-xl font-extrabold text-slate-900">{{ __('admin.greeting', ['name' => auth()->user()->name]) }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ now()->isoFormat('dddd D MMMM YYYY') }}</p>
    </div>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('admin.vehicules.create') }}"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        {{ __('admin.btn_add_vehicle') }}
    </a>
    @endif
</div>

{{-- KPI grid --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
    $kpis = [
        ['v'=>$stats['vehicles_actif'],    'l'=>__('admin.kpi_active'),    'bg'=>'bg-blue-50',   'ic'=>'text-blue-600',  'r'=>'admin.vehicules.index', 'svg'=>'M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h6l2-1zM15 6h2l3 10-2 1h-3V6z'],
        ['v'=>$stats['vehicles_sold'],     'l'=>__('admin.kpi_sold'),      'bg'=>'bg-emerald-50','ic'=>'text-emerald-600','r'=>'admin.vehicules.index', 'svg'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['v'=>$stats['leads_new'],         'l'=>__('admin.kpi_new_leads'), 'bg'=>'bg-amber-50',  'ic'=>'text-amber-600', 'r'=>'admin.leads.index',     'svg'=>'M15 17h5l-5 5-5-5h5v-5h-5V7h5v5h5v5zm-6-4H4v-1l4-4H4V6h5v1l-4 4h4v2z'],
        ['v'=>$stats['leads_in_progress'], 'l'=>__('admin.kpi_inprogress'),'bg'=>'bg-violet-50', 'ic'=>'text-violet-600','r'=>'admin.leads.index',     'svg'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
    ];
    @endphp
    @foreach($kpis as $k)
        <a href="{{ route($k['r']) }}"
           class="bg-white border border-gray-200 rounded-xl p-5 flex items-center gap-4 hover:shadow-md transition-all hover:-translate-y-0.5">
            <div class="w-11 h-11 {{ $k['bg'] }} rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 {{ $k['ic'] }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $k['svg'] }}"/>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900">{{ $k['v'] }}</div>
                <div class="text-xs text-gray-500 font-medium mt-0.5">{{ $k['l'] }}</div>
            </div>
        </a>
    @endforeach
</div>

{{-- Tables row --}}
<div class="grid lg:grid-cols-2 gap-5">

    {{-- Latest leads --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="font-bold text-slate-900 text-sm">{{ __('admin.latest_leads') }}</h2>
            <a href="{{ route('admin.leads.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">{{ __('admin.btn_see_all') }}</a>
        </div>
        @if($recentLeads->isEmpty())
            <p class="text-center text-gray-400 text-sm py-10">{{ __('admin.no_lead') }}</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[400px]">
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentLeads as $lead)
                            @php
                            $tc = match($lead->type){ 'export'=>'bg-blue-100 text-blue-700','quote'=>'bg-violet-100 text-violet-700','test_drive'=>'bg-emerald-100 text-emerald-700',default=>'bg-gray-100 text-gray-600' };
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="font-semibold text-slate-800 text-sm">{{ $lead->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $lead->email }}</div>
                                </td>
                                <td class="px-3 py-3">
                                    <span class="inline-flex text-[10px] font-bold px-2 py-0.5 rounded-full {{ $tc }}">{{ $lead->type }}</span>
                                </td>
                                <td class="px-3 py-3">
                                    <span class="inline-flex text-[10px] font-bold px-2 py-0.5 rounded-full status-{{ $lead->current_status }}">
                                        {{ \App\Models\Lead::statusLabels()[$lead->current_status] ?? $lead->current_status }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('admin.leads.show',$lead) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">{{ __('admin.btn_view') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Latest vehicles --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="font-bold text-slate-900 text-sm">{{ __('admin.recent_vehicles') }}</h2>
            <a href="{{ route('admin.vehicules.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">{{ __('admin.btn_see_all') }}</a>
        </div>
        @if($recentVehicles->isEmpty())
            <p class="text-center text-gray-400 text-sm py-10">{{ __('admin.no_vehicle') }}</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[400px]">
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentVehicles as $v)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="font-semibold text-slate-800 text-sm">{{ $v->brand?->name }} {{ $v->model }}</div>
                                    <div class="text-xs text-gray-400">{{ $v->year }} · {{ number_format($v->mileage,0,',',' ') }} km</div>
                                </td>
                                <td class="px-3 py-3 font-bold text-sm text-slate-900 whitespace-nowrap">
                                    {{ number_format($v->price,0,',',' ') }} €
                                </td>
                                <td class="px-3 py-3">
                                    <span class="inline-flex text-[10px] font-bold px-2 py-0.5 rounded-full status-{{ $v->status }}">{{ ucfirst($v->status) }}</span>
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('admin.vehicules.show',$v) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">{{ __('admin.btn_view') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

@endsection
