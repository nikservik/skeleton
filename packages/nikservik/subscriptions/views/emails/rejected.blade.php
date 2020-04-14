@extends('emails.layout')

@section('preheader')
    @lang('subscriptions::emails/rejected.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('subscriptions::emails/rejected.hello', ['name' => $subscription->user->name])])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/rejected.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/rejected.line2')])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/rejected.line3')])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/rejected.signature', ['name' => __('app.name')])])
@endsection
