@extends('layouts.admin')
@section('title', __('admin.brands'))
@section('breadcrumb', __('admin.brands'))
@section('content')

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
        <h1 class="text-xl font-extrabold text-slate-900">{{ __('admin.brands') }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ __('admin.brands_count', ['count' => $brands->count()]) }}</p>
    </div>
    <a href="{{ route('admin.marques.create') }}"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        {{ __('admin.btn_new_brand') }}
    </a>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    @if($brands->isEmpty())
        <div class="text-center py-20">
            <p class="text-gray-400 font-medium text-sm">{{ __('admin.no_brand') }}</p>
            <a href="{{ route('admin.marques.create') }}" class="inline-flex mt-3 text-sm font-semibold text-blue-600 hover:text-blue-700">{{ __('admin.btn_add') }}</a>
        </div>
    @else
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b-2 border-gray-200">
                    <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-5 py-3.5">{{ __('admin.col_brand') }}</th>
                    <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_vehicles_cnt') }}</th>
                    <th class="text-right text-[11px] font-bold uppercase tracking-wider text-gray-500 px-5 py-3.5">{{ __('admin.col_actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($brands as $brand)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                @if($brand->logo_url)
                                    <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}"
                                         class="w-10 h-10 object-contain rounded-lg border border-gray-200 bg-gray-50 p-1">
                                @else
                                    <div class="w-10 h-10 rounded-lg border border-gray-200 bg-gray-100 flex items-center justify-center text-gray-400 text-xs font-bold shrink-0">
                                        {{ strtoupper(substr($brand->name, 0, 2)) }}
                                    </div>
                                @endif
                                <span class="font-semibold text-slate-900 text-sm">{{ $brand->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="text-sm text-gray-600 font-medium">{{ $brand->vehicles_count }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.marques.edit', $brand) }}"
                                   class="text-xs font-semibold text-gray-500 hover:text-gray-700">{{ __('admin.btn_edit') }}</a>
                                @php $confirmBrand = __('admin.confirm_del_brand'); @endphp
                                <form action="{{ route('admin.marques.destroy', $brand) }}" method="POST"
                                      data-confirm="{{ $confirmBrand }}"
                                      onsubmit="return confirm(this.dataset.confirm)">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-red-400 hover:text-red-600 transition-colors">{{ __('admin.btn_del_short') }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
