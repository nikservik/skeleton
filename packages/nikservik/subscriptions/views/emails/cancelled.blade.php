@extends('emails.layout')

@section('preheader')
    @lang('subscriptions::emails/cancelled.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('subscriptions::emails/cancelled.hello', ['name' => $subscription->user->name])])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/cancelled.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/cancelled.line2')])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/cancelled.line3')])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/cancelled.signature', ['name' => __('app.name')])])
@endsection
