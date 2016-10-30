<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Logger;
use yii\mongodb\Connection;

class YiiMongoFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Mero\Monolog\Exception\ParameterNotFoundException
     */
    public function testParameterNotFound()
    {
        new YiiMongoFactory([
            'type' => 'yii_mongo',
            'level' => Logger::DEBUG,
        ]);
    }

    public function testCreateHandler()
    {
        $factory = $this
            ->getMockBuilder(YiiMongoFactory::className())
            ->disableOriginalConstructor()
            ->setMethods(['getYiiConnection'])
            ->getMock();

        $yiiConn = $this
            ->getMockBuilder(Connection::className())
            ->disableOriginalConstructor()
            ->getMock();

        $factory
            ->expects($this->once())
            ->method('getYiiConnection')
            ->willReturn($yiiConn);

        $reflection = new \ReflectionClass(YiiMongoFactory::className());
        $constructor = $reflection->getConstructor();
        $constructor->invoke(
            $factory,
            ['reference' => 'mongodb']
        );

        $method = $reflection->getMethod('createHandler');
        $method->invoke($factory);
    }
}
