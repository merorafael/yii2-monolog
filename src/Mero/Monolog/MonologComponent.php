<?php

namespace Mero\Monolog;

use Mero\Monolog\Exception\InsufficientParametersException;
use Mero\Monolog\Exception\InvalidHandlerException;
use Mero\Monolog\Exception\LoggerNotFoundException;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractHandler;
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
    use HandlersDefinitionTrait;

    /**
     * @var array Channels
     */
    protected $channels;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        this->createDefaultChannels();
        this->parseChannels();
    }

    /**
     *
     */
    protected function createDefaultChannels()
    {
        if (isset($this->channels['main'])) {
            return;
        }

        $this->channels['main'] = [
            'handler' => [
                'type' => 'rotating_file',
                'path' => '@app/runtime/logs/' . this->getLogName(),
            ],
        ];
    }

    /**
     * @return string
     */
    protected function getLogName()
    {
        return 'log_' . date('Y-m-d') . '.log';
    }

    /**
     *
     */
    protected function parseChannels()
    {
        foreach ($this->channels as $name => $channel) {
            $this->channels[$name] = new Logger(
                $name,
                $this->getHandlers($channel),
                $this->getProcessors($channel)
            );
        }
    }

    /**
     * @param  array $channel
     * @return array
     */
    protected function getHandlers($channel)
    {
        $handlers = [];
        if (empty($channel['handler']) || !is_array($channel['handler'])) {
            return $handlers;
        }

        foreach ($channel['handler'] as $handlerConfig) {
            $handlers[] = $this->getHandler($handlerConfig);
        }

        return $handlers;
    }

    /**
     * @param  array $config
     * @throws InvalidHandlerException
     * @return AbstractHandler
     */
    protected function getHandlerConfig($config)
    {
        if (!is_array($handlerConfig) && !$handlerConfig instanceof AbstractHandler) {
            throw new InvalidHandlerException();
        }

        if (!is_array($handlerConfig)) {
            return $handlerConfig;
        }

        $handler = $this->createHandlerInstance($handlerConfig);
        if ($handlerConfig['formatter'] instanceof FormatterInterface) {
            $handler->setFormatter($handlerConfig['formatter']);
        }

        return $handler;
    }

    /**
     * @param  array $channel
     * @return array
     */
    protected function getProcessors($channel)
    {
        $processors = [];
        if (empty($channel['processor']) || !is_array($channel['processor'])) {
            return $processors;
        }

        $processors = $channel['processor'];
        return $processors;
    }

    /**
     * Create handler instance.
     *
     * @param array $config Configuration parameters
     * @throws InsufficientParametersException
     * @return AbstractHandler
     */
    protected function createHandlerInstance(array $config)
    {
        if (!isset($config['type'])) {
            throw new InsufficientParametersException('Type not found');
        }

        $config['level'] = $this->getConfigLevel($config);
        if ($config['type'] == 'stream') {
            return $this->createStreamHandler($config);
        }

        if ($config['type'] == 'firephp') {
            return $this->createFirePHPHandler($config);
        }

        if ($config['type'] == 'browser_console') {
            return $this->createBrowserConsoleHandler($config);
        }

        if ($config['type'] == 'gelf') {
            return $this->createGelfHandler($config);
        }

        if ($config['type'] == 'chromephp') {
            return $this->createChromePHPHandler($config);
        }

        if ($config['type'] == 'rotating_file') {
            return $this->createRotatingFileHandler($config);
        }

        if ($config['type'] == 'yii_db') {
            return $this->createYiiDbHandler($config);
        }

        if ($config['type'] == 'yii_mongo') {
            return $this->createYiiMongoHandler($config);
        }

        if ($config['type'] == 'hipchat') {
            return $this->createHipChatHandler($config);
        }

        if ($config['type'] == 'elasticsearch') {
            return $this->createElasticsearch($config);
        }

        if ($config['type'] == 'fingers_crossed') {
            return $this->createFingersCrossed($config);
        }

        if ($config['type'] == 'filter') {
            return $this->createFilter($config);
        }

        if ($config['type'] == 'buffer') {
            return $this->createBuffer($config);
        }

        if ($config['type'] == 'deduplication') {
            return $this->createDeduplication($config);
        }

        if ($config['type'] == 'group') {
            return $this->createGroup($config);
        }

        if ($config['type'] == 'whatfailuregroup') {
            return $this->createWhatfailuregroup($config);
        }

        if ($config['type'] == 'syslog') {
            return $this->createSyslog($config);
        }

        if ($config['type'] == 'syslogudp') {
            return $this->createSyslogudp($config);
        }

        if ($config['type'] == 'swift_mailer') {
            return $this->createSwiftMailer($config);
        }

        if ($config['type'] == 'socket') {
            return $this->createSocket($config);
        }

        if ($config['type'] == 'pushover') {
            return $this->createPushover($config);
        }

        if ($config['type'] == 'raven') {
            return $this->createRaven($config);
        }

        if ($config['type'] == 'newrelic') {
            return $this->createNewrelic($config);
        }

        if ($config['type'] == 'slack') {
            return $this->createSlack($config);
        }

        if ($config['type'] == 'cube') {
            return $this->createCube($config);
        }

        if ($config['type'] == 'amqp') {
            return $this->createAmqp($config);
        }

        if ($config['type'] == 'error_log') {
            return $this->createErrorLog($config);
        }

        if ($config['type'] == 'null') {
            return $this->createNull($config);
        }

        if ($config['type'] == 'test') {
            return $this->createTest($config);
        }

        if ($config['type'] == 'debug') {
            return $this->createDebug($config);
        }

        if ($config['type'] == 'loggly') {
            return $this->createLoggly($config);
        }

        if ($config['type'] == 'logentries') {
            return $this->createLogentries($config);
        }

        if ($config['type'] == 'flowdock') {
            return $this->createFlowdock($config);
        }

        if ($config['type'] == 'rollbar') {
            return $this->createRollbar($config);
        }

        throw BadMethodCallException(sprintf("'%s' not found", $config['type']);
    }

    protected function getConfigLevel()
    {
        if (!isset($config['level'])) {
            return Logger::DEBUG;
        }

        return Logger::toMonologLevel($config['level']);
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
