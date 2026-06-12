@props(['vehicle', 'locale', 'eager' => false])
@php
    $imageUrl = $vehicle->mainImage ? Storage::url($vehicle->mainImage->image_path) : null;
@endphp

<article class="vehicle-card bg-white rounded-2xl overflow-hidden flex flex-col group"
         style="border:1px solid #EAEEF2;">

    {{-- Image --}}
    <a href="{{ route('vehicles.show', ['locale' => $locale, 'id' => $vehicle->id]) }}"
       class="block relative overflow-hidden bg-gray-50 shrink-0" style="aspect-ratio:16/10;">
        @if($imageUrl)
            <img src="{{ $imageUrl }}"
                 alt="{{ $vehicle->brand?->name }} {{ $vehicle->model }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                 loading="{{ $eager ? 'eager' : 'lazy' }}"
                 @if($eager) fetchpriority="high" @endif>
        @else
            <div class="w-full h-full flex flex-col items-center justify-center gap-2" style="background:#F7F8FA;">
                <svg class="w-10 h-10 text-gray-200" viewBox="0 0 48 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.2796 5.09566C11.1662 4.3864 12.2678 4 13.4031 4H25C26.5146 4 27.9883 4.49124 29.2 5.4L35.3769 10.0327L40.597 10.5547C43.6642 10.8614 46 13.4424 46 16.5249V20H41.584C40.8124 21.7659 39.0503 23 37 23C34.9497 23 33.1876 21.7659 32.416 20H17.584C16.8124 21.7659 15.0503 23 13 23C10.9497 23 9.1876 21.7659 8.41604 20H7C4.23858 20 2 17.7614 2 15V9.21922L6.54573 8.08279L10.2796 5.09566Z"/>
                </svg>
                <span class="text-xs text-gray-300 font-medium">{{ __('vehicle.no_photo') }}</span>
            </div>
        @endif

        {{-- Badges overlay --}}
        <div class="absolute top-2.5 left-2.5 flex flex-col gap-1.5">
            @if($vehicle->status === 'vendu')
                <span class="text-white text-[10px] font-semibold px-2 py-0.5 rounded-md uppercase tracking-wide"
                      style="background:rgba(13,45,109,0.9);">{{ __('vehicle.sold_badge') }}</span>
            @endif
            @if($vehicle->condition === 'neuf')
                <span class="text-white text-[10px] font-semibold px-2 py-0.5 rounded-md uppercase tracking-wide bg-emerald-500">{{ __('vehicle.new_badge') }}</span>
            @endif
        </div>
        @if($vehicle->vat_status === 'recuperable')
            <span class="absolute top-2.5 right-2.5 text-[10px] font-semibold px-2 py-0.5 rounded-md text-white"
                  style="background:rgba(13,45,109,0.85);">TVA récup.</span>
        @endif
    </a>

    {{-- Content --}}
    <div class="p-4 flex flex-col flex-1">

        {{-- Brand --}}
        @if($vehicle->brand)
            <span class="text-[10px] font-semibold uppercase tracking-widest text-gray-400 mb-1">
                {{ $vehicle->brand->name }}
            </span>
        @endif

        {{-- Model --}}
        <a href="{{ route('vehicles.show', ['locale' => $locale, 'id' => $vehicle->id]) }}"
           class="font-semibold text-sm leading-snug line-clamp-1 mb-3 hover:opacity-70 transition-opacity"
           style="color:#0D2D6D;">
            {{ $vehicle->model }}
            @if($vehicle->version)
                <span class="font-normal text-gray-400 text-xs">· {{ $vehicle->version }}</span>
            @endif
        </a>

        {{-- Specs grid --}}
        <div class="grid grid-cols-2 gap-1.5 mb-4">
            @php $specItems = [
                ['icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'val'=>$vehicle->year],
                ['icon'=>'M13 10V3L4 14h7v7l9-11h-7z', 'val'=>number_format($vehicle->mileage,0,',',' ').' km'],
                ['icon'=>'M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h6l2-1zM15 6h2l3 10-2 1h-3V6z', 'val'=>ucfirst(str_replace('_',' ',$vehicle->fuel_type))],
                ['icon'=>'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4', 'val'=>$vehicle->transmission ? ucfirst(str_replace('_',' ',$vehicle->transmission)) : '—'],
            ]; @endphp
            @foreach($specItems as $s)
                <div class="flex items-center gap-1.5 text-xs text-gray-500 bg-gray-50 rounded-lg px-2 py-1.5">
                    <svg class="w-3 h-3 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/>
                    </svg>
                    <span class="truncate font-medium">{{ $s['val'] }}</span>
                </div>
            @endforeach
        </div>

        {{-- Price + CTA --}}
        <div class="mt-auto pt-3.5 border-t flex items-center justify-between gap-3" style="border-color:#F0F2F5;">
            <div>
                @if($vehicle->ancien_prix && $vehicle->ancien_prix > $vehicle->price)
                    <p class="text-[11px] text-gray-400 line-through leading-none mb-0.5">
                        {{ number_format($vehicle->ancien_prix, 0, ',', ' ') }} €
                    </p>
                    @php $discount = round((($vehicle->ancien_prix - $vehicle->price) / $vehicle->ancien_prix) * 100); @endphp
                    <span class="inline-block text-[10px] font-bold text-white bg-red-500 px-1.5 py-0.5 rounded mb-1 leading-none">
                        -{{ $discount }}%
                    </span>
                @endif
                <p class="text-lg font-bold leading-none" style="color:#0D2D6D;">
                    {{ number_format($vehicle->price, 0, ',', ' ') }} €
                </p>
                @if($vehicle->vat_status)
                    <p class="text-[10px] text-gray-400 mt-0.5 font-medium">
                        {{ $vehicle->vat_status === 'recuperable' ? __('vehicle.vat_recov_short') : __('vehicle.vat_non_recov_short') }}
                    </p>
                @endif
            </div>
            <a href="{{ route('vehicles.show', ['locale' => $locale, 'id' => $vehicle->id]) }}"
               class="shrink-0 text-xs font-semibold px-3.5 py-2 rounded-xl border-2 transition-all hover:text-white hover:shadow-sm"
               style="color:#0D2D6D; border-color:#0D2D6D;"
               onmouseover="this.style.background='#0D2D6D'"
               onmouseout="this.style.background='transparent'">
                {{ __('vehicles.see_detail') }}
            </a>
        </div>
    </div>
</article>
