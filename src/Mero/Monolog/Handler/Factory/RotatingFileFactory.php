<?php

namespace Mero\Monolog\Handler\Factory;

use Mero\Monolog\Exception\ParameterNotFoundException;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class RotatingFileFactory extends AbstractFactory
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
                'max_files' => 0,
                'file_permission' => null,
                'filename_format' => '{filename}-{date}',
                'date_format' => 'Y-m-d',
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
    }

    /**
     * {@inheritdoc}
     */
    public function createHandler()
    {
        $handler = new RotatingFileHandler(
            Yii::getAlias($this->config['path']),
            $this->config['max_files'],
            $this->config['level'],
            $this->config['bubble'],
            $this->config['file_permission']
        );
        $handler->setFilenameFormat(
            $this->config['filename_format'],
            $this->config['date_format']
        );

        return $handler;
    }
}
