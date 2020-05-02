<?php

namespace Tests\Unit;

use Nikservik\Subscriptions\CloudPayments\Receipt;
use Nikservik\Subscriptions\CloudPayments\ReceiptItem;
use Tests\TestCase;

class ReceiptTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testItem()
    {
        $item = new ReceiptItem('за месяц', 123);
        $this->assertEquals(123, $item->amount());
        $this->assertEquals('за месяц', $item->toArray()['Label']);
        $this->assertEquals(123, $item->toArray()['Price']);
        $this->assertEquals(1, $item->toArray()['Quantity']);
        $this->assertEquals(123, $item->toArray()['Amount']);
        $this->assertNull($item->toArray()['Vat']);
    }

    public function testReceipt()
    {
        $item = new ReceiptItem('за месяц', 123);
        $receipt = new Receipt(12, 'test@test.com', [$item]);

        $this->assertEquals('Income', $receipt->toArray()['Type']);
        $this->assertEquals(12, $receipt->toArray()['AccountId']);
        $this->assertNotNull($receipt->toArray()['Inn']);
        $this->assertEquals(123, $receipt->toArray()['CustomerReceipt']['Amounts']['Electronic']);
        $this->assertEquals(1, count($receipt->toArray()['CustomerReceipt']['Items']));
        $this->assertEquals('за месяц', $receipt->toArray()['CustomerReceipt']['Items'][0]['Label']);
    }
}
