@extends('emails.layout')
{{-- subject('Изменение пароля') --}}
@section('preheader')
    @lang('emails/password-reset.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('emails/password-reset.hello', ['name' => $user->name])])
    @include('emails.parts.line', ['text' => __('emails/password-reset.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('emails/password-reset.line2')])
    @include('emails.parts.button', ['text' => __('emails/password-reset.button'), 'link' => url('/remind/new?token='.$token.'&email='.$user->email)])
    @include('emails.parts.line', ['text' => __('emails/password-reset.line3')])
    @include('emails.parts.line', ['text' => __('emails/password-reset.signature', ['name' => __('app.name')])])
@endsection
