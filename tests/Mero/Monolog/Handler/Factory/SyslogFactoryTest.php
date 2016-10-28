<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Logger;

class SyslogFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function dataProviderParameterNotFound()
    {
        return [
            [
                [
                    'type' => 'syslog',
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
        new SyslogFactory($params);
    }

    public function testCreateHandler()
    {
        $factory = new SyslogFactory([
            'type' => 'syslog',
            'ident' => 'test',
            'level' => Logger::DEBUG,
        ]);
        $handler = $factory->createHandler();
        $this->assertInstanceOf('Monolog\Handler\SyslogHandler', $handler);
    }
}
