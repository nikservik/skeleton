@extends('emails.layout')
@section('preheader')
    Подтвердите свой адрес, чтобы пользоваться программой «{{ __('app.name') }}».
@endsection
@section('content')
    @include('emails.parts.line', ['text' => '<b>Здравствуйте, '.$user->name.'!</b>'])
    @include('emails.parts.line', ['text' => 'Вы получили это письмо, потому что зарегистрировались в программе «'.__('app.name').'».'])
    {{-- @include('emails.parts.line', ['text' => 'Очень рад вас приветствовать! Вас ждет множество рассчетов и прогнозов.']) --}}
    @include('emails.parts.line', ['text' => 'Чтобы пользоваться программой, подтвердите свой email, нажав на эту кнопку:'])
    @include('emails.parts.button', ['text' => 'Подтвердить email', 'link' => $verificationUrl])
    @include('emails.parts.line', ['text' => 'Если Вы не запрашивали подтверждение адреса, то ничего делать не нужно. Просто проигнорируйте это письмо.'])
    @include('emails.parts.line', ['text' => '<i>С любовью,<br>Ваш гуру</i>'])
@endsection