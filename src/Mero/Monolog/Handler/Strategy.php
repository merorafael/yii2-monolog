<?php

namespace Mero\Monolog\Handler;

use Mero\Monolog\Exception\HandlerNotFoundException;
use Mero\Monolog\Exception\ParameterNotFoundException;
use Mero\Monolog\Handler\Factory\AbstractFactory;
use Mero\Monolog\Handler\Factory\BrowserConsoleFactory;
use Mero\Monolog\Handler\Factory\ChromePHPFactory;
use Mero\Monolog\Handler\Factory\FirePHPFactory;
use Mero\Monolog\Handler\Factory\GelfFactory;
use Mero\Monolog\Handler\Factory\HipChatFactory;
use Mero\Monolog\Handler\Factory\RotatingFileFactory;
use Mero\Monolog\Handler\Factory\SlackFactory;
use Mero\Monolog\Handler\Factory\StreamFactory;
use Mero\Monolog\Handler\Factory\YiiDbFactory;
use Mero\Monolog\Handler\Factory\YiiMongoFactory;
use Monolog\Logger;

class Strategy
{
    /**
     * @var array Handler factory collection
     */
    protected $factories;

    public function __construct()
    {
        $this->factories = [
            'stream' => StreamFactory::class,
            'firephp' => FirePHPFactory::class,
            'browser_console' => BrowserConsoleFactory::class,
            'gelf' => GelfFactory::class,
            'chromephp' => ChromePHPFactory::class,
            'rotating_file' => RotatingFileFactory::class,
            'yii_db' => YiiDbFactory::class,
            'yii_mongo' => YiiMongoFactory::class,
            'hipchat' => HipChatFactory::class,
            'slack' => SlackFactory::class,
            'elasticsearch' => '',
            'fingers_crossed' => '',
            'filter' => '',
            'buffer' => '',
            'deduplication' => '',
            'group' => '',
            'whatfailuregroup' => '',
            'syslog' => '',
            'syslogudp' => '',
            'swift_mailer' => '',
            'socket' => '',
            'pushover' => '',
            'raven' => '',
            'newrelic' => '',
            'cube' => '',
            'amqp' => '',
            'error_log' => '',
            'null' => '',
            'test' => '',
            'debug' => '',
            'loggly' => '',
            'logentries' => '',
            'flowdock' => '',
            'rollbar' => '',
        ];
    }

    /**
     * Verifies that the factory class exists.
     *
     * @param string $type Name of type
     *
     * @return bool
     *
     * @throws HandlerNotFoundException When handler factory not found
     * @throws \BadMethodCallException  When handler not implemented
     */
    protected function hasFactory($type)
    {
        if (!array_key_exists($type, $this->factories)) {
            throw new HandlerNotFoundException(
                sprintf("Type '%s' not found in handler factory", $type)
            );
        }
        $factoryClass = &$this->factories[$type];
        if (!class_exists($factoryClass)) {
            throw new \BadMethodCallException(
                sprintf("Type '%s' not implemented", $type)
            );
        }

        return true;
    }

    /**
     * Create a factory object.
     *
     * @param array $config Configuration parameters
     *
     * @return AbstractFactory Factory object
     *
     * @throws ParameterNotFoundException When required parameter not found
     */
    public function createFactory(array $config)
    {
        if (!array_key_exists('type', $config)) {
            throw new ParameterNotFoundException(
                sprintf("Parameter '%s' not found in handler configuration", 'type')
            );
        }
        $this->hasFactory($config['type']);
        $config['level'] = !isset($config['level'])
            ? Logger::DEBUG
            : Logger::toMonologLevel($config['level']);

        $factoryClass = &$this->factories[$config['type']];

        return new $factoryClass($config);
    }
}
