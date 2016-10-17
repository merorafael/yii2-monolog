<?php

namespace Mero\Monolog\Handler\Factory;

use Mero\Monolog\Exception\ParameterNotFoundException;
use Mero\Monolog\Handler\YiiMongoHandler;
use yii\di\Instance;

class YiiMongoFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function checkParameters()
    {
        $this->config = array_merge(
            [
                'bubble' => true,
                'collection' => 'logs',
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

        return new YiiMongoHandler(
            $dbInstance,
            $this->config['collection'],
            $this->config['level'],
            $this->config['bubble']
        );
    }
}
