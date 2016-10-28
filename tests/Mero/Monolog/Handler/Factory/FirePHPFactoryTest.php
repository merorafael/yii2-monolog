<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Logger;

class FirePHPFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateHandler()
    {
        $factory = new FirePHPFactory([
            'type' => 'firephp',
            'level' => Logger::DEBUG,
        ]);
        $handler = $factory->createHandler();
        $this->assertInstanceOf('Monolog\Handler\FirePHPHandler', $handler);
    }
}
