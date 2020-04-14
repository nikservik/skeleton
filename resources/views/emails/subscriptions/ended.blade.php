@extends('emails.layout')

@section('preheader')
    @lang('emails/subscriptions/ended.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('emails/subscriptions/ended.hello', ['name' => $subscription->user->name])])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/ended.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/ended.line2')])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/ended.line3')])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/ended.signature', ['name' => __('app.name')])])
@endsection
