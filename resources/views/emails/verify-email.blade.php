@extends('emails.layout')
@section('preheader')
    {{ __('emails/verify-email.preheader', ['app' => __('app.name')]) }}
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('emails/verify-email.hello', ['name' => $user->name])])
    @include('emails.parts.line', ['text' => __('emails/verify-email.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('emails/verify-email.line2')])
    @include('emails.parts.button', ['text' => __('emails/verify-email.button'), 'link' => $verificationUrl])
    @include('emails.parts.line', ['text' => __('emails/verify-email.line3')])
    @include('emails.parts.line', ['text' => __('emails/verify-email.signature', ['name' => __('app.name')])])
@endsection