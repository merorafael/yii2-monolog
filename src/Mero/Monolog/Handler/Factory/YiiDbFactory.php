<?php

namespace Mero\Monolog\Handler\Factory;

use Mero\Monolog\Exception\ParameterNotFoundException;
use Mero\Monolog\Handler\YiiDbHandler;
use Monolog\Logger;
use yii\di\Instance;

class YiiDbFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function checkParameters()
    {
        $this->config = array_merge(
            [
                'level' => Logger::DEBUG,
                'bubble' => true,
                'table' => 'logs',
            ],
            $this->config
        );

        $parametersRequired = ['reference'];
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
        $dbInstance = Instance::ensure($this->config['reference'], '\yii\db\Connection');

        return new YiiDbHandler(
            $dbInstance,
            $this->config['table'],
            $this->config['level'],
            $this->config['bubble']
        );
    }
}
