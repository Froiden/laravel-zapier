## Laravel - Zapier

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/laravel-zapier.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/laravel-zapier)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

- Envia as conversões para o Zapier

## Instalação

```bash
composer require agenciafmd/laravel-zapier:dev-master
```

## Configuração

Primeiro, vamos criar o Catch Webhook

Para isso, vamos em **Make a Zap > Catch Hook > Webhook by Zapier**

![Make a Zap > Catch Hook > Webhook by Zapier](https://github.com/agenciafmd/laravel-zapier/raw/master/docs/screenshot01.jpg "Make a Zap > Catch Hook > Webhook by Zapier")

No próximo passo, capturamos a nossa url

![Url](https://github.com/agenciafmd/laravel-zapier/raw/master/docs/screenshot02.jpg "Url")

Colocamos esta url no nosso .env

```dotenv
ZAPIER_WEBHOOK=https://hooks.zapier.com/hooks/catch/0000000/a0a0a0a/
```

## Uso

Envie os campos no formato de array para o SendConversionsToZapierWebhook.

Para que o processo funcione pelos **jobs**, é preciso passar os valores dos cookies conforme mostrado abaixo.

```php
use Agenciafmd\Zapier\Jobs\SendConversionsToZapierWebhook;
use Illuminate\Support\Facades\Cookie;

$data['email'] = 'irineu@fmd.ag';
$data['nome'] = 'Irineu Junior';

SendConversionsToZapierWebhook::dispatch($data + [
        'utm_campaign' => Cookie::get('utm_campaign', ''),
        'utm_content' => Cookie::get('utm_content', ''),
        'utm_medium' => Cookie::get('utm_medium', ''),
        'utm_source' => Cookie::get('utm_source', ''),
        'utm_term' => Cookie::get('utm_term', ''),
        'gclid_' => Cookie::get('gclid', ''),
        'cid' => Cookie::get('cid', ''),
    ])
    ->delay(5)
    ->onQueue('low');
```

Note que no nosso exemplo, enviamos o job para a fila **low**.

Certifique-se de estar rodando no seu queue:work esteja semelhante ao abaixo.

```shell
php artisan queue:work --tries=3 --delay=5 --timeout=60 --queue=high,default,low
```