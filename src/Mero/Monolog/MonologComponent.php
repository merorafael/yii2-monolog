<?php

namespace Mero\Monolog;

use Mero\Monolog\Exception\HandlerNotFoundException;
use Mero\Monolog\Exception\LoggerNotFoundException;
use Mero\Monolog\Handler\Strategy;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractHandler;
use yii\base\Component;
use Monolog\Logger;

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

    /**
     * @var Strategy Handler strategy to create factory
     */
    protected $strategy;

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
        $this->strategy = new Strategy();
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
     * @param string $name   Logger channel name
     * @param array  $config Logger channel configuration
     *
     * @throws \InvalidArgumentException When the channel already exists
     * @throws HandlerNotFoundException  When a handler configuration is invalid
     */
    public function createChannel($name, array $config)
    {
        $handlers = [];
        $processors = [];
        if (!empty($config['handler']) && is_array($config['handler'])) {
            foreach ($config['handler'] as $handler) {
                if (!is_array($handler) && !$handler instanceof AbstractHandler) {
                    throw new HandlerNotFoundException();
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
        $this->openChannel($name, $handlers, $processors);

        return;
    }

    /**
     * Open a new logger channel.
     *
     * @param string $name       Logger channel name
     * @param array  $handlers   Handlers collection
     * @param array  $processors Processors collection
     */
    protected function openChannel($name, array $handlers, array $processors)
    {
        if (isset($this->channels[$name]) && $this->channels[$name] instanceof Logger) {
            throw new \InvalidArgumentException("Channel '{$name}' already exists");
        }

        $this->channels[$name] = new Logger($name, $handlers, $processors);

        return;
    }

    /**
     * Close a open logger channel.
     *
     * @param string $name Logger channel name
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
     */
    protected function createHandlerInstance(array $config)
    {
        $factory = $this->strategy->createFactory($config);

        return $factory->createHandler();
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
