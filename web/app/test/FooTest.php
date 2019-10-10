<?php namespace Test;

use Dopmn\Core\Foo;

use PHPUnit\Framework\TestCase;

class FooTest extends TestCase
{
    public function testGetName()
    {
        $foo = new Foo();
        $this->assertEquals($foo->getName(), 'Dopmn');
    }
}
