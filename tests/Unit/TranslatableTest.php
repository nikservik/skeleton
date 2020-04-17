<?php

namespace Tests\Unit;

use Nikservik\Subscriptions\Translatable;
use Tests\TestCase;

class TranslatableTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGet()
    {
        app()->setLocale('en');
        $name = new Translatable(['en'=>'test']);
        
        $this->assertEquals('test', $name);
        $this->assertEquals('test', $name->en);
        $this->assertEquals('test', $name->ru);
    }

    public function testGetSet()
    {
        app()->setLocale('en');
        $name = new Translatable(['en'=>'test', 'ru'=>'тест']);
        
        $this->assertEquals('test', $name);
        $this->assertEquals('test', $name->en);
        $this->assertEquals('тест', $name->ru);

        $name->ru = 'новый';
        $this->assertEquals('новый', $name->ru);
        $name->ru = '';
        $this->assertEquals('test', $name->ru);

    }


    public function testSetString()
    {
        app()->setLocale('ru');
        $name = new Translatable('test');
        
        $this->assertEquals('test', $name);
        $this->assertEquals('test', $name->en);
        $this->assertEquals('test', $name->ru);
    }

    public function testArray()
    {
        app()->setLocale('en');
        $name = new Translatable(['en'=>'test', 'ru'=>'тест']);

        foreach ($name->toArray() as $locale => $trans) {
            $this->assertNotNull($locale);
        }
    }


    public function testLoad()
    {
        app()->setLocale('en');
        $app = Translatable::loadFromLocales('app.name');

        $this->assertEquals(trans('app.name', [], 'en'), $app->en);
        $this->assertEquals(trans('app.name', [], 'ru'), $app->ru);
    }
}
