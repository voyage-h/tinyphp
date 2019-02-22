<?php

namespace test;

define('APP_PATH',dirname(__DIR__));

use PHPUnit\Framework\TestCase;
use dispatcher\Container;
use dispatcher\Box;

class DispatcherTest extends TestCase 
{
    /**
     * @expectedException ArgumentCountError
     */
    public function testSayHi()
    {
        $this->assertEquals('Hi', A::sayHi());
    }
    public function testSayHello()
    {
        $this->assertEquals('Hello', A::call('sayHello'));
    }
}

class A extends Container
{
    protected function sayHi(Say $say)
    {
        return $say->hi();
    }
    public function sayHello(Say $say)
    {
        return $say->hello();
    }
}
class Say extends Container
{
    public function hi()
    {
        return 'Hi';
    }
    public function hello()
    {
        return 'Hello';
    }
}
