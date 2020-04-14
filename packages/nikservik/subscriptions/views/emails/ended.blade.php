@extends('emails.layout')

@section('preheader')
    @lang('subscriptions::emails/ended.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('subscriptions::emails/ended.hello', ['name' => $subscription->user->name])])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/ended.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/ended.line2')])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/ended.line3')])
    @include('emails.parts.line', ['text' => __('subscriptions::emails/ended.signature', ['name' => __('app.name')])])
@endsection
