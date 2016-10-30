<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Logger;
use yii\db\Connection;

class YiiDbFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Mero\Monolog\Exception\ParameterNotFoundException
     */
    public function testParameterNotFound()
    {
        new YiiDbFactory([
            'type' => 'yii_db',
            'level' => Logger::DEBUG,
        ]);
    }

    public function testCreateHandler()
    {
        $factory = $this
            ->getMockBuilder(YiiDbFactory::className())
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

        $reflection = new \ReflectionClass(YiiDbFactory::className());
        $constructor = $reflection->getConstructor();
        $constructor->invoke(
            $factory,
            ['reference' => 'db']
        );

        $method = $reflection->getMethod('createHandler');
        $method->invoke($factory);
    }
}
