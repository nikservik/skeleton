@extends('emails.layout')

@section('preheader')
    @lang('subscriptions::emails/activated.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('subscriptions::emails/activated.hello', ['name' => $subscription->user->name])])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/activated.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/activated.line2')])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/activated.line3')])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/activated.signature', ['name' => __('app.name')])])
@endsection
