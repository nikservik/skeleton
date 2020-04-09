@extends('emails.layout')
{{-- subject('Изменение пароля') --}}
@section('preheader')
    Ссылка для установки нового пароля.
@endsection
@section('content')
    @include('emails.parts.line', ['text' => '<b>Здравствуйте, '.$user->name.'!</b>'])
    @include('emails.parts.line', ['text' => 'Вы получили это письмо, потому что запросили изменение пароля для Вашего входа в личный кабинет «'.__('app.name').'».'])
    @include('emails.parts.line', ['text' => 'Чтобы изменить пароль, нажмите на кнопку ниже и введите новый пароль.'])
    @include('emails.parts.button', ['text' => 'Изменить пароль', 'link' => url('/remind/new?token='.$token.'&email='.$user->email)])
    @include('emails.parts.line', ['text' => 'Если Вы не запрашивали изменение пароля – ничего делать не нужно. Без Вашего ведома пароль никто не сможет изменить.'])
    @include('emails.parts.line', ['text' => '<i>С любовью,<br>Ваш гуру</i>'])
@endsection
