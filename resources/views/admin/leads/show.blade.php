@extends('layouts.admin')
@section('title', 'Lead — ' . $lead->name)
@section('breadcrumb', __('admin.nav_leads') . ' / ' . $lead->name)
@section('content')

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
        <div class="flex items-center gap-2 mt-1.5 flex-wrap">
            <span class="text-xs font-bold px-2.5 py-1 rounded-full
                @if($lead->type === 'export') bg-blue-100 text-blue-700
                @elseif($lead->type === 'quote') bg-violet-100 text-violet-700
                @elseif($lead->type === 'test_drive') bg-emerald-100 text-emerald-700
                @elseif($lead->type === 'whatsapp') bg-green-100 text-green-700
                @else bg-gray-100 text-gray-600 @endif">
                {{ \App\Models\Lead::typeLabels()[$lead->type] ?? $lead->type }}
            </span>
            <span class="text-xs font-bold px-2.5 py-1 rounded-full status-{{ $lead->current_status }}">
                {{ \App\Models\Lead::statusLabels()[$lead->current_status] ?? $lead->current_status }}
            </span>
            <span class="text-xs text-gray-400">{{ $lead->created_at->format('d/m/Y à H:i') }}</span>
        </div>
    </div>
    <a href="{{ route('admin.leads.index') }}" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">{{ __('admin.btn_back') }}</a>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    {{-- Left --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Contact info --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <h2 class="font-bold text-slate-900 text-sm mb-4">{{ __('admin.lead_contact_info') }}</h2>
            <div class="grid sm:grid-cols-2 gap-3">
                @foreach([
                    __('admin.lead_name')    => $lead->name  ?? '—',
                    __('admin.lead_email')   => $lead->email ?? '—',
                    __('admin.lead_phone')   => $lead->phone ?? '—',
                    __('admin.lead_country') => $lead->country ?? '—',
                ] as $k => $v)
                    <div class="bg-gray-50 border border-gray-100 rounded-lg p-3">
                        <div class="text-xs text-gray-400 font-semibold mb-1">{{ $k }}</div>
                        <div class="text-sm font-semibold text-slate-800">{{ $v }}</div>
                    </div>
                @endforeach
            </div>
            @if($lead->message)
                <div class="mt-3 bg-gray-50 border border-gray-100 rounded-lg p-4">
                    <div class="text-xs text-gray-400 font-semibold mb-2">{{ __('admin.lead_message') }}</div>
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $lead->message }}</p>
                </div>
            @endif
        </div>

        {{-- Vehicle --}}
        @if($lead->vehicle)
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h2 class="font-bold text-slate-900 text-sm mb-3">{{ __('admin.lead_vehicle') }}</h2>
                <a href="{{ route('admin.vehicules.show', $lead->vehicle) }}"
                   class="flex items-center gap-4 p-4 bg-gray-50 border border-gray-100 rounded-xl hover:bg-blue-50 hover:border-blue-200 transition-colors">
                    @if($lead->vehicle->mainImage)
                        <img src="{{ Storage::url($lead->vehicle->mainImage->image_path) }}"
                             class="w-16 h-12 object-cover rounded-lg border border-gray-200 shrink-0">
                    @endif
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-slate-900">{{ $lead->vehicle->brand?->name }} {{ $lead->vehicle->model }}</div>
                        <div class="text-sm text-gray-500 mt-0.5">{{ $lead->vehicle->year }} · {{ number_format($lead->vehicle->price, 0, ',', ' ') }} €</div>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        @endif

        {{-- History --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <h2 class="font-bold text-slate-900 text-sm mb-4">{{ __('admin.lead_status_hist') }}</h2>
            @if($lead->statusHistory->isEmpty())
                <p class="text-sm text-gray-400">{{ __('admin.no_history') }}</p>
            @else
                <div class="space-y-4">
                    @foreach($lead->statusHistory as $h)
                        <div class="flex gap-3 items-start">
                            <div class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 shrink-0"></div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full status-{{ $h->status }}">
                                        {{ \App\Models\Lead::statusLabels()[$h->status] ?? $h->status }}
                                    </span>
                                    <span class="text-xs text-gray-400">{{ $h->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                @if($h->comment)
                                    <p class="text-sm text-gray-600 mt-1.5">{{ $h->comment }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Right sidebar --}}
    <div class="space-y-4">

        {{-- Change status --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <h2 class="font-bold text-slate-900 text-sm mb-4">{{ __('admin.lead_change_status') }}</h2>
            <form action="{{ route('admin.leads.status', $lead) }}" method="POST" class="space-y-3">
                @csrf
                <select name="status" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 transition-colors">
                    @foreach(\App\Models\Lead::statusLabels() as $val => $label)
                        <option value="{{ $val }}" {{ $lead->current_status === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <textarea name="comment" rows="3" placeholder="{{ __('admin.ph_comment') }}"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 transition-colors resize-none"></textarea>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl text-sm transition-colors">
                    {{ __('admin.btn_update') }}
                </button>
            </form>
        </div>

        {{-- Assignment --}}
        @if(auth()->user()->isAdmin())
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h2 class="font-bold text-slate-900 text-sm mb-4">{{ __('admin.lead_assignment') }}</h2>
                <form action="{{ route('admin.leads.update', $lead) }}" method="POST" class="space-y-3">
                    @csrf @method('PUT')
                    <select name="assigned_to" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 transition-colors">
                        <option value="">{{ __('admin.not_assigned') }}</option>
                        @foreach($commercials as $c)
                            <option value="{{ $c->id }}" {{ $lead->assigned_to === $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 rounded-xl text-sm transition-colors">
                        {{ __('admin.btn_save') }}
                    </button>
                </form>
            </div>
        @else
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h2 class="font-bold text-slate-900 text-sm mb-3">{{ __('admin.assigned_to') }}</h2>
                <div class="flex items-center gap-3 p-3 bg-blue-50 border border-blue-100 rounded-lg">
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="font-semibold text-slate-900 text-sm">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-400">{{ __('admin.assigned_commercial') }}</div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Quick contact --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <h2 class="font-bold text-slate-900 text-sm mb-3">{{ __('admin.lead_quick_contact') }}</h2>
            <div class="space-y-2">
                <a href="mailto:{{ $lead->email }}"
                   class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-blue-50 border border-gray-100 hover:border-blue-200 rounded-lg transition-colors text-sm text-gray-700">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="truncate">{{ $lead->email }}</span>
                </a>
                @if($lead->phone)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $lead->phone) }}" target="_blank"
                       class="flex items-center gap-3 p-3 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 rounded-lg transition-colors text-sm text-emerald-700">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.524 5.847L.057 23.882l6.19-1.624A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.845 0-3.574-.5-5.063-1.37l-.363-.214-3.755.985.999-3.648-.236-.376A9.94 9.94 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                        </svg>
                        WhatsApp {{ $lead->phone }}
                    </a>
                @endif
            </div>
        </div>

        {{-- Delete (admin only) --}}
        @if(auth()->user()->isAdmin())
        <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_del_lead') }}')">
            @csrf @method('DELETE')
            <button type="submit" class="w-full bg-white border border-red-200 hover:bg-red-50 text-red-500 font-semibold py-2.5 rounded-xl text-sm transition-colors">
                {{ __('admin.btn_del_lead') }}
            </button>
        </form>
        @endif
    </div>
</div>

@endsection
