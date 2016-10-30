<?php

namespace Mero\Monolog\Handler\Factory;

use Mero\Monolog\Exception\ParameterNotFoundException;
use Mero\Monolog\Handler\YiiMongoHandler;
use Monolog\Logger;
use yii\base\InvalidConfigException;
use yii\di\Instance;
use yii\mongodb\Connection;

class YiiMongoFactory extends AbstractFactory
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

        return;
    }

    /**
     * Return a Yii2 database connection.
     *
     * @param string $reference Name of Yii2 database connection
     *
     * @return Connection
     *
     * @throws InvalidConfigException When the reference is invalid
     */
    protected function getYiiConnection($reference)
    {
        return Instance::ensure($reference, Connection::className());
    }

    /**
     * {@inheritdoc}
     */
    public function createHandler()
    {
        return new YiiMongoHandler(
            $this->getYiiConnection($this->config['reference']),
            $this->config['collection'],
            $this->config['level'],
            $this->config['bubble']
        );
    }
}
