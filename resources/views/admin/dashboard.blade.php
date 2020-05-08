@extends('admin/layout')

@section('content')
    <h1 class="page-header">@lang('admin/dashboard.title')</h1>
    <div class="flex flex-wrap my-4">
        @can('viewAny', \App\User::class)
        <div class="p-2 w-full md:w-1/2">
            <div class="block py-2 px-4 border border-gray-300 rounded-lg h-full">
                <h3 class="text-2xl font-bold mb-3"><a href="/users">@lang('admin/dashboard.users')</a></h3>
                <div class="description">
                    @lang('admin/dashboard.usersDescription')
                </div>
            </div>
        </div>
        @endcan
        @can('viewAny', Nikservik\Subscriptions\Models\Tariff::class)
        <div class="p-2 w-full md:w-1/2">
            <div class="block py-2 px-4 border border-gray-300 rounded-lg h-full">
                <h3 class="text-2xl font-bold mb-3"><a href="/tariffs">@lang('admin/dashboard.tariffs')</a></h3>
                <div class="description">
                    @lang('admin/dashboard.tariffsDescription')
                </div>
            </div>
        </div>
        @endcan
        <div class="p-2 w-full md:w-1/2">
            <div class="block py-2 px-4 border border-gray-300 rounded-lg h-full">
                <h3 class="text-2xl font-bold mb-3"><a href="/support">@lang('admin/dashboard.support')</a></h3>
                <div class="description">
                    @lang('admin/dashboard.supportDescription')
                </div>
            </div>
        </div>
    </div>
@endsection

