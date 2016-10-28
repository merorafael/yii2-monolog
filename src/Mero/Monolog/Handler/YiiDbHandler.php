<?php

namespace Mero\Monolog\Handler;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use yii\db\Connection;

/**
 * Logs to a Yii2 database connection.
 * Based on the MySQL Monolog Handler by waza-ari https://github.com/waza-ari/monolog-mysql
 *
 * @author Rafael Mello <merorafael@gmail.com>
 */
class YiiDbHandler extends AbstractProcessingHandler
{
    /**
     * @var bool defines whether the MySQL connection is been initialized
     */
    private $initialized = false;

    /**
     * @var Connection Yii2 database connection
     */
    protected $db;

    /**
     * @var string Log table in database
     */
    protected $table;

    /**
     * @var string[] additional fields to be stored in the database
     *
     * For each field $field, an additional context field with the name $field
     * is expected along the message, and further the database needs to have these fields
     * as the values are stored in the column name $field.
     */
    private $additionalFields = array();

    /**
     * @var Yii\db\Command command to insert a new record
     */
    private $command;

    public function __construct($db, $table = 'logs', $additionalFields = array(), $level = Logger::DEBUG, $bubble = true)
    {
        if (!($db instanceof Connection)) {
            throw new \InvalidArgumentException('\yii\db\Connection instance required');
        }

        $this->db = $db;
        $this->table = $table;
        $this->additionalFields = $additionalFields;

        parent::__construct($level, $bubble);
    }

    /**
     * Initializes this handler by creating the table if it not exists
     */
    private function initialize()
    {
        // Use VARCHAR(191) instead of VARCHAR(255) for compatibility with utf8mb4 default columns
        $this->db->createCommand(
            'CREATE TABLE IF NOT EXISTS `' . $this->table . '` ' . '(channel VARCHAR(191), level VARCHAR(191), message LONGTEXT, time INTEGER UNSIGNED)'
        )->execute();

        //Read out actual columns
        $actualFields = array();
        $table = $this->db->schema->getTableSchema($this->table);
        foreach ($table->columns as $column) {
            $actualFields[] = $column->name;
        }

        //Calculate changed entries
        $removedColumns = array_diff(
            $actualFields,
            $this->additionalFields,
            array('channel', 'level', 'message', 'time')
        );

        $addedColumns = array_diff($this->additionalFields, $actualFields);

        //Remove columns
        if (!empty($removedColumns)) {
            foreach ($removedColumns as $c) {
                $this->db->createCommand('ALTER TABLE `'.$this->table.'` DROP `'.$c.'`;')->execute();
            }
        }

        //Add columns
        if (!empty($addedColumns)) {
            foreach ($addedColumns as $c) {
                $this->db->createCommand('ALTER TABLE `'.$this->table.'` add `'.$c.'` TEXT NULL DEFAULT NULL;')->execute();
            }
        }

        $this->db->schema->refresh();

        //Prepare statement
        $columns = "";
        $fields = "";
        foreach ($this->additionalFields as $f) {
            $columns.= ", $f";
            $fields.= ", :$f";
        }

        $this->command = $this->db->createCommand(
            'INSERT INTO `' . $this->table . '` (channel, level, message, time'.$columns.')
            VALUES (:channel, :level, :message, :time' . $fields . ')'
        );

        $this->initialized = true;
    }

    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param  $record[]
     * @return void
     */
    protected function write(array $record)
    {
        if (!$this->initialized) {
            $this->initialize();
        }

        //'context' contains the array
        $contentArray = array(
            ':channel' => $record['channel'],
            ':level' => $record['level'],
            ':message' => $record['message'],
            ':time' => $record['datetime']->format('U')
        );

        // Cleaning up context to keep only accepted fields
        foreach ($this->additionalFields as $fieldName) {
            if (array_key_exists($fieldName, $record['context'])) {
                $contentArray[$fieldName] = $record['context'][$fieldName];
            }
        }

        //Fill content array with "null" values if not provided
        $contentArray = $contentArray + array_combine(
            $this->additionalFields,
            array_fill(0, count($this->additionalFields), null)
        );

        $this->command->bindValues($contentArray)->execute();
    }
}
