## Faqs

[![Total Downloads](https://poser.pugx.org/mixdinternet/faqs/d/total.svg)](https://packagist.org/packages/mixdinternet/faqs)
[![Latest Stable Version](https://poser.pugx.org/mixdinternet/faqs/v/stable.svg)](https://packagist.org/packages/mixdinternet/faqs)
[![License](https://poser.pugx.org/mixdinternet/faqs/license.svg)](https://packagist.org/packages/mixdinternet/faqs)

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
