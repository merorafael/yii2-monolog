<?php

namespace Mero\Monolog\Handler;

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
            'channel' => 'test',
            'level' => Logger::WARNING,
            'message' => 'test',
            'time' => $record['datetime']->format('Y-m-d H:i:s'),
        ];

        $tableName = 'name_table';

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
            ->willReturn($dbCommand)
            ->with($tableName, $expected);

        $dbCommand
            ->expects($this->once())
            ->method('execute');

        $handler = new YiiDbHandler($dbConnection, $tableName);
        $handler->handle($record);
    }
}
