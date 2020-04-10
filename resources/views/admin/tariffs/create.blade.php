@extends('admin.layout')

@section('content')
<h1 class="page-header">
    <a href="/tariffs" class="text-white">@lang('admin/tariffs.listTitle')</a> 
</h1>
<h2 class="sub-header">@lang('admin/tariffs.creation')</h2>

<form autocomplete="off" method="post" action="/tariffs">
    @csrf
    <div class="form-group @error('name') has-error @enderror">
        <label for="name">@lang('admin/tariffs.name')</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="" required>
        @error('name')
            <div class="error-description">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="flex">
        <div class="form-group w-1/2 @error('short_name') has-error @enderror">
            <label for="short_name">@lang('admin/tariffs.shortName')</label>
            <input type="text" name="short_name" value="{{ old('short_name') }}" placeholder="" required>
            @error('short_name')
                <div class="error-description">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group w-1/2 @error('price') has-error @enderror">
            <label for="price">@lang('admin/tariffs.price')</label>
            <div class="flex">
                <input type="text" name="price" value="{{ old('price') }}" 
                    class="w-2/3" placeholder="" required>
                <select name="currency" class="w-1/3">
                    <option value="RUB" selected="">RUB</option>
                </select>
            </div>
            @error('price')
                <div class="error-description">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="flex items-end">
        <div class="form-group w-1/2 @error('period') has-error @enderror">
            <label for="period">@lang('admin/tariffs.period')</label>
            <select name="period" class="block">
                @foreach(\App\Subscriptions\Tariff::$periods as $period)
                    <option value="{{ $period }}" @if(old('period')==$period)selected=""@endif>@lang('admin/tariffs.period'.str_replace(' ', '', $period))</option>
                @endforeach
            </select>
            @error('period')
                <div class="error-description">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group w-1/2 pb-4">
            <input type="checkbox" name="prolongable" value="1" @if(old('prolongable'))checked=""@endif>
            <label for="prolongable">@lang('admin/tariffs.prolongable')</label>
        </div>
    </div>
    <div class="form-group text-center">
        <button type="submit" class="button">@lang('admin/tariffs.save')</button>
    </div>
</form>


@endsection