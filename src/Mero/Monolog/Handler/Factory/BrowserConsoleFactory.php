<?php

namespace Mero\Monolog\Handler\Factory;

use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Logger;

class BrowserConsoleFactory extends AbstractFactory
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

        return;
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
