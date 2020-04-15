@extends('admin/layout')

@section('content')

<h1 class="page-header">Тестирование платежей</h1>

<div class="m-10 text-center">
    <a class="button" onclick="pay()">Подписаться за {{ $tariff->price }}</a>
    @if(Auth::user()->token and Auth::user()->subscription()->price >0) 
        <a class="button" href="/test/charge">Заплатить за месяц</a>
    @endif
</div>

<h2 class="sub-title">Уведомления от шлюза</h2>

@foreach(Auth::user()->payments()->orderBy('created_at', 'desc') as $payment)
    <div class="mx-10 my-4 p-4 border border-gray-500 rounded-lg">
        Сумма: {{ $payment->amount }}<br>
        Статус: {{ $payment->status }}<br>
        Карта: {{ $payment->card_last_digits }}<br>
        <a class="button small" href="/test/charge/{{ $payment->card_last_digits }}">Повторить</a>
    </div>
@endforeach

<script src="https://widget.cloudpayments.ru/bundles/cloudpayments"></script>
<script>
var widget = new cp.CloudPayments();
var success = function(options) {
    console.log('success')
    console.log(options)
}
var fail = function(reason, options) {
    console.log('fail')
    console.log(reason)
    console.log(options)
}
var options = { 
    publicId: '{{ config('cloudpayments.publicId') }}',  
    description: 'Подписка', 
    amount: {{ $tariff->price }},
    currency: '{{ $tariff->currency }}', 
    accountId: {{ Auth::id() }},
    email: '{{ Auth::user()->email }}',
    data: {
        tariff_id: {{ $tariff->id }},
        activation: true
    },
    skin: "mini",
};

function pay() {
    widget.charge(options, success, fail);
};     
</script>
@endsection

