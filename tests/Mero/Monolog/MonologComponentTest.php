<?php

namespace Mero\Monolog;

class MonologComponentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MonologComponent MonologComponent instance
     */
    protected $component;

    protected function setUp()
    {
        $this->component = new MonologComponent();
    }

    /**
     * Returns channel configuration.
     *
     * @param array $handler   Handlers configuration
     * @param array $processor Processors configuration
     *
     * @return array Channel configuration
     */
    protected function getChannelConfig(array $handler = [], array $processor = [])
    {
        return [
            'handler' => $handler,
            'processor' => $processor,
        ];
    }

    /**
     * @expectedException \Mero\Monolog\Exception\HandlerNotFoundException
     */
    public function testInvalidHandler()
    {
        $this->component->closeChannel('test');
        $this->component->createChannel(
            'test',
            $this->getChannelConfig([
                'invalid_parameter',
            ])
        );
    }

    public function dataProviderInsufficientParameters()
    {
        return [
            [
                [
                    'path' => '@app/runtime/logs/log_'.date('Y-m-d').'.log',
                ],
                [
                    'type' => 'stream',
                ],
                [
                    'type' => 'gelf',
                ],
                [
                    'type' => 'rotating_file',
                    'max_files' => 5,
                ],
                [
                    'type' => 'stream',
                ],
                [
                    'type' => 'yii_db',
                    'table' => 'logs',
                ],
                [
                    'type' => 'yii_mongo',
                    'collection' => 'logs',
                ],
                [
                    'type' => 'hipchat',
                    'token' => 'XXXX',
                ],
                [
                    'type' => 'hipchat',
                    'room' => 'XXXX',
                ],
                [
                    'type' => 'slack',
                    'token' => 'XXXX',
                ],
                [
                    'type' => 'slack',
                    'channel' => 'XXXX',
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderInsufficientParameters
     * @expectedException \Mero\Monolog\Exception\ParameterNotFoundException
     */
    public function testInsufficientParameters(array $config)
    {
        $this->component->closeChannel('test');
        $this->component->createChannel(
            'test',
            $this->getChannelConfig([
                $config,
            ])
        );
    }
}
