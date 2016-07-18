<?php

namespace Mero\Monolog;

use Mero\Monolog\Exception\InsufficientParametersException;
use Mero\Monolog\Exception\LoggerNotFoundException;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\StreamHandler;
use yii\base\Component;
use Monolog\Logger;

class MonologComponent extends Component
{

    /**
     * @var array Loggers
     */
    private $loggers;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        if (!isset($this->loggers['main'])) {
            throw new LoggerNotFoundException(sprintf("Logger instance '%s' not found", 'main'));
        }
        foreach ($this->loggers as $name => &$logger) {
            $handlers = [];
            $processors = [];
            if (!empty($logger['handler']) && is_array($logger['handler'])) {
                foreach ($logger['handler'] as &$handlerConfig) {
                    $handler = $this->createHandlerInstance($handlerConfig);
                    if ($handlerConfig['formatter'] instanceof FormatterInterface) {
                        $handler->setFormatter($handlerConfig['formatter']);
                    }
                    $handlers[] = $handler;
                }
            }
            if (!empty($logger['processor']) && is_array($logger['processor'])) {
                $processors = $logger['processor'];
            }
            $logger = new Logger($name, $handlers, $processors);
        }
    }

    private function createHandlerInstance($config)
    {
        switch ($config['type']) {
            case StreamHandler::class:
                if (!isset($config['path']) && !isset($config['level'])) {
                    throw new InsufficientParametersException();
                }
                $handler = new StreamHandler($config['path'], $config['level']);

                return $handler;
        }

        return;
    }

    public function getLogger($name = 'main')
    {
        if (!isset($this->loggers[$name])) {
            throw new LoggerNotFoundException(sprintf("Logger instance '%s' not found", $name));
        }

        return $this->loggers[$name];
    }

    public function hasLogger($name)
    {
        return isset($this->loggers[$name]) && ($this->loggers[$name] instanceof Logger);
    }

}
