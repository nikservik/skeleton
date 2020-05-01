<?php

namespace Tests\Unit;

use Nikservik\Subscriptions\Facades\CloudPayments;
use Tests\TestCase;

class CloudPaymentsManagerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $result = CloudPayments::apiTest();
        $this->assertTrue($result->Success);
    }
}
