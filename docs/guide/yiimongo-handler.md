YiiMongoHandler
---------------

`Mero\Monolog\Handler\YiiMongoHandler` é responsável por armazenar logs em bases de dados
do MongoDB o `yii\mongodb\Connection` como client de comunicação.

Dependências
------------

- [yiisoft/yii2-mongodb](https://github.com/yiisoft/yii2-mongodb)

Configurando o handler no MonologComponent
------------------------------------------

### Configurando por objeto

Para configurar o `YiiMongoHandler` por objeto basta instanciar o objeto na sua lista de handlers do channel
desejado.

**Exemplo:**

```php
return [
    //...
        'channels' => [
            'main' => [
                'handler' => [
                    new \Mero\Monolog\Handler\YiiMongoHandler(
                        Yii::$app->mongodb,
                        'nome_collection',
                        \Monolog\Logger::DEBUG
                    ),
                ],
                'processor' => [],
            ],
    //...
];
```

### Configurando por array

Para configurar o `YiiMongoHandler` por array é necessário declarar um array informando o nome da conexão
com a base e qual a collection que será utilizada.

**Estrutura do array:**

| Campo        | Descrição                                        |
| ------------ | ------------------------------------------------ |
| `type`       | Identificação do handler(`yii_mongo`)            |
| `reference`  | Nome da conexão do Yii2 que será utilizada       |
| `collection` | Nome da collection no MongoDB                    |
| `level`      | Identificação do level que será usado no Handler |

**Exemplo:**

```php
return [
    //...
        'channels' => [
            'main' => [
                'handler' => [
                    [
                        'type' => 'yii_mongo',
                        'reference' => 'mongodb',
                        'collection' => 'nome_collection',
                        'level' => 'debug',
                    ],
                ],
                'processor' => [],
            ],
    //...
];
```
