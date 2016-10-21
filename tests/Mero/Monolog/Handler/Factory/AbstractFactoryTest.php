<?php

namespace Mero\Monolog\Handler\Factory;

class AbstractFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $mock = $this->getMockBuilder(AbstractFactory::className())
            ->disableOriginalConstructor()
            ->setMethods(['checkParameters'])
            ->getMockForAbstractClass();

        $mock
            ->expects($this->once())
            ->method('checkParameters')
            ->with();

        $reflectedClass = new \ReflectionClass(AbstractFactory::className());
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock, []);
    }
}
