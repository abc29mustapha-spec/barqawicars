@extends('layouts.admin')
@section('title', __('admin.users'))
@section('breadcrumb', __('admin.users'))
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-extrabold text-slate-900">{{ __('admin.users') }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ __('admin.users_subtitle') }}</p>
    </div>
    <a href="{{ route('admin.utilisateurs.create') }}"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        {{ __('admin.btn_new_user') }}
    </a>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    @if($users->isEmpty())
        <p class="text-center text-gray-400 text-sm py-16">{{ __('admin.no_user') }}</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px]">
                <thead>
                    <tr class="bg-gray-50 border-b-2 border-gray-200">
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-5 py-3.5">{{ __('admin.col_user') }}</th>
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_role') }}</th>
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_status') }}</th>
                        <th class="text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 px-4 py-3.5">{{ __('admin.col_created_at') }}</th>
                        <th class="text-right text-[11px] font-bold uppercase tracking-wider text-gray-500 px-5 py-3.5">{{ __('admin.col_actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-extrabold shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex text-xs font-bold px-2.5 py-1 rounded-full
                                    {{ $user->role === 'admin' ? 'bg-violet-100 text-violet-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $user->role === 'admin' ? __('admin.role_admin') : __('admin.role_commercial') }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                @if($user->is_active)
                                    <span class="inline-flex text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700">{{ __('admin.user_active') }}</span>
                                @else
                                    <span class="inline-flex text-xs font-bold px-2.5 py-1 rounded-full bg-red-100 text-red-600">{{ __('admin.user_disabled') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-sm text-gray-500 whitespace-nowrap">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.utilisateurs.edit', $user) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">{{ __('admin.btn_edit') }}</a>
                                    @if($user->id !== auth()->id())
                                        @php $confirmUser = __('admin.confirm_del_user'); @endphp
                                        <form action="{{ route('admin.utilisateurs.destroy', $user) }}" method="POST"
                                              data-confirm="{{ $confirmUser }}"
                                              onsubmit="return confirm(this.dataset.confirm)">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs font-semibold text-red-400 hover:text-red-600 transition-colors">{{ __('admin.btn_delete') }}</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    @endif
</div>

@endsection
