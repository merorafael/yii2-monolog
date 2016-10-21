<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Logger;

class GelfFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function dataProviderParameterNotFound()
    {
        return [
            [
                [
                    'type' => 'gelf',
                    'level' => Logger::DEBUG,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderParameterNotFound
     * @expectedException \Mero\Monolog\Exception\ParameterNotFoundException
     */
    public function testParameterNotFound(array $params)
    {
        new GelfFactory($params);
    }

    public function testCreateHandler()
    {
        $handlerMock = $this->getMockBuilder('Monolog\Handler\GelfHandler')
            ->disableOriginalConstructor()
            ->getMock();

        $factoryMock = $this->getMockBuilder(GelfFactory::className())
            ->setConstructorArgs([
                [
                    'type' => 'gelf',
                    'publisher' => 'XXXXX',
                    'level' => Logger::DEBUG,
                ],
            ])
            ->setMethods(['createHandler'])
            ->getMock();

        $factoryMock
            ->expects($this->any())
            ->method('createHandler')
            ->will($this->returnValue($handlerMock));

        $factoryMock->createHandler();
    }
}
