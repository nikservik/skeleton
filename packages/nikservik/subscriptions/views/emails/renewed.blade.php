@extends('emails.layout')

@section('preheader')
    @lang('subscriptions::emails/renewed.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('subscriptions::emails/renewed.hello', ['name' => $subscription->user->name])])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/renewed.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/renewed.line2')])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/renewed.line3')])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/renewed.signature', ['name' => __('app.name')])])
@endsection
