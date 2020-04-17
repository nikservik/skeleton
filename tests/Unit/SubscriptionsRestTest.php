<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Nikservik\Subscriptions\Facades\Subscriptions;
use Nikservik\Subscriptions\Models\Tariff;
use Tests\TestCase;


class SubscriptionsRestTest extends TestCase
{
    use DatabaseTransactions;

    public function testList()
    {
        Tariff::where('id', '>', 0)->delete();
        $default = factory(Tariff::class)->create([
            'price' => 0,
            'prolongable' => false,
            'period' => 'endless',
        ]); 
        $trial = factory(Tariff::class)->create([
            'price' => 0,
            'prolongable' => false,
            'period' => '1 month',
        ]); 
        $paid = factory(Tariff::class)->create([
            'price' => 100,
            'prolongable' => true,
            'period' => '1 month',
        ]); 

        $list = Subscriptions::list();

        $this->assertEquals(3, count($list));
    }
}
