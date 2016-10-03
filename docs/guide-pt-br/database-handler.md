Database Handler
----------------

`Mero\Monolog\Handler\DatabaseHandler` é responsável por armazenar logs em bases de dados
utilizando o `yii\db\Connection` para de comunicar com o SGBD.

### Criando tabela de log

O DatabaseHandler não possui dependência relacionada a nome de tabela. Você poderá criar
mais de uma tabela caso deseje, destinando cada uma a um channel diferente ou a estratégia
que prefira.

**Campos necessários:**

- channel: VARCHAR(255)
- level: INTEGER
- message: LONGTEXT
- time: DATETIME

### Configurando o handler no MonologComponent

Para configurar o DatabaseHandler basta instanciar o objeto na sua lista de handlers do channel
desejado.

**Exemplo:**

```php
return [
    //...
        'channels' => [
            'main' => [
                'handler' => [
                    new \Mero\Monolog\Handler\DatabaseHandler(
                        'nome_tabela',
                        \Monolog\Logger::DEBUG
                    ),
                ],
                'processor' => [],
            ],
    //...
];
```
