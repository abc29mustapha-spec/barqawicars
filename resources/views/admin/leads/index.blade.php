@extends('layouts.admin')
@section('title', __('admin.nav_leads'))
@section('breadcrumb', __('admin.nav_leads'))
@section('content')

<div class="flex items-center justify-between mb-5 flex-wrap gap-3">
    <div>
        <h1 class="text-xl font-extrabold text-slate-900">{{ __('admin.leads') }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">
            {{ __('admin.leads_count', ['count' => $leads->total()]) }}
            @if(!auth()->user()->isAdmin()) {{ __('admin.leads_assigned') }} @else {{ __('admin.leads_total') }} @endif
        </p>
    </div>
</div>

@if(!auth()->user()->isAdmin())
    <div class="flex items-center gap-3 bg-blue-50 border border-blue-200 text-blue-800 text-sm px-4 py-3 rounded-xl mb-5">
        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ __('admin.leads_notice') }}
    </div>
@endif

{{-- Filters --}}
<div class="bg-white border border-gray-200 rounded-xl p-4 mb-5">
    <form method="GET" action="{{ route('admin.leads.index') }}" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-44">
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">{{ __('admin.btn_filter') }}</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('admin.ph_search_lead') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors">
        </div>
        <div class="w-40">
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">{{ __('admin.col_type') }}</label>
            <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-blue-500 transition-colors">
                <option value="">{{ __('admin.filter_all_types') }}</option>
                @foreach(\App\Models\Lead::typeLabels() as $val => $label)
                    <option value="{{ $val }}" {{ request('type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-40">
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">{{ __('admin.col_status') }}</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-blue-500 transition-colors">
                <option value="">{{ __('admin.filter_all_statuses') }}</option>
                @foreach(\App\Models\Lead::statusLabels() as $val => $label)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">{{ __('admin.btn_filter') }}</button>
        @if(request()->hasAny(['search','type','status']))
            <a href="{{ route('admin.leads.index') }}" class="text-sm text-gray-400 hover:text-gray-600 py-2">{{ __('admin.btn_clear') }}</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    @if($leads->isEmpty())
        <div class="text-center py-20">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z"/>
            </svg>
            <p class="text-gray-400 font-medium text-sm">{{ __('admin.no_lead_found') }}</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full min-w-[750px]">
                <thead>
                    <tr class="bg-gray-50 border-b-2 border-gray-200">
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-5 py-3.5">{{ __('admin.col_contact') }}</th>
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_type') }}</th>
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_vehicle_h') }}</th>
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_status') }}</th>
                        @if(auth()->user()->isAdmin())
                            <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_assigned') }}</th>
                        @endif
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_date_h') }}</th>
                        <th class="text-right text-[11px] font-bold uppercase tracking-wider text-gray-500 px-5 py-3.5">{{ __('admin.col_action_h2') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($leads as $lead)
                        @php
                        $typeClass = match($lead->type) {
                            'export'     => 'bg-blue-100 text-blue-700',
                            'quote'      => 'bg-violet-100 text-violet-700',
                            'test_drive' => 'bg-emerald-100 text-emerald-700',
                            'whatsapp'   => 'bg-green-100 text-green-700',
                            default      => 'bg-gray-100 text-gray-600',
                        };
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="font-bold text-slate-900 text-sm">{{ $lead->name ?? '—' }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $lead->email ?? '—' }}</div>
                                @if($lead->phone)
                                    <div class="text-xs text-gray-400">{{ $lead->phone }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex text-[10px] font-bold px-2 py-0.5 rounded-full {{ $typeClass }}">
                                    {{ \App\Models\Lead::typeLabels()[$lead->type] ?? $lead->type }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-sm text-gray-600">
                                @if($lead->vehicle)
                                    <a href="{{ route('admin.vehicules.show',$lead->vehicle) }}"
                                       class="flex items-center gap-2.5 hover:opacity-80 transition-opacity">
                                        @if($lead->vehicle->mainImage)
                                            <img src="{{ Storage::url($lead->vehicle->mainImage->image_path) }}"
                                                 class="w-12 h-9 object-cover rounded-lg border border-gray-200 shrink-0">
                                        @else
                                            <div class="w-12 h-9 rounded-lg bg-gray-100 border border-gray-200 shrink-0"></div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-blue-600 leading-tight">{{ $lead->vehicle->brand?->name }} {{ $lead->vehicle->model }}</div>
                                            <div class="text-xs text-gray-400">{{ $lead->vehicle->year }}</div>
                                        </div>
                                    </a>
                                @else
                                    <span class="text-gray-300">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex text-xs font-bold px-2.5 py-1 rounded-full status-{{ $lead->current_status }}">
                                    {{ \App\Models\Lead::statusLabels()[$lead->current_status] ?? $lead->current_status }}
                                </span>
                            </td>
                            @if(auth()->user()->isAdmin())
                                <td class="px-4 py-3.5 text-sm text-gray-500">
                                    {{ $lead->assignedTo?->name ?? '—' }}
                                </td>
                            @endif
                            <td class="px-4 py-3.5 text-xs text-gray-400 whitespace-nowrap">
                                {{ $lead->created_at->diffForHumans() }}
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <a href="{{ route('admin.leads.show',$lead) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">{{ __('admin.btn_view_lead') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100 flex items-center justify-between flex-wrap gap-3">
            <span class="text-xs text-gray-500">{{ __('admin.leads_count', ['count' => $leads->total()]) }}</span>
            {{ $leads->links() }}
        </div>
    @endif
</div>

@endsection
