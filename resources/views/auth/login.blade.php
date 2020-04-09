@extends('admin.layout')

@section('content')
        <h1 class="page-header">@lang('admin/login.title')</h1>
        <form  method="post" action="/login">
            @csrf
            <div class="form-group @error('email') has-error @enderror">
                <label for="email">@lang('admin/login.email')</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="user@example.com" required autocomplete="email" autofocus>
                @error('email')
                    <div class="error-description">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group @error('email') has-error @enderror">
                <label for="password">@lang('admin/login.password')</label>
                <input type="password" name="password"  autocomplete="current-password" required>
                @error('password')
                    <div class="error-description">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="button">@lang('admin/login.button')</button>
            </div>
        </form>
@endsection
