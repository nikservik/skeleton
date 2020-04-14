@extends('emails.layout')

@section('preheader')
    @lang('emails/subscriptions/cancelled.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('emails/subscriptions/cancelled.hello', ['name' => $subscription->user->name])])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/cancelled.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/cancelled.line2')])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/cancelled.line3')])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/cancelled.signature', ['name' => __('app.name')])])
@endsection
