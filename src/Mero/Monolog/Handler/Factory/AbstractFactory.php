<?php

namespace Mero\Monolog\Handler\Factory;

use Mero\Monolog\Exception\ParameterNotFoundException;
use Monolog\Handler\AbstractHandler;

abstract class AbstractFactory
{
    /**
     * @var array Configuration parameters
     */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->checkParameters();
    }

    /**
     * Check configuration parameters.
     *
     * @return bool Returns validation status
     *
     * @throws ParameterNotFoundException When required parameter not found
     */
    abstract protected function checkParameters();

    /**
     * Create a handler object.
     *
     * @return AbstractHandler Handler object
     */
    abstract public function createHandler();
}
