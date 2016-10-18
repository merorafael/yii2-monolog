<?php

namespace Mero\Monolog\Handler;

use Monolog\Logger;

class StrategyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Strategy Strategy object
     */
    protected $strategy;

    protected function setUp()
    {
        $this->strategy = new Strategy();
    }

    public function dataProviderHandlerNotImplemented()
    {
        return [
            [
                'elasticsearch',
                'fingers_crossed',
                'filter',
                'buffer',
                'deduplication',
                'group',
                'whatfailuregroup',
                'swift_mailer',
                'pushover',
                'raven',
                'newrelic',
                'cube',
                'amqp',
                'error_log',
                'null',
                'test',
                'debug',
                'loggly',
                'logentries',
                'flowdock',
                'rollbar',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderHandlerNotImplemented
     * @expectedException \BadMethodCallException
     */
    public function testHandlerNotImplemented($type)
    {
        $this->strategy->createFactory([
            'type' => $type,
            'level' => Logger::DEBUG,
        ]);
    }

    public function dataProviderParameterNotFoundException()
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
                [
                    'type' => 'syslog',
                ],
                [
                    'type' => 'syslogudp',
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderParameterNotFoundException
     * @expectedException \Mero\Monolog\Exception\ParameterNotFoundException
     */
    public function testParameterNotFoundException(array $config)
    {
        $this->strategy->createFactory($config);
    }
}
