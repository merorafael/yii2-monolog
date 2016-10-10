<?php

namespace Mero\Monolog;

use Mero\Monolog\Exception\InsufficientParametersException;
use Mero\Monolog\Exception\InvalidHandlerException;
use Mero\Monolog\Exception\LoggerNotFoundException;
use Mero\Monolog\Handler\YiiDbHandler;
use Mero\Monolog\Handler\YiiMongoHandler;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractHandler;
use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Handler\ChromePHPHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\GelfHandler;
use Monolog\Handler\HipChatHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use yii\base\Component;
use Monolog\Logger;
use yii\di\Instance;

/**
 * MonologComponent is an component for the Monolog library.
 *
 * @author Rafael Mello <merorafael@gmail.com>
 */
class MonologComponent extends Component
{
    /**
     * @var array Logger channels
     */
    protected $channels;

    public function __construct(array $channels = [], array $config = [])
    {
        if (!isset($channels['main'])) {
            $channel['main'] = [
                'handler' => [
                    [
                        'type' => 'rotating_file',
                        'path' => '@app/runtime/logs/log_'.date('Y-m-d').'.log',
                    ],
                ],
            ];
        }
        $this->channels = $channels;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        foreach ($this->channels as $name => $config) {
            $this->createChannel($name, $config);
        }
        parent::init();
    }

    /**
     * Create a logger channel.
     *
     * @param string $name   Channel name
     * @param array  $config Channel configuration
     *
     * @throws \InvalidArgumentException When the channel already exists
     * @throws InvalidHandlerException   When a handler configuration is invalid
     */
    public function createChannel($name, array $config)
    {
        if (isset($this->channels[$name]) && $this->channels[$name] instanceof Logger) {
            throw new \InvalidArgumentException("Channel '{$name}' already exists");
        }
        $handlers = [];
        $processors = [];
        if (!empty($config['handler']) && is_array($config['handler'])) {
            foreach ($config['handler'] as $handler) {
                if (!is_array($handler) && !$handler instanceof AbstractHandler) {
                    throw new InvalidHandlerException();
                }
                if (is_array($handler)) {
                    $handlerObject = $this->createHandlerInstance($handler);
                    if (array_key_exists('formatter', $handler) &&
                        $handler['formatter'] instanceof FormatterInterface
                    ) {
                        $handlerObject->setFormatter($handler['formatter']);
                    }
                } else {
                    $handlerObject = $handler;
                }
                $handlers[] = $handlerObject;
            }
        }
        if (!empty($config['processor']) && is_array($config['processor'])) {
            $processors = $config['processor'];
        }
        $this->channels[$name] = new Logger($name, $handlers, $processors);

        return;
    }

    /**
     * Close a open channel.
     *
     * @param string $name Channel name
     */
    public function closeChannel($name)
    {
        if (isset($this->channels[$name])) {
            unset($this->channels[$name]);
        }

        return;
    }

    /**
     * Create handler instance.
     *
     * @param array $config Configuration parameters
     *
     * @return AbstractHandler
     *
     * @throws InsufficientParametersException
     */
    protected function createHandlerInstance(array $config)
    {
        if (!isset($config['type'])) {
            throw new InsufficientParametersException('Type not found');
        }
        $config['level'] = !isset($config['level'])
            ? Logger::DEBUG
            : Logger::toMonologLevel($config['level']);
        switch ($config['type']) {
            case 'stream':
                if (!isset($config['path'])) {
                    throw new InsufficientParametersException("Stream config 'path' has not been set");
                }
                $config = array_merge(
                    ['bubble' => true],
                    $config
                );

                return new StreamHandler(\Yii::getAlias($config['path']), $config['level'], $config['bubble']);
            case 'firephp':
                $config = array_merge(
                    ['bubble' => true],
                    $config
                );

                return new FirePHPHandler($config['level'], $config['bubble']);
            case 'browser_console':
                $config = array_merge(
                    ['bubble' => true],
                    $config
                );

                return new BrowserConsoleHandler($config['level'], $config['bubble']);
            case 'gelf':
                if (!isset($config['publisher'])) {
                    throw new InsufficientParametersException("Gelf config 'publisher' has not been set");
                }
                $config = array_merge(
                    ['bubble' => true],
                    $config
                );

                return new GelfHandler($config['publisher'], $config['level'], $config['bubble']);
            case 'chromephp':
                $config = array_merge(
                    ['bubble' => true],
                    $config
                );

                return new ChromePHPHandler($config['level'], $config['bubble']);
            case 'rotating_file':
                if (!isset($config['path'])) {
                    throw new InsufficientParametersException("Rotating file config 'path' has not been set");
                }
                $config = array_merge(
                    [
                        'bubble' => true,
                        'max_files' => 0,
                        'file_permission' => null,
                        'filename_format' => '{filename}-{date}',
                        'date_format' => 'Y-m-d',
                    ],
                    $config
                );
                $handler = new RotatingFileHandler(
                    \Yii::getAlias($config['path']),
                    $config['max_files'],
                    $config['level'],
                    $config['bubble'],
                    $config['file_permission']
                );
                $handler->setFilenameFormat($config['filename_format'], $config['date_format']);

                return $handler;
            case 'yii_db':
                if (!isset($config['reference'])) {
                    throw new InsufficientParametersException("Database config 'reference' has not been set");
                }
                $dbInstance = Instance::ensure($config['reference'], '\yii\db\Connection');
                $config = array_merge(
                    [
                        'bubble' => true,
                        'table' => 'logs',
                    ],
                    $config
                );

                return new YiiDbHandler(
                    $dbInstance,
                    $config['table'],
                    $config['level'],
                    $config['bubble']
                );
            case 'yii_mongo':
                if (!isset($config['reference'])) {
                    throw new InsufficientParametersException("Mongo config 'reference' has not been set");
                }
                $mongoInstance = Instance::ensure($config['reference'], '\yii\mongodb\Connection');
                $config = array_merge(
                    [
                        'bubble' => true,
                        'collection' => 'logs',
                    ],
                    $config
                );

                return new YiiMongoHandler(
                    $mongoInstance,
                    $config['collection'],
                    $config['level'],
                    $config['bubble']
                );
            case 'hipchat':
                if (!isset($config['token'])) {
                    throw new InsufficientParametersException("Hipchat config 'token' has not been set");
                }
                if (!isset($config['room'])) {
                    throw new InsufficientParametersException("Hipchat config 'token' has not been set");
                }
                $config = array_merge(
                    [
                        'notify' => false,
                        'nickname' => 'Monolog',
                        'bubble' => true,
                        'use_ssl' => true,
                        'message_format' => 'text',
                        'host' => 'api.hipchat.com',
                        'api_version' => HipChatHandler::API_V1,
                    ],
                    $config
                );

                return new HipChatHandler(
                    $config['token'],
                    $config['room'],
                    $config['nickname'],
                    $config['notify'],
                    $config['level'],
                    $config['bubble'],
                    $config['use_ssl'],
                    $config['message_format'],
                    $config['host'],
                    $config['version']
                );
            case 'elasticsearch':
            case 'fingers_crossed':
            case 'filter':
            case 'buffer':
            case 'deduplication':
            case 'group':
            case 'whatfailuregroup':
            case 'syslog':
            case 'syslogudp':
            case 'swift_mailer':
            case 'socket':
            case 'pushover':
            case 'raven':
            case 'newrelic':
            case 'slack':
            case 'cube':
            case 'amqp':
            case 'error_log':
            case 'null':
            case 'test':
            case 'debug':
            case 'loggly':
            case 'logentries':
            case 'flowdock':
            case 'rollbar':

                return;
        }
    }

    /**
     * Checks if the given logger exists.
     *
     * @param string $name Logger name
     *
     * @return bool
     */
    public function hasLogger($name)
    {
        return isset($this->channels[$name]) && ($this->channels[$name] instanceof Logger);
    }

    /**
     * Return logger object.
     *
     * @param string $name Logger name
     *
     * @return Logger Logger object
     *
     * @throws LoggerNotFoundException
     */
    public function getLogger($name = 'main')
    {
        if (!$this->hasLogger($name)) {
            throw new LoggerNotFoundException(sprintf("Logger instance '%s' not found", $name));
        }

        return $this->channels[$name];
    }
}
