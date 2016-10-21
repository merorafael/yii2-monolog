<?php

namespace Mero\Monolog\Exception;

class HandlerNotFoundExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Mero\Monolog\Exception\HandlerNotFoundException
     */
    public function testThrowException()
    {
        throw new HandlerNotFoundException();
    }
}
