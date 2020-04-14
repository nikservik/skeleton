@extends('emails.layout')

@section('preheader')
    @lang('emails/subscriptions/past-due.preheader')
@endsection
@section('content')
    @include('emails.parts.line', ['text' => __('emails/subscriptions/past-due.hello', ['name' => $subscription->user->name])])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/past-due.line1', ['app' => __('app.name')])])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/past-due.line2')])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/past-due.line3')])
    @include('emails.parts.line', ['text' => __('emails/subscriptions/past-due.signature', ['name' => __('app.name')])])
@endsection
