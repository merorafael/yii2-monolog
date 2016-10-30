<?php

namespace Mero\Monolog\Handler;

use Monolog\Formatter\NormalizerFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use yii\mongodb\Collection;
use yii\mongodb\Connection;
use Monolog\Logger;

/**
 * Logs to a Yii2 MongoDB connection.
 *
 * @author Rafael Mello <merorafael@gmail.com>
 */
class YiiMongoHandler extends AbstractProcessingHandler
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * YiiMongoHandler constructor.
     *
     * @param Connection $db         Yii2 mongodb connection
     * @param bool       $collection Name of log collection
     * @param int        $level      The minimum logging level at which this handler will be triggered
     * @param bool       $bubble     Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct($db, $collection, $level = Logger::DEBUG, $bubble = true)
    {
        if (!($db instanceof Connection)) {
            throw new \InvalidArgumentException('\yii\mongodb\Connection instance required');
        }

        $this->collection = $db->getCollection($collection);
        parent::__construct($level, $bubble);
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        $this->collection->insert($record['formatted']);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultFormatter()
    {
        return new NormalizerFormatter();
    }
}
