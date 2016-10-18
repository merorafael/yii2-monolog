YiiMongoHandler
===============

Handler to write records in MongoDB via a [Yii 2 MongoDB](https://github.com/yiisoft/yii2-mongodb) 
connection.

Configuring handler in Monolog Component
----------------------------------------

### Setting per array

To configure `YiiMongoHandler` per array is necessary to declare an array informing the connection name
with the base and which collection will be used.

**Array structure:**

| Key          | Description                                                          | Type       | Required | Default value |
| ------------ | -------------------------------------------------------------------- | ---------- | -------- | ------------- |
| `type`       | Handler identifier(`yii_mongo`)                                      | string     | Yes      |               |
| `reference`  | Yii2 MongoDB connection name                                         | string     | Yes      |               |
| `collection` | Collection name in MongoDB                                           | string     | No       | logs          |
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
                        'type' => 'yii_mongo',
                        'reference' => 'mongodb',
                        'collection' => 'collection_name',
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

To configure `YiiMongoHandler` object by simply instantiate the object in your handlers list of channel
wanted.

**Example:**

```php
return [
    //...
        'channels' => [
            'main' => [
                'handler' => [
                    new \Mero\Monolog\Handler\YiiMongoHandler(
                        Yii::$app->mongodb,
                        'collection_name',
                        \Monolog\Logger::DEBUG
                    ),
                ],
                'processor' => [],
            ],
    //...
];
```
