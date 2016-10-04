<?php

namespace Mero\Monolog\Handler;

use Mero\Monolog\TestCase;
use Monolog\Logger;

class YiiDbHandlerTest extends TestCase
{

    /**
     * @expectedException \TypeError
     */
    public function testConstructorInvalidConnection()
    {
        new YiiDbHandler(new \stdClass(), 'table_name');
    }

    public function testHandle()
    {
        $dbConnection = $this
            ->getMockBuilder('\yii\db\Connection')
            ->disableOriginalConstructor()
            ->setMethods([
                'quoteTableName',
                'createCommand'
            ])
            ->getMock();
        $dbCommand = $this
            ->getMockBuilder('\yii\db\Command')
            ->disableOriginalConstructor()
            ->setMethods([
                'insert',
                'execute'
            ])
            ->getMock();
        $dbConnection
            ->method('createCommand')
            ->willReturn($dbCommand);
        $record = $this->getRecord(
            Logger::WARNING,
            'test',
            [
                'data' => new \stdClass,
                'foo' => 34
            ]
        );
        $dbCommand
            ->method('insert')
            ->willReturn($dbCommand);
        $dbCommand
            ->method('execute')
            ->willReturn(1);

        $handler = new YiiDbHandler($dbConnection, 'name_table');
        $handler->handle($record);
    }

}
