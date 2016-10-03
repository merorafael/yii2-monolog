YiiDb Handler
----------------

`Mero\Monolog\Handler\YiiDbHandler` is responsible for storing logs in databases
using `yii\db\Connection` to communicate with the DBMS.

### Creating log table

The DatabaseHandler not have dependency related table name. You can create
more than one table if desired, assigning each to a different channel or strategy
you prefer.

**Required fields:**

- channel: VARCHAR(255)
- level: INTEGER
- message: LONGTEXT
- time: DATETIME

### Configuring handler in Monolog Component

To configure YiiDbHandler just instantiate the object in your handlers list of channel
wanted.

**Example:**

```php
return [
    //...
        'channels' => [
            'main' => [
                'handler' => [
                    new \Mero\Monolog\Handler\YiiDbHandler(
                        'table_name',
                        \Monolog\Logger::DEBUG
                    ),
                ],
                'processor' => [],
            ],
    //...
];
```
