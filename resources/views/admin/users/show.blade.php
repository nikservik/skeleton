@extends('admin.layout')

@section('content')
<h1 class="page-header">
	<a href="/users" class="text-white">@lang('admin/users.listTitle')</a> 
</h1>
<h2 class="sub-header">{{ $user->name }}</h2>

<div class="flex items-center mt-8 mb-4">
    @if($user->hasVerifiedEmail())
        <div class="rounded inline-block px-3 py-1 bg-indigo-400 text-white">
            @lang('admin/users.verificationDone')
        </div>
    @else
        <div class="rounded inline-block px-3 py-1 bg-indigo-300 text-white">
            @lang('admin/users.verificationSent')
        </div>
    @endif
    <div class="px-3">{{ $user->email }} </div>
</div> 
<p>@lang('admin/users.registered') {{ $user->created_at->format('d.m.Y') }}</p>

<div class="mt-8 text-right">
    <a class="button mr-4" href="/users/{{ $user->id }}/edit">
        @lang('admin/users.modify')
    </a>
    <a class="button" href="/users/{{ $user->id }}/delete" onclick="return confirm('@lang('admin/users.confirmDelete')')">
        @lang('admin/users.delete')
    </a>
</div>

<h2 class="sub-title">@lang('admin/users.subscription')</h2>



@endsection