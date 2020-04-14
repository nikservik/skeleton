@extends('emails.layout')

@section('preheader')
    @lang('subscriptions::emails/past-due.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('subscriptions::emails/past-due.hello', ['name' => $subscription->user->name])])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/past-due.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/past-due.line2')])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/past-due.line3')])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/past-due.signature', ['name' => __('app.name')])])
@endsection
