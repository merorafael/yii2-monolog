<?php

namespace Mero\Monolog;

use Mero\Monolog\Exception\InsufficientParametersException;
use Mero\Monolog\Exception\LoggerNotFoundException;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\StreamHandler;
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
     * @var array Loggers
     */
    protected $loggers;

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
        if (!isset($config['level'])) {
            $config['level'] = Logger::DEBUG;
        }
        $config['level'] = $this->levelToMonologConst($config['level']);
        if (!isset($config['type'])) {
            throw new InsufficientParametersException('Type not found');
        }
        switch ($config['type']) {
            case 'stream':
                if (!isset($config['path'])) {
                    throw new InsufficientParametersException('Path not found');
                }
                if (!isset($config['bubble'])) {
                    $config['bubble'] = true;
                }
                $handler = new StreamHandler($config['path'], $config['level'], $config['bubble']);

                return $handler;
            default:

                return;
        }
    }

    /**
     * Translate logger level to monolog constant value.
     *
     * @param string $level Logger level
     *
     * @return int Monolog constant value
     */
    protected function levelToMonologConst($level)
    {
        return is_int($level)
            ? $level
            : constant('Monolog\Logger::'.strtoupper($level));
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
