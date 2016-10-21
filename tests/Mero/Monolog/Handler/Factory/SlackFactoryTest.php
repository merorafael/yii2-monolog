<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Logger;

class SlackFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function dataProviderParameterNotFound()
    {
        return [
            [
                [
                    'type' => 'slack',
                    'token' => 'XXXX',
                    'level' => Logger::DEBUG,
                ],
                [
                    'type' => 'slack',
                    'channel' => 'XXXX',
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
        new SlackFactory($params);
    }
}
