<?php

namespace Mero\Monolog\Handler;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use yii\db\Connection;
use yii\di\Instance;

/**
 * Logs to a Yii2 database connection.
 *
 * @author Rafael Mello <merorafael@gmail.com>
 */
class DatabaseHandler extends AbstractProcessingHandler
{

    /**
     * @var Connection Yii2 database connection
     */
    protected $db;

    /**
     * @var string Log table in database
     */
    protected $table;

    public function __construct($table = 'logs', $level = Logger::ERROR, $bubble = true)
    {
        $this->db = Instance::ensure($this->db, Connection::className());
        parent::__construct($level, $bubble);
    }

    /**
     * @inheritDoc
     */
    protected function write(array $record)
    {
        $this->db->quoteTableName($this->table);
        $command = $this->db->createCommand(
            "INSERT INTO $this->table (channel, level, message, time) VALUES (:channel, :level, :message, :time)"
        );
        $command
            ->bindValues([
                'channel' => $record['channel'],
                'level' => $record['level'],
                'message' => $record['message'],
                'time' => $record['datetime']->format('Y-m-d H:i:s')
            ])
            ->execute();
    }

}
