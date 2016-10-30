<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Logger;

class RotatingFileFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function dataProviderParameterNotFound()
    {
        return [
            [
                [
                    'type' => 'rotating_file',
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
        new RotatingFileFactory($params);
    }

    public function testCreateHandler()
    {
        $factory = new RotatingFileFactory([
            'type' => 'rotating_file',
            'path' => 'test',
            'level' => Logger::DEBUG,
        ]);
        $handler = $factory->createHandler();
        $this->assertInstanceOf('Monolog\Handler\RotatingFileHandler', $handler);
    }
}
