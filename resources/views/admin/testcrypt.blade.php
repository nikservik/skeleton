@extends('admin/layout')

@section('content')

<h1 class="page-header">Тестирование платежей</h1>

<form id="paymentFormSample" autocomplete="off">
    <div class="m-10 text-center">
        <div class="form-group">
            <input type="text" data-cp="cardNumber" placeholder="number">
        </div>
        <div class="form-group flex">
            <input class="w-1/6" type="text" data-cp="expDateMonth" placeholder="month">
            <input class="w-1/6" type="text" data-cp="expDateYear" placeholder="year">
            <input class="w-1/6" type="text" data-cp="cvv" placeholder="cvv">
        </div>
        <div class="form-group">
            <input type="text" data-cp="name" placeholder="name">
        </div>
        <button type="submit" class="button" click="createCryptogram()">Подготовить</button>
    </div>
</form>

<form id="paymentFormSample" action="/api/test/charge" method="POST" autocomplete="off">
    <input type="hidden" name="crypt" id="crypt">
    <input type="hidden" name="tariff">
    <button type="submit" class="button" onclick="pay()">Оплатить</button>
</form>

<h2 class="sub-title">Уведомления от шлюза</h2>

@foreach(Auth::user()->payments()->orderBy('created_at', 'desc')->get() as $payment)
    <div class="mx-10 my-4 p-4 border border-gray-500 rounded-lg">
        Сумма: {{ $payment->amount }}<br>
        Статус: {{ $payment->status }}<br>
        Карта: {{ $payment->card_last_digits }}<br>
    </div>
@endforeach

<script src="https://widget.cloudpayments.ru/bundles/checkout"></script>
<script>
    var checkout;
    window.onload = function(e) {
        checkout = new cp.Checkout(
            '{{ config('cloudpayments.publicId') }}', 
            document.getElementById("paymentFormSample")
        )
    }
    function createCryptogram() {
        var result = checkout.createCryptogramPacket();

        if (result.success) {
            document.getElementById("crypt").value = result.packet;
        }
        else {
            // найдены ошибки в введённых данных, объект `result.messages` формата: 
            // { name: "В имени держателя карты слишком много символов", cardNumber: "Неправильный номер карты" }
            // где `name`, `cardNumber` соответствуют значениям атрибутов `<input ... data-cp="cardNumber">`
           for (var msgName in result.messages) {
               // alert(result.messages[msgName]);
           }
        }
    };
</script>
@endsection

