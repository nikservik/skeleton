@extends('emails.layout')

@section('preheader')
    @lang('subscriptions::emails/about-to-renew.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('subscriptions::emails/about-to-renew.hello', ['name' => $subscription->user->name])])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/about-to-renew.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/about-to-renew.line2')])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/about-to-renew.line3')])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/about-to-renew.signature', ['name' => __('app.name')])])
@endsection
