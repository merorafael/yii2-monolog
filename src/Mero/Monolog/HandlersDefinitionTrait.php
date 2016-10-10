<?php

namespace Mero\Monolog;

use Mero\Monolog\Exception\InsufficientParametersException;
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
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createAmqp(array $config)
    {
        throw new \BadMethodCallException('Amqp is not implemented.');
    }

    /**
     * @param array $config
     * @return BrowserConsoleHandler
     */
    public function createBrowserConsoleHandler(array $config)
    {
        $config = array_merge($this->getDefaultArguments(), $config);
        return new BrowserConsoleHandler($config['level'], $config['bubble']);
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createBuffer(array $config)
    {
        throw new \BadMethodCallException('Buffer is not implemented.');
    }

    /**
     * @param array $config
     * @return ChromePHPHandler
     */
    public function createChromePHPHandler(array $config)
    {
        $config = array_merge($this->getDefaultArguments(), $config);
        return new ChromePHPHandler($config['level'], $config['bubble']);
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createCube(array $config)
    {
        throw new \BadMethodCallException('Cube is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createDebug(array $config)
    {
        throw new \BadMethodCallException('Debug is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createDeduplication(array $config)
    {
        throw new \BadMethodCallException('Deduplication is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createElasticsearch(array $config)
    {
        throw new \BadMethodCallException('Elasticsearch is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createErrorLog(array $config)
    {
        throw new \BadMethodCallException('Error Log is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createFilter(array $config)
    {
        throw new \BadMethodCallException('Filter is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createFingersCrossed(array $config)
    {
        throw new \BadMethodCallException('Fingers Crossed is not implemented.');
    }

    /**
     * @param array $config
     * @return FirePHPHandler
     */
    public function createFirePHPHandler(array $config)
    {
        $config = array_merge($this->getDefaultArguments(), $config);
        return new FirePHPHandler($config['level'], $config['bubble']);
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createFlowdock(array $config)
    {
        throw new \BadMethodCallException('Flowdock is not implemented.');
    }

    /**
     * @param array $config
     * @throws InsufficientParametersException
     * @return GelfHandler
     */
    public function createGelfHandler(array $config)
    {
        if (!isset($config['publisher'])) {
            throw new InsufficientParametersException("Gelf config 'publisher' has not been set");
        }

        $config = array_merge($this->getDefaultArguments(), $config);
        return new GelfHandler($config['publisher'], $config['level'], $config['bubble']);
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createGroup(array $config)
    {
        throw new \BadMethodCallException('Group is not implemented.');
    }

    /**
     * @param array $config
     * @throws InsufficientParametersException
     * @return HipChatHandler
     */
    public function createHipChatHandler(array $config)
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
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createLogentries(array $config)
    {
        throw new \BadMethodCallException('Logentries is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createLoggly(array $config)
    {
        throw new \BadMethodCallException('Loggly is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createNewrelic(array $config)
    {
        throw new \BadMethodCallException('Newrelic is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createNull(array $config)
    {
        throw new \BadMethodCallException('Null is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createPushover(array $config)
    {
        throw new \BadMethodCallException('Pushover is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createRaven(array $config)
    {
        throw new \BadMethodCallException('Raven is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createRollbar(array $config)
    {
        throw new \BadMethodCallException('Rollbar is not implemented.');
    }

    /**
     * @param array $config
     * @throws InsufficientParametersException
     * @return RotatingFileHandler
     */
    public function createRotatingFileHandler(array $config)
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
            \Yii::getAlias($config['path']),
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
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createSlack(array $config)
    {
        throw new \BadMethodCallException('Slack is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createSocket(array $config)
    {
        throw new \BadMethodCallException('Socket is not implemented.');
    }

    /**
     * @param array $config
     * @throws InsufficientParametersException
     * @return StreamHandler
     */
    public function createStreamHandler(array $config)
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
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createSwiftMailer(array $config)
    {
        throw new \BadMethodCallException('Swift Mailer is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createSyslog(array $config)
    {
        throw new \BadMethodCallException('Syslog is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createSyslogudp(array $config)
    {
        throw new \BadMethodCallException('Syslogudp is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createTest(array $config)
    {
        throw new \BadMethodCallException('Test is not implemented.');
    }

    /**
     * @param array $config
     * @throws \BadMethodCallException
     */
    public function createWhatfailuregroup(array $config)
    {
        throw new \BadMethodCallException('Whatfailuregroup is not implemented.');
    }

    /**
     * @param array $config
     * @return YiiDbHandler
     */
    public function createYiiDbHandler(array $config)
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
     * @param array $config
     * @throws InsufficientParametersException
     * @return YiiMongoHandler
     */
    public function createYiiMongoHandler(array $config)
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
