<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Logger;

class YiiMongoFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function dataProviderParameterNotFound()
    {
        return [
            [
                [
                    'type' => 'yii_mongo',
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
        new YiiMongoFactory($params);
    }
}
