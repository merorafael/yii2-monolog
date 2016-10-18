MonologTarget
-------------

O `MonologTarget` é responsável por fazer uma ponte de conexão entre o logger do Yii2 e o logger 
do Monolog, usado por exemplo para transmitir logs internos da framework para o Monolog.

Configurando o target no Yii2
-----------------------------

Para configurar o `MonologTarget`, basta adiciona-lo nas configurações de targets do logger do Yii2.

Abaixo estão os campos existentes para a configuração do `MonologTarget` e um exemplo de 
como configura-lo.

**Campos:**

| Nome do campo  | Descrição                                               |
| -------------  | ------------------------------------------------------- |
| class          | `\Mero\Monolog\Target\MonologTarget::className()`       |
| component_name | Nome do component referênte ao monolog                  |
| channel        | Canal no qual será registrado os logs(default `main`)   |
| levels         | Leveis de log do Yii2 que serão enviados para o Monolog |

**Exemplo:**

```php
return [
    // ...
    'components' => [
        // ...
        'log' => [
            'targets' => [
                'class' => \Mero\Monolog\Target\MonologTarget::className(),
                'component_name' => 'monolog',
                'channel' => 'main',
                'levels' => ['error', 'warning', 'info'],
            ],
        ],
        // ...
    ],
    // ...
];
```

Interpretação de níveis
-----------------------

O `MonologTarget` interpreta os level de log do Yii2 para seus correspondentes
no Monolog. 

Essa interpretação foi feita usando como base o `SyslogTarget` no qual utiliza
level de logs do Unix, os mesmos levels utilizados pelo padrão `PSR-3`.

Segue abaixo uma tabela na qual representa a interpretação do level de log no Yii2
para seu respectivo correspondente no Monolog.

| Yii2 Level    | Monolog level    |
| ------------- | ---------------- |
| trace         | debug            |
| profile_begin | debug            |
| profile_end   | debug            |
| info          | info             |
| warning       | warning          |
| error         | error            |

O `SyslogTarget` foi desenvolvido pelo Core do Yii e está presente na framework sem 
necessitar instalar nenhum pacote terceiro.
