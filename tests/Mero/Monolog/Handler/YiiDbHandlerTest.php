<?php

namespace Mero\Monolog\Handler;

use Mero\Monolog\TestCase;
use Monolog\Logger;

class YiiDbHandlerTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorInvalidConnection()
    {
        new YiiDbHandler(new \stdClass(), 'table_name');
    }

    public function testHandle()
    {
        $dbConnection = $this
            ->getMockBuilder('yii\\db\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['quoteTableName', 'createCommand'])
            ->getMock();

        $dbCommand = $this
            ->getMockBuilder('yii\\db\\Command')
            ->disableOriginalConstructor()
            ->setMethods(['insert', 'execute'])
            ->getMock();

        $record = $this->getRecord(
            Logger::WARNING,
            'test',
            [
                'data' => new \stdClass(),
                'foo' => 34,
            ]
        );

        $expected = [
            'message' => 'test',
            'context' => [
                'data' => '[object] (stdClass: {})',
                'foo' => 34,
            ],
            'level' => Logger::WARNING,
            'level_name' => 'WARNING',
            'channel' => 'test',
            'datetime' => $record['datetime']->format('Y-m-d H:i:s'),
            'extra' => [],
        ];

        $dbConnection
            ->expects($this->once())
            ->method('quoteTableName')
            ->will($this->returnValue($dbCommand));

        $dbConnection
            ->expects($this->once())
            ->method('createCommand')
            ->will($this->returnValue($dbCommand));

        $dbCommand
            ->expects($this->once())
            ->method('insert')
            ->will($this->returnValue($dbCommand));

        $dbCommand
            ->expects($this->once())
            ->method('execute')
            ->willReturn($expected);

        $handler = new YiiDbHandler($dbConnection, 'name_table');
        $handler->handle($record);
    }
}
