<?php

namespace Mero\Monolog\Exception;

class ParameterNotFoundException extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \Mero\Monolog\Exception\ParameterNotFoundException
     */
    public function testThrowException()
    {
        throw new LoggerNotFoundException();
    }

}
