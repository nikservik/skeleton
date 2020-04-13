@extends('admin/layout')

@section('content')

<h1 class="page-header">Тестирование платежей</h1>

<div class="m-10 text-center">
    <a class="button" onclick="pay()">Тестовая оплата</a> 
    <a class="button" onclick="authorize()">Тестовая авторизация</a>
</div>

<h2 class="sub-title">Уведомления от шлюза</h2>

@foreach($payments as $payment)
    <div class="mx-10 my-4 p-4 border border-gray-500 rounded-lg">
        Статус: {{ $payment->status }}<br>
        Токен: {{ $payment->card_last_digits }}<br>
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
    publicId: 'pk_4ac2f7a43a9f5f3167e2396048810',  
    description: 'Пример оплаты', 
    amount: 10,
    currency: 'RUB', 
    invoiceId: '1234567', 
    accountId: 12,
    email: 'test@test.com',
    skin: "mini",
};

function pay() {
    options.description = 'Пример оплаты';
    widget.charge(options, success, fail);
};     
function authorize() {
    options.description = 'Пример авторизации';
    widget.auth(options, success, fail);
};     
</script>
@endsection

