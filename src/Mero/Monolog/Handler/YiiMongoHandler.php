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
     * @inheritDoc
     */
    public function __construct(Connection $db, $collection, $level = Logger::ERROR, $bubble = true)
    {
        $this->collection = $db->getCollection($collection);
        parent::__construct($level, $bubble);
    }

    /**
     * @inheritDoc
     */
    protected function write(array $record)
    {
        $this->collection->insert($record["formatted"]);
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultFormatter()
    {
        return new NormalizerFormatter();
    }

}
