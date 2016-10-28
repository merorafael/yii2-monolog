<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Logger;

class ChromePHPFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateHandler()
    {
        $factory = new ChromePHPFactory([
            'type' => 'chromephp',
            'level' => Logger::DEBUG,
        ]);
        $handler = $factory->createHandler();
        $this->assertInstanceOf('Monolog\Handler\ChromePHPHandler', $handler);
    }
}
