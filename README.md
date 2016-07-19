Monolog for Yii 2
=================

## Instalation

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```
php composer.phar require mero/yii2-monolog
```

or add

```
"mero/yii2-monolog": "dev-master"
```

to the require section of your composer.json.

## Configuration

```php
return [
    //....
    'components' => [
        'monolog' => [
            'class' => \Mero\Monolog\MonologComponent::class,
            'loggers' => [
                'main' => [
                    'handler' => [
                        //Handler object or array configuration
                    ],
                    'processor' => [],
                ],
            ],
        ],
    ],
    //....
];
```

#### Handler configuration using object

```php
return [
    //....
    'handler' => [
        new \Monolog\Handler\StreamHandler(
            __DIR__.'/../runtime/logs/system.log',
            \Monolog\Logger::DEBUG
        )
    ],
    //....
];
```

#### Handler configuration using array

```php
return [
    //....
    'handler' => [
        [
            'type' => 'stream',
            'path' => __DIR__.'/../runtime/logs/system.log',
            'level' => 'debug'
        ]
    ],
    //....
];
```
