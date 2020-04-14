@extends('emails.layout')

@section('preheader')
    @lang('emails/subscriptions/activated.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('emails/subscriptions/activated.hello', ['name' => $subscription->user->name])])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/activated.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/activated.line2')])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/activated.line3')])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/activated.signature', ['name' => __('app.name')])])
@endsection
