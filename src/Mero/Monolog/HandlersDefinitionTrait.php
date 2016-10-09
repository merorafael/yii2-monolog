<?php

namespace Mero\Monolog;

use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Handler\ChromePHPHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\GelfHandler;
use Monolog\Handler\HipChatHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Mero\Monolog\Handler\YiiDbHandler;
use Mero\Monolog\Handler\YiiMongoHandler;

use yii\di\Instance;

/**
 * This trait contains definition for the following handlers:
 * - Amqp (not implemented)
 * - Browser Console
 * - Buffer (not implemented)
 * - Chrome PHP
 * - Cube (not implemented)
 * - Debug (not implemented)
 * - Deduplication (not implemented)
 * - Elasticsearch (not implemented)
 * - Error Log (not implemented)
 * - Filter (not implemented)
 * - Fingers Crossed (not implemented)
 * - FirePHP
 * - Flowdock (not implemented)
 * - Gelf
 * - Group (not implemented)
 * - HipChat
 * - Logentries (not implemented)
 * - Loggly (not implemented)
 * - Newrelic (not implemented)
 * - Null (not implemented)
 * - Pushover (not implemented)
 * - Raven (not implemented)
 * - Rollbar (not implemented)
 * - Rotating File
 * - Slack (not implemented)
 * - Socket (not implemented)
 * - Stream
 * - Swift Mailer (not implemented)
 * - Syslog (not implemented)
 * - Syslogudp (not implemented)
 * - Test (not implemented)
 * - Whatfailuregroup (not implemented)
 * - Yii Db
 * - Yii Mongo
 */
trait HandlersDefinitionTrait
{
    /**
     * Returns an array with basic settings.
     *
     * @return array
     */
    public function getDefaultArguments()
    {
        return ['bubble' => true];
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createAmqp($config)
    {
        throw BadMethodCallException('Amqp is not implemented.');
    }

    /**
     * @param  array $config
     * @return BrowserConsoleHandler
     */
    public function createBrowserConsoleHandler($config)
    {
        $config = array_merge($this->getDefaultArguments(), $config);
        return new BrowserConsoleHandler($config['level'], $config['bubble']);
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createBuffer($config)
    {
        throw BadMethodCallException('Buffer is not implemented.');
    }

    /**
     * @param  array $config
     * @return ChromePHPHandler
     */
    public function createChromePHPHandler($config)
    {
        $config = array_merge($this->getDefaultArguments(), $config);
        return new ChromePHPHandler($config['level'], $config['bubble']);
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createCube($config)
    {
        throw BadMethodCallException('Cube is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createDebug($config)
    {
        throw BadMethodCallException('Debug is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createDeduplication($config)
    {
        throw BadMethodCallException('Deduplication is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createElasticsearch($config)
    {
        throw BadMethodCallException('Elasticsearch is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createErrorLog($config)
    {
        throw BadMethodCallException('Error Log is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createFilter($config)
    {
        throw BadMethodCallException('Filter is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createFingersCrossed($config)
    {
        throw BadMethodCallException('Fingers Crossed is not implemented.');
    }

    /**
     * @param  array $config
     * @return FirePHPHandler
     */
    public function createFirePHPHandler($config)
    {
        $config = array_merge($this->getDefaultArguments(), $config);
        return new FirePHPHandler($config['level'], $config['bubble']);
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createFlowdock($config)
    {
        throw BadMethodCallException('Flowdock is not implemented.');
    }

    /**
     * @param  array $config
     * @throws InsufficientParametersException
     * @return GelfHandler
     */
    public function createGelfHandler($config)
    {
        if (!isset($config['publisher'])) {
            throw new InsufficientParametersException("Gelf config 'publisher' has not been set");
        }

        $config = array_merge($this->getDefaultArguments(), $config);
        return new GelfHandler($config['publisher'], $config['level'], $config['bubble']);
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createGroup($config)
    {
        throw BadMethodCallException('Group is not implemented.');
    }

    /**
     * @param  array $config
     * @throws InsufficientParametersException
     * @return HipChatHandler
     */
    public function createHipChatHandler($config)
    {
        if (!isset($config['token'])) {
            throw new InsufficientParametersException("Hipchat config 'token' has not been set");
        }

        if (!isset($config['room'])) {
            throw new InsufficientParametersException("Hipchat config 'room' has not been set");
        }

        $config = array_merge(
            $this->getDefaultArguments(),
            [
                'notify' => false,
                'nickname' => 'Monolog',
                'use_ssl' => true,
                'message_format' => 'text',
                'host' => 'api.hipchat.com',
                'api_version' => HipChatHandler::API_V1,
            ],
            $config
        );

        return new HipChatHandler(
            $config['token'],
            $config['room'],
            $config['nickname'],
            $config['notify'],
            $config['level'],
            $config['bubble'],
            $config['use_ssl'],
            $config['message_format'],
            $config['host'],
            $config['version']
        );
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createLogentries($config)
    {
        throw BadMethodCallException('Logentries is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createLoggly($config)
    {
        throw BadMethodCallException('Loggly is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createNewrelic($config)
    {
        throw BadMethodCallException('Newrelic is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createNull($config)
    {
        throw BadMethodCallException('Null is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createPushover($config)
    {
        throw BadMethodCallException('Pushover is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createRaven($config)
    {
        throw BadMethodCallException('Raven is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createRollbar($config)
    {
        throw BadMethodCallException('Rollbar is not implemented.');
    }

    /**
     * @param  array $config
     * @throws InsufficientParametersException
     * @return RotatingFileHandler
     */
    public function createRotatingFileHandler($config)
    {
        if (!isset($config['path'])) {
            throw new InsufficientParametersException("Rotating file config 'path' has not been set");
        }

        $config = array_merge(
            $this->getDefaultArguments(),
            [
                'max_files' => 0,
                'file_permission' => null,
                'filename_format' => '{filename}-{date}',
                'date_format' => 'Y-m-d',
            ],
            $config
        );

        $handler = new RotatingFileHandler(
            Yii::getAlias($config['path']),
            $config['max_files'],
            $config['level'],
            $config['bubble'],
            $config['file_permission']
        );

        $handler->setFilenameFormat(
            $config['filename_format'],
            $config['date_format']
        );

        return $handler;
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createSlack($config)
    {
        throw BadMethodCallException('Slack is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createSocket($config)
    {
        throw BadMethodCallException('Socket is not implemented.');
    }

    /**
     * @param  array $config
     * @throws InsufficientParametersException
     * @return StreamHandler
     */
    public function createStreamHandler($config)
    {
        if (!isset($config['path'])) {
            throw new InsufficientParametersException("Stream config 'path' has not been set");
        }

        $config = array_merge($this->getDefaultArguments(), $config);
        return new StreamHandler(Yii::getAlias(
            $config['path']),
            $config['level'],
            $config['bubble']
        );
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createSwiftMailer($config)
    {
        throw BadMethodCallException('Swift Mailer is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createSyslog($config)
    {
        throw BadMethodCallException('Syslog is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createSyslogudp($config)
    {
        throw BadMethodCallException('Syslogudp is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createTest($config)
    {
        throw BadMethodCallException('Test is not implemented.');
    }

    /**
     * @param  array $config
     * @throws BadMethodCallException
     */
    public function createWhatfailuregroup($config)
    {
        throw BadMethodCallException('Whatfailuregroup is not implemented.');
    }

    /**
     * @param  array $config
     * @return YiiDbHandler
     */
    public function createYiiDbHandler($config)
    {
        if (!isset($config['reference'])) {
            throw new InsufficientParametersException("Database config 'reference' has not been set");
        }

        $dbInstance = Instance::ensure(
            $config['reference'],
            '\yii\db\Connection'
        );

        $config = array_merge(
            $this->getDefaultArguments(),
            ['table' => 'logs'],
            $config
        );

        return new YiiDbHandler(
            $dbInstance,
            $config['table'],
            $config['level'],
            $config['bubble']
        );
    }

    /**
     * @param  array $config
     * @throws InsufficientParametersException
     * @return YiiMongoHandler
     */
    public function createYiiMongoHandler($config)
    {
        if (!isset($config['reference'])) {
            throw new InsufficientParametersException("Mongo config 'reference' has not been set");
        }

        $mongoInstance = Instance::ensure(
            $config['reference'],
            '\yii\mongodb\Connection'
        );

        $config = array_merge(
            $this->getDefaultArguments(),
            ['collection' => 'logs'],
            $config
        );

        return new YiiMongoHandler(
            $mongoInstance,
            $config['collection'],
            $config['level'],
            $config['bubble']
        );
    }
}
