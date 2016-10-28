<?php

namespace Mero\Monolog\Handler\Factory;

use Mero\Monolog\Exception\ParameterNotFoundException;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class StreamFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    protected function checkParameters()
    {
        $this->config = array_merge(
            [
                'level' => Logger::DEBUG,
                'bubble' => true,
            ],
            $this->config
        );

        $parametersRequired = ['path'];
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
        if (class_exists('\Yii')) {
            $this->config['path'] = \Yii::getAlias($this->config['path']);
        }

        return new StreamHandler(
            $this->config['path'],
            $this->config['level'],
            $this->config['bubble']
        );
    }
}
