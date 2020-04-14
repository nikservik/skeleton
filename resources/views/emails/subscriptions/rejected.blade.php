@extends('emails.layout')

@section('preheader')
    @lang('emails/subscriptions/rejected.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('emails/subscriptions/rejected.hello', ['name' => $subscription->user->name])])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/rejected.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/rejected.line2')])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/rejected.line3')])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/rejected.signature', ['name' => __('app.name')])])
@endsection
