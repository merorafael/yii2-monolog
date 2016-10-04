<?php

namespace Mero\Monolog\Handler;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use yii\db\Connection;

/**
 * Logs to a Yii2 database connection.
 *
 * @author Rafael Mello <merorafael@gmail.com>
 */
class YiiDbHandler extends AbstractProcessingHandler
{
    /**
     * @var Connection Yii2 database connection
     */
    protected $db;

    /**
     * @var string Log table in database
     */
    protected $table;

    public function __construct($db, $table = 'logs', $level = Logger::ERROR, $bubble = true)
    {
        if (!($db instanceof Connection)) {
            throw new \InvalidArgumentException('\yii\db\Connection instance required');
        }

        $this->db = $db;
        $this->table = $table;
        parent::__construct($level, $bubble);
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        $this->db->quoteTableName($this->table);
        $this->db
            ->createCommand()
            ->insert(
                $this->table,
                [
                    'channel' => $record['channel'],
                    'level' => $record['level'],
                    'message' => $record['message'],
                    'time' => $record['datetime']->format('Y-m-d H:i:s'),
                ]
            )
            ->execute();
    }
}
