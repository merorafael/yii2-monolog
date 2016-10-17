<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Handler\BrowserConsoleHandler;

class BrowserConsoleFactory extends AbstractFactory
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
        return new BrowserConsoleHandler(
            $this->config['level'],
            $this->config['bubble']
        );
    }
}
