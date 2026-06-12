@extends('layouts.admin')
@section('title', __('admin.audit'))
@section('breadcrumb', __('admin.audit'))
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-extrabold text-slate-900">{{ __('admin.audit') }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ __('admin.audit_subtitle') }}</p>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-xl p-4 mb-5">
    <form method="GET" action="{{ route('admin.audit-logs') }}" class="flex flex-wrap gap-3 items-end">
        <div class="w-44">
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">{{ __('admin.filter_action') }}</label>
            <select name="action" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-blue-500 transition-colors">
                <option value="">{{ __('admin.filter_all') }}</option>
                @foreach(['create', 'update', 'delete', 'login', 'logout', 'import'] as $a)
                    <option value="{{ $a }}" {{ request('action') === $a ? 'selected' : '' }}>{{ ucfirst($a) }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-44">
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">{{ __('admin.filter_entity') }}</label>
            <select name="entity_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-blue-500 transition-colors">
                <option value="">{{ __('admin.filter_all') }}</option>
                @foreach(['vehicle', 'lead', 'user'] as $t)
                    <option value="{{ $t }}" {{ request('entity_type') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">{{ __('admin.btn_filter') }}</button>
        @if(request()->hasAny(['action', 'entity_type']))
            <a href="{{ route('admin.audit-logs') }}" class="text-sm text-gray-400 hover:text-gray-600 py-2">{{ __('admin.btn_clear') }}</a>
        @endif
    </form>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    @if($logs->isEmpty())
        <p class="text-center text-gray-400 text-sm py-16">{{ __('admin.no_log') }}</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px]">
                <thead>
                    <tr class="bg-gray-50 border-b-2 border-gray-200">
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-5 py-3.5">{{ __('admin.col_date') }}</th>
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_user_h') }}</th>
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_action_h') }}</th>
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_entity') }}</th>
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-5 py-3.5">{{ __('admin.col_ip') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3.5 text-xs text-gray-500 font-mono whitespace-nowrap">
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="px-4 py-3.5">
                                @if($log->user)
                                    <div class="font-semibold text-sm text-slate-800">{{ $log->user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $log->user->role }}</div>
                                @else
                                    <span class="text-gray-300 text-sm">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex text-xs font-bold px-2.5 py-1 rounded-full
                                    @if($log->action === 'create') bg-emerald-100 text-emerald-700
                                    @elseif($log->action === 'update') bg-blue-100 text-blue-700
                                    @elseif($log->action === 'delete') bg-red-100 text-red-600
                                    @elseif($log->action === 'login') bg-violet-100 text-violet-700
                                    @elseif($log->action === 'import') bg-amber-100 text-amber-700
                                    @else bg-gray-100 text-gray-500 @endif">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-sm text-gray-600 capitalize">
                                {{ $log->entity_type }}
                                @if($log->entity_id)
                                    <span class="text-gray-400 font-mono text-xs ml-1">#{{ $log->entity_id }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-xs text-gray-400 font-mono">{{ $log->ip_address ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $logs->links() }}
        </div>
    @endif
</div>

@endsection
