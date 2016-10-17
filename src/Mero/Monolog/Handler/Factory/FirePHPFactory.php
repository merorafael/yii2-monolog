<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Handler\FirePHPHandler;

class FirePHPFactory extends AbstractFactory
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
