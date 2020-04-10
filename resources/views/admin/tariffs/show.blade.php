@extends('admin.layout')

@section('content')
<h1 class="page-header">
    <a href="/tariffs" class="text-white">@lang('admin/tariffs.listTitle')</a> 
</h1>
<h2 class="sub-header mb-10">{{ $tariff->name }} ({{ $tariff->short_name }})</h2>

<p class="my-4">{{ $tariff->price }} {{ $tariff->currency }}
    / @lang('admin/tariffs.'.$tariff->periodLocale)
    </p>
@if($tariff->prolongable)
    <p class="my-4">@lang('admin/tariffs.prolongable')</p>
@endif


<div class="mt-8 text-right">
    <a class="button small mr-4" href="/tariffs/{{ $tariff->id }}/edit">
        @lang('admin/tariffs.modify')
    </a>
    <a class="button small" href="javascript:document.tariff_delete.submit()" onclick="return confirm('@lang('admin/tariffs.confirmDelete')')">
        @lang('admin/tariffs.delete')
    </a>
</div>
    <form name="tariff_delete" action="/tariffs/{{ $tariff->id }}" method="POST">
        @csrf 
        @method('DELETE')
    </form>



@endsection