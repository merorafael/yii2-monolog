<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Handler\FirePHPHandler;
use Monolog\Logger;

class FirePHPFactory extends AbstractFactory
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
    }

    /**
     * {@inheritdoc}
     */
    public function createHandler()
    {
        return new FirePHPHandler(
            $this->config['level'],
            $this->config['bubble']
        );
    }
}
