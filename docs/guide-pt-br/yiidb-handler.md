YiiDbHandler
------------

`Mero\Monolog\Handler\YiiDbHandler` é responsável por armazenar logs em bases de dados
relacionais utilizando o `yii\db\Connection` para de comunicar com o SGBD.

Criando tabela de log
---------------------

O YiiDbHandler não possui dependência relacionada a nome de tabela. Você poderá criar
mais de uma tabela caso deseje, destinando cada uma a um channel diferente ou a estratégia
que prefira.

**Campos necessários:**

- channel: VARCHAR(255)
- level: INTEGER
- message: LONGTEXT
- time: DATETIME

Configurando o handler no MonologComponent
------------------------------------------

### Configurando por objetos

Para configurar o `YiiDbHandler` por objeto basta instanciar o objeto na sua lista de handlers do channel
desejado.

**Exemplo:**

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

### Configurando por array

Para configurar o `YiiMongoHandler` por array é necessário declarar um array informando o nome da conexão
com a base e qual a collection que será utilizada.

**Estrutura do array:**

| Campo        | Descrição                                        |
| ------------ | ------------------------------------------------ |
| `type`       | Identificação do handler(`yii_db`)               |
| `reference`  | Nome da conexão do Yii2 que será utilizada       |
| `table`      | Nome da tabela no banco de dados                 |
| `level`      | Identificação do level que será usado no Handler |

**Exemplo:**

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
                    ],
                ],
                'processor' => [],
            ],
    //...
];
```
