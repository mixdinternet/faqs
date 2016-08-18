## Faqs

Pacote inicial de Faqs.

## Instalação

Adicione no seu composer.json

```js
  "require": {
    "mixdinternet/faqs": "0.0.*"
  }
```

ou

```js
  composer require mixdinternet/faqs
```

## Service Provider

Abra o arquivo `config/app.php` e adicione

`Mixdinternet\Faqs\Providers\FaqsServiceProvider::class`

## Migrations

```
  php artisan vendor:publish --provider="Mixdinternet\Faqs\Providers\FaqsServiceProvider" --tag="migrations"`
  php artisan migrate
```

## Configurações

É possivel a troca de icone e nomenclatura do pacote em `config/mfaqs.php`

```
  php artisan vendor:publish --provider="Mixdinternet\Faqs\Providers\FaqsServiceProvider" --tag="config"`
```
