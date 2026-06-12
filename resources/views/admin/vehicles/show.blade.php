@extends('layouts.admin')
@section('title', $vehicle->brand?->name.' '.$vehicle->model)
@section('breadcrumb', __('admin.nav_vehicles').' / '.$vehicle->brand?->name.' '.$vehicle->model)
@section('content')

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
        <h1 class="text-xl font-extrabold text-slate-900">{{ $vehicle->brand?->name }} {{ $vehicle->model }} {{ $vehicle->version }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $vehicle->year }} · {{ number_format($vehicle->mileage,0,',',' ') }} km · <span class="font-bold text-slate-700">{{ number_format($vehicle->price,0,',',' ') }} €</span></p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.vehicules.edit',$vehicle) }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            {{ __('admin.btn_edit') }}
        </a>
        <form action="{{ route('admin.vehicules.destroy',$vehicle) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_del_v_perm') }}')">
            @csrf @method('DELETE')
            <button type="submit" class="inline-flex items-center bg-white border border-red-200 hover:bg-red-50 text-red-500 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">{{ __('admin.btn_delete') }}</button>
        </form>
        @endif
        <a href="{{ route('admin.vehicules.index') }}" class="inline-flex items-center bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">{{ __('admin.btn_back') }}</a>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    {{-- Main column --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Photos --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5" x-data="imgUploader()">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-slate-900 text-sm">{{ __('admin.photos') }}
                    <span class="ml-1.5 bg-gray-100 text-gray-500 text-xs font-bold px-2 py-0.5 rounded-full">{{ $vehicle->images->count() }}</span>
                </h2>
            </div>

            @if($vehicle->images->isNotEmpty())
                <div class="grid grid-cols-4 sm:grid-cols-5 gap-2.5 mb-4">
                    @foreach($vehicle->images as $img)
                        <div class="relative group aspect-square rounded-lg overflow-hidden border {{ $img->is_main ? 'border-blue-500 border-2' : 'border-gray-200' }} bg-gray-50">
                            <img src="{{ Storage::url($img->image_path) }}" class="w-full h-full object-cover">
                            @if($img->is_main)
                                <span class="absolute top-1 left-1 bg-blue-600 text-white text-[9px] font-bold px-1.5 py-0.5 rounded">{{ __('admin.label_main') }}</span>
                            @endif
                            @if(auth()->user()->isAdmin())
                            <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-1.5">
                                @if(!$img->is_main)
                                    <form action="{{ route('admin.vehicles.images.setMain',[$vehicle,$img]) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-blue-600 text-white text-[10px] font-bold px-2 py-1 rounded hover:bg-blue-700">{{ __('admin.btn_set_main') }}</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.vehicles.images.destroy',[$vehicle,$img]) }}" method="POST" onsubmit="return confirm('?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded hover:bg-red-600">✕</button>
                                </form>
                            </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Upload (admin only) --}}
            @if(auth()->user()->isAdmin())
            <form action="{{ route('admin.vehicles.images.store',$vehicle) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 transition-colors"
                     :class="isDragging ? 'border-blue-500 bg-blue-50' : ''"
                     @dragover.prevent="isDragging=true"
                     @dragleave.prevent="isDragging=false"
                     @drop.prevent="drop($event)"
                     @click="$refs.fi.click()">
                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-gray-500" x-show="!previews.length">{{ __('admin.ph_drag_photos') }}</p>
                    <p class="text-xs text-gray-400 mt-1" x-show="!previews.length">{{ __('admin.photo_hint') }}</p>
                    <p class="text-sm font-semibold text-blue-600" x-show="previews.length" x-text="'{{ addslashes(__('admin.photo_count', ['count' => ''])) }}' + previews.length"></p>
                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp"
                           x-ref="fi" @change="pick($event)" class="hidden">
                </div>

                <div x-show="previews.length" class="grid grid-cols-5 gap-2 mt-3">
                    <template x-for="(p,i) in previews" :key="i">
                        <div class="relative aspect-square rounded-lg overflow-hidden bg-gray-100">
                            <img :src="p" class="w-full h-full object-cover">
                            <button type="button" @click.stop="remove(i)"
                                    class="absolute top-0.5 right-0.5 w-4 h-4 bg-red-500 hover:bg-red-600 text-white rounded-full text-[9px] font-bold flex items-center justify-center">✕</button>
                        </div>
                    </template>
                </div>

                <div class="mt-3 flex gap-2">
                    <button type="submit" x-show="previews.length"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        {{ __('admin.btn_upload') }}
                    </button>
                    <button type="button" x-show="!previews.length" @click="$refs.fi.click()"
                            class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold py-2.5 rounded-xl transition-colors">
                        {{ __('admin.btn_choose_photos') }}
                    </button>
                </div>
            </form>
            @endif
        </div>

        {{-- Specs --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="bg-gray-50 border-b border-gray-100 px-5 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('admin.vehicle_specs') }}</div>
            @php
            $vatLabels = ['recuperable' => __('admin.vat_rec'), 'non_recuperable' => __('admin.vat_non_rec')];
            $specs = [
                __('admin.col_fuel')         => ucfirst(str_replace('_',' ',$vehicle->fuel_type)),
                __('admin.col_transmission') => ucfirst(str_replace('_',' ',$vehicle->transmission??'—')),
                __('admin.col_power')        => $vehicle->power_hp ? $vehicle->power_hp.' ch / '.$vehicle->power_kw.' kW' : '—',
                __('admin.col_ext_color')    => $vehicle->exterior_color ?? '—',
                __('admin.col_int_color')    => $vehicle->interior_color ?? '—',
                __('admin.col_vin')          => $vehicle->vin ?? '—',
                __('admin.col_warranty')     => $vehicle->warranty ? __('admin.val_yes') : __('admin.val_no'),
                __('admin.col_vat')          => $vehicle->vat_status ? ($vatLabels[$vehicle->vat_status] ?? $vehicle->vat_status) : '—',
            ];
            @endphp
            <div class="grid grid-cols-2 divide-x divide-gray-50">
                @foreach($specs as $k=>$v)
                    <div class="flex justify-between items-center px-5 py-3 border-b border-gray-50 text-sm">
                        <span class="text-gray-500">{{ $k }}</span>
                        <span class="font-semibold text-slate-800 text-right ml-4">{{ $v }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-5">

        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-gray-500">{{ __('admin.col_status') }}</span>
                <span class="text-sm font-bold px-3 py-1 rounded-full status-{{ $vehicle->status }}">{{ ucfirst($vehicle->status) }}</span>
            </div>
            @if($vehicle->vin)
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <p class="text-xs text-gray-400 mb-1">{{ __('admin.col_vin') }}</p>
                    <p class="font-mono text-xs font-semibold text-slate-700 break-all">{{ $vehicle->vin }}</p>
                </div>
            @endif
        </div>

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="font-bold text-slate-900 text-sm">{{ __('admin.vehicle_leads') }}</h2>
                <span class="bg-gray-100 text-gray-500 text-xs font-bold px-2 py-0.5 rounded-full">{{ $vehicle->leads->count() }}</span>
            </div>
            @if($vehicle->leads->isEmpty())
                <p class="text-center text-gray-400 text-sm py-8">{{ __('admin.no_lead') }}</p>
            @else
                <div class="p-3 space-y-1">
                    @foreach($vehicle->leads->take(6) as $lead)
                        <a href="{{ route('admin.leads.show',$lead) }}"
                           class="block px-3 py-2.5 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="font-semibold text-sm text-slate-800">{{ $lead->name }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs text-gray-400 capitalize">{{ $lead->type }}</span>
                                <span class="text-xs font-bold px-1.5 py-0.5 rounded-full status-{{ $lead->current_status }}">
                                    {{ \App\Models\Lead::statusLabels()[$lead->current_status] ?? $lead->current_status }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function imgUploader() {
    return {
        previews: [], isDragging: false, files: new DataTransfer(),
        pick(e) { this.addFiles(Array.from(e.target.files)); },
        drop(e) { this.isDragging=false; this.addFiles(Array.from(e.dataTransfer.files).filter(f=>f.type.startsWith('image/'))); },
        addFiles(list) {
            const msg = '{{ addslashes(__("admin.photo_too_large")) }}';
            list.forEach(f => {
                if(f.size>5*1024*1024){ alert(f.name+' '+msg); return; }
                const r=new FileReader(); r.onload=e=>this.previews.push(e.target.result); r.readAsDataURL(f);
                this.files.items.add(f);
            });
            this.$refs.fi.files=this.files.files;
        },
        remove(i) {
            this.previews.splice(i,1);
            const d=new DataTransfer();
            Array.from(this.files.files).filter((_,j)=>j!==i).forEach(f=>d.items.add(f));
            this.files=d; this.$refs.fi.files=d.files;
        }
    };
}
</script>
@endpush

@endsection
