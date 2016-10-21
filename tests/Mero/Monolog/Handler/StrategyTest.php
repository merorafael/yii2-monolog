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

    /**
     * @expectedException \Mero\Monolog\Exception\ParameterNotFoundException
     */
    public function testParameterNotFoundException()
    {
        $this->strategy->createFactory([
            'path' => '@app/runtime/logs/log_'.date('Y-m-d').'.log',
        ]);
    }
}
