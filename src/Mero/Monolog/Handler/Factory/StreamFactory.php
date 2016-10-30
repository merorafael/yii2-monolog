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

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function createHandler()
    {
        return new StreamHandler(
            Yii::getAlias($this->config['path']),
            $this->config['level'],
            $this->config['bubble']
        );
    }
}
