<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Logger;

class BrowserConsoleFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateHandler()
    {
        $factory = new BrowserConsoleFactory([
            'type' => 'browser_console',
            'level' => Logger::DEBUG,
        ]);
        $handler = $factory->createHandler();
        $this->assertInstanceOf('Monolog\Handler\BrowserConsoleHandler', $handler);
    }
}
