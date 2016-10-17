<?php

namespace Mero\Monolog\Handler\Factory;

use Mero\Monolog\Exception\ParameterNotFoundException;
use Monolog\Handler\HipChatHandler;

class HipChatFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function checkParameters()
    {
        $this->config = array_merge(
            [
                'notify' => false,
                'nickname' => 'Monolog',
                'bubble' => true,
                'use_ssl' => true,
                'message_format' => 'text',
                'host' => 'api.hipchat.com',
                'api_version' => HipChatHandler::API_V1,
            ],
            $this->config
        );

        $parametersRequired = ['token', 'room'];
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
        return new HipChatHandler(
            $this->config['token'],
            $this->config['room'],
            $this->config['nickname'],
            $this->config['notify'],
            $this->config['level'],
            $this->config['bubble'],
            $this->config['use_ssl'],
            $this->config['message_format'],
            $this->config['host'],
            $this->config['version']
        );
    }
}
