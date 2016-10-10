<?php

namespace Mero\Monolog\Handler;

use Mero\Monolog\HandlerTestCase;
use Monolog\Logger;

class YiiMongoHandlerTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorInvalidConnection()
    {
        new YiiMongoHandler(new \stdClass(), 'collection_name');
    }

    public function testHandle()
    {
        $mongoConnection = $this
            ->getMockBuilder('\yii\mongodb\Connection')
            ->disableOriginalConstructor()
            ->getMock();

        $mongoCollection = $this
            ->getMockBuilder('\yii\mongodb\Collection')
            ->disableOriginalConstructor()
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

        $mongoConnection
            ->expects($this->once())
            ->method('getCollection')
            ->will($this->returnValue($mongoCollection));

        $mongoCollection
            ->expects($this->once())
            ->method('insert')
            ->with($expected);

        $handler = new YiiMongoHandler($mongoConnection, 'name_collection');
        $handler->handle($record);
    }
}
