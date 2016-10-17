<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Handler\ChromePHPHandler;

class ChromePHPFactory extends AbstractFactory
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
        return new ChromePHPHandler(
            $this->config['level'],
            $this->config['bubble']
        );
    }
}
