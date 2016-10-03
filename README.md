Monolog for Yii 2
=================

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/90e3c666-c1b8-4ab0-846e-413451bdc023/mini.png)](https://insight.sensiolabs.com/projects/90e3c666-c1b8-4ab0-846e-413451bdc023)
[![Latest Stable Version](https://poser.pugx.org/mero/yii2-monolog/v/stable.svg)](https://packagist.org/packages/mero/yii2-monolog) 
[![Total Downloads](https://poser.pugx.org/mero/yii2-monolog/downloads.svg)](https://packagist.org/packages/mero/yii2-monolog) 
[![License](https://poser.pugx.org/mero/yii2-monolog/license.svg)](https://packagist.org/packages/mero/yii2-monolog)

The [Monolog](https://github.com/Seldaek/monolog) integration for the Yii framework.

Requirements
------------

- PHP 5.4 or above
- Yii 2.0.0 or above

Instalation with composer
-------------------------

1. Open your project directory;
2. Run `composer require mero/yii2-monolog` to add Monolog in your project vendor.

Configuration
-------------

To configure Monolog component in Yii2, use the structure exemplified below.
The channel "main" is required in component and used when no channel is setted to use a logger.

```php
return [
    //....
    'components' => [
        'monolog' => [
            'class' => \Mero\Monolog\MonologComponent::class,
            'channels' => [
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

You can configure multiple channels and different handlers and processors for each channel.

**Example**

```php
return [
    //...
        'channels' => [
            'main' => [
                'handler' => [
                    [
                        'type' => 'stream',
                        'path' => '@app/runtime/logs/main_' . date('Y-m-d') . '.log',
                        'level' => 'debug'
                    ]
                ],
                'processor' => [],
            ],
            'channel1' => [
                'handler' => [
                    [
                        'type' => 'stream',
                        'path' => '@app/runtime/logs/channel1_' . date('Y-m-d') . '.log',
                        'level' => 'debug'
                    ]
                ],
                'processor' => [],
            ],
            'channel2' => [
                'handler' => [
                    [
                        'type' => 'stream',
                        'path' => '@app/runtime/logs/channel1_' . date('Y-m-d') . '.log',
                        'level' => 'debug'
                    ]
                ],
                'processor' => [],
            ],
        ],
    //...
];
```

Handlers
--------

You can add handlers in their channels using the array structure or object structure.

### Array structure

Using the array structure, you have a better readability of the configuration of their handlers.

**Example**

```php
return [
    //...
    'handler' => [
        [
            'type' => 'stream',
            'path' => '@app/runtime/logs/log_' . date('Y-m-d') . '.log',
            'level' => 'debug'
        ]
    ],
    //...
];
```

**Warning:** this option does not have any existing handlers in monolog.

**Handlers supported:**

- stream
- firephp
- browser_console
- gelf
- chromephp
- rotating_file

### Object structure

Using the object structure, you will be informing instantiated objects already declared their respective handlers.

**Example**

```php
return [
    //...
    'handler' => [
        new \Monolog\Handler\StreamHandler(
            __DIR__.'/../runtime/logs/system.log',
            \Monolog\Logger::DEBUG
        )
    ],
    //...
];
```

See the [official documentation](https://github.com/Seldaek/monolog/blob/master/doc/02-handlers-formatters-processors.md#handlers) of Monolog to see the handlers list.

Using Yii2 Monolog
------------------

To use Yii 2 Monolog simply call the method `getLogger` component informing which channel is used.

**Example**

```php
namespace app\controllers;

use Yii;
use \yii\web\Controller;

class ExampleController extends Controller
{

    /**
     * This action register "Hello world" in channel 
     * "main"(default when no value is setted on "getLogger" method).
     */
    public function actionFirstExample()
    {
        $monologComponent = Yii::app()->monolog;
        $logger = $monologComponent->getLogger();
        $logger->log('info', 'Hello world');
    }

    /**
     * This action register "Hello world" in channel "channel1".
     */
    public function actionSecondExample()
    {
        $monologComponent = Yii::app()->monolog;
        $logger = $monologComponent->getLogger("channel1");
        $logger->log('info', 'Hello world');
    }
    
}
```
