@extends('emails.layout')

@section('preheader')
    @lang('emails/subscriptions/about-to-renew.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('emails/subscriptions/about-to-renew.hello', ['name' => $subscription->user->name])])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/about-to-renew.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/about-to-renew.line2')])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/about-to-renew.line3')])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/about-to-renew.signature', ['name' => __('app.name')])])
@endsection
