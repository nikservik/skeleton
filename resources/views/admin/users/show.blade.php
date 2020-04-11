@extends('admin.layout')

@section('content')
<h1 class="page-header">
	<a href="/users" class="text-white">@lang('admin/users.listTitle')</a> 
</h1>
<h2 class="sub-header">{{ $user->name }}</h2>
<div class="mb-4 text-right">
    <a class="button small mr-4" href="/users/{{ $user->id }}/edit">
        @lang('admin/users.modify')
    </a>
    <a class="button small" href="javascript:document.user_delete.submit()" onclick="return confirm('@lang('admin/users.confirmDelete')')">
        @lang('admin/users.delete')
    </a>
</div>
    <form name="user_delete" action="/users/{{ $user->id }}" method="POST">
        @csrf 
        @method('DELETE')
    </form>

<div class="flex items-center mt-8 mb-4 mx-10">
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
<p class="my-4 mx-10">@lang('admin/users.registered') {{ $user->created_at->format('d.m.Y') }}</p>

<p class="my-4 mx-10">@lang('admin/users.role'): @lang('app.role'.$user->role)</p>


<h2 class="sub-title">@lang('admin/users.subscription')</h2>



@endsection