<?php

namespace Mero\Monolog;

use Mero\Monolog\Exception\InsufficientParametersException;
use Mero\Monolog\Exception\InvalidHandlerException;
use Mero\Monolog\Exception\LoggerNotFoundException;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractHandler;
use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Handler\ChromePHPHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\GelfHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use yii\base\Component;
use Monolog\Logger;
use Yii;

/**
 * MonologComponent is an component for the Monolog library.
 *
 * @author Rafael Mello <merorafael@gmail.com>
 */
class MonologComponent extends Component
{
    /**
     * @var array Channels
     */
    public $channels;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (!isset($this->channels['main'])) {
            $this->channels['main'] = [
                'handler' => [
                    'type' => 'rotating_file',
                    'path' => '@app/runtime/logs/log_' . date('Y-m-d') . '.log',
                ],
            ];
        }
        foreach ($this->channels as $name => &$channel) {
            $handlers = [];
            $processors = [];
            if (!empty($channel['handler']) && is_array($channel['handler'])) {
                foreach ($channel['handler'] as &$handlerConfig) {
                    if (!is_array($handlerConfig) && !$handlerConfig instanceof AbstractHandler) {
                        throw new InvalidHandlerException();
                    }
                    if (is_array($handlerConfig)) {
                        $handler = $this->createHandlerInstance($handlerConfig);
                        if (array_key_exists('formatter', $handlerConfig) &&
                            $handlerConfig['formatter'] instanceof FormatterInterface
                        ) {
                            $handler->setFormatter($handlerConfig['formatter']);
                        }
                    } else {
                        $handler = $handlerConfig;
                    }
                    $handlers[] = $handler;
                }
            }
            if (!empty($channel['processor']) && is_array($channel['processor'])) {
                $processors = $channel['processor'];
            }
            $channel = new Logger($name, $handlers, $processors);
        }
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
                    throw new InsufficientParametersException();
                }
                $config = array_merge(
                    ['bubble' => true],
                    $config
                );

                return new StreamHandler(Yii::getAlias($config['path']), $config['level'], $config['bubble']);
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
                    throw new InsufficientParametersException();
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
                    throw new InsufficientParametersException();
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
                    Yii::getAlias($config['path']),
                    $config['max_files'],
                    $config['level'],
                    $config['bubble'],
                    $config['file_permission']
                );
                $handler->setFilenameFormat($config['filename_format'], $config['date_format']);

                return $handler;
            case 'mongo':
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
            case 'native_mailer':
            case 'socket':
            case 'pushover':
            case 'raven':
            case 'newrelic':
            case 'hipchat':
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
