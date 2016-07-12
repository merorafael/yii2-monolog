Monolog for Yii 2
=================

## Instalation

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```
php composer.phar require merorafael/yii2-monolog
```

or add

```json
"merorafael/yii2-monolog": "~1.0.0"
```

to the require section of your composer.json.

## Configuration

```php
return [
    //....
    'components' => [
        'monolog' => [
            'class' => 'yii\monolog\Logger',
            'handlers' => [
            ]
        ],
    ]
];
```
