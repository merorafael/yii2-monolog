<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Logger;

class HipChatFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function dataProviderParameterNotFound()
    {
        return [
            [
                [
                    'type' => 'hipchat',
                    'token' => 'XXXX',
                    'level' => Logger::DEBUG,
                ],
                [
                    'type' => 'hipchat',
                    'room' => 'XXXX',
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
        new HipChatFactory($params);
    }
}
