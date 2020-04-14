@extends('emails.layout')

@section('preheader')
    @lang('emails/subscriptions/renewed.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('emails/subscriptions/renewed.hello', ['name' => $subscription->user->name])])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/renewed.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/renewed.line2')])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/renewed.line3')])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/renewed.signature', ['name' => __('app.name')])])
@endsection
