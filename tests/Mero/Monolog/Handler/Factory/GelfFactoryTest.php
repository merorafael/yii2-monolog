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

    protected function getMessagePublisher()
    {
        return $this->getMock('Gelf\Publisher', array('publish'), array(), '', false);
    }

    public function testCreateHandler()
    {
        $factory = new GelfFactory([
            'type' => 'gelf',
            'publisher' => $this->getMessagePublisher(),
            'level' => Logger::DEBUG,
        ]);
        $handler = $factory->createHandler();
        $this->assertInstanceOf('Monolog\Handler\GelfHandler', $handler);
    }
}
