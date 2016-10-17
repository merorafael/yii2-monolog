<?php

namespace Mero\Monolog;

use Monolog\Logger;

class MonologComponentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns a component object.
     *
     * @param array $handler   Handlers configuration
     * @param array $processor Processors configuration
     *
     * @return MonologComponent Component object
     */
    protected function createComponent(array $handler = [], array $processor = [])
    {
        return new MonologComponent([
            'main' => [
                'handler' => $handler,
                'processor' => $processor,
            ],
        ]);
    }

    /**
     * @expectedException \Mero\Monolog\Exception\LoggerNotFoundException
     */
    public function testLoggerNotFoundException()
    {
        $component = $this->createComponent();
        $component->getLogger('test_channel');
    }

    public function testHasLoggerMethod()
    {
        $component = $this->createComponent();
        $this->assertEquals($component->hasLogger('main'), true);
    }

    public function testCreateChannel()
    {
        $component = $this->createComponent();
        $component->createChannel('test', [
            'handler' => [],
        ]);
        $logger = $component->getLogger('test');
        $this->assertEquals($logger instanceof Logger, true);
    }

    /**
     * @expectedException \Mero\Monolog\Exception\LoggerNotFoundException
     */
    public function testCloseChannel()
    {
        $component = $this->createComponent();
        $component->createChannel('test', [
            'handler' => [],
        ]);
        $component->closeChannel('test');
        $component->getLogger('test');
    }
}
