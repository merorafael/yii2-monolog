YiiDbHandler
============

Handler to write records in DBMS database via a [Yii 2 database](http://www.yiiframework.com/doc-2.0/guide-db-dao.html) 
connection.

Creating log table
------------------

The YiiDbHandler not have dependency related table name. You can create
more than one table if desired, assigning each to a different channel or strategy
you prefer.

**Required fields:**

- channel: VARCHAR(255)
- level: INTEGER
- message: LONGTEXT
- time: DATETIME

Configuring handler in MonologComponent
---------------------------------------

### Setting per array

To configure `YiiDbHandler` per array is necessary to declare an array informing the connection name
with the base and which collection will be used.

**Array structure:**

| Key          | Description                                                          | Type       | Required | Default value |
| ------------ | -------------------------------------------------------------------- | ---------- | -------- | ------------- |
| `type`       | Handler identifier(`yii_db`)                                         | string     | Yes      |               |
| `reference`  | Yii2 database connection name                                        | string     | Yes      |               |
| `table`      | Table name in database                                               | string     | No       | logs          |
| `level`      | The minimum logging level at which this handler will be triggered    | string     | No       | debug         |
| `bubble`     | Whether the messages that are handled can bubble up the stack or not | bool       | No       | true          |

**Example:**

```php
return [
    //...
        'channels' => [
            'main' => [
                'handler' => [
                    [
                        'type' => 'yii_db',
                        'reference' => 'db',
                        'table' => 'nome_tabela',
                        'level' => 'debug',
                        'bubble' => true,
                    ],
                ],
                'processor' => [],
            ],
    //...
];
```

### Setting per object

To configure `YiiDbHandler` object by simply instantiate the object in your handlers list of channel
wanted.

**Example:**

```php
return [
    //...
        'channels' => [
            'main' => [
                'handler' => [
                    new \Mero\Monolog\Handler\YiiDbHandler(
                        Yii::$app->db,
                        'nome_tabela',
                        \Monolog\Logger::DEBUG
                    ),
                ],
                'processor' => [],
            ],
    //...
];
```
