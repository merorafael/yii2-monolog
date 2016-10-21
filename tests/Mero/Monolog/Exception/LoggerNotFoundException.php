<?php

namespace Mero\Monolog\Exception;

class LoggerNotFoundException extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Mero\Monolog\Exception\LoggerNotFoundException
     */
    public function testThrowException()
    {
        throw new self();
    }
}
