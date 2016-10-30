<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Logger;

class StreamFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function dataProviderParameterNotFound()
    {
        return [
            [
                [
                    'type' => 'stream',
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
        new StreamFactory($params);
    }

    public function testCreateHandler()
    {
        $factory = new StreamFactory([
            'type' => 'stream',
            'path' => 'test',
            'level' => Logger::DEBUG,
        ]);
        $handler = $factory->createHandler();
        $this->assertInstanceOf('Monolog\Handler\StreamHandler', $handler);
    }
}

if (!class_exists(__NAMESPACE__.'\Yii')) {
    class Yii
    {
        public static function getAlias($alias)
        {
            return $alias;
        }
    }
}
