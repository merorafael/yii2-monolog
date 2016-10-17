<?php

namespace Mero\Monolog\Handler\Factory;

use Mero\Monolog\Exception\ParameterNotFoundException;
use Monolog\Handler\GelfHandler;

class GelfFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    protected function checkParameters()
    {
        $this->config = array_merge(
            ['bubble' => true],
            $this->config
        );

        $parametersRequired = ['publisher'];
        foreach ($parametersRequired as &$parameter) {
            if (!isset($this->config[$parameter])) {
                throw new ParameterNotFoundException(
                    sprintf("Parameter '%s' not found in handler configuration", $parameter)
                );
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function createHandler()
    {
        return new GelfHandler(
            $this->config['publisher'],
            $this->config['level'],
            $this->config['bubble']
        );
    }
}
