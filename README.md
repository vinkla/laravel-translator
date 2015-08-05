Laravel Translator
==================

![laravel-translator](https://cloud.githubusercontent.com/assets/499192/7440607/b7c867cc-f0bf-11e4-9d13-0ce90882ae14.png)

This package gives you an easy way to translate Eloquent models into multiple languages.

```php
// Display the default title for an Eloquent object.
echo $foo->title;

// Change the current language to Swedish.
App::setLocale('sv');

// Display the translated title in Swedish.
echo $foo->title;
```
Read more about how this package was created and why it exists [in this blog post](http://vinkla.com/2014/11/laravel-translator/).

[![Build Status](https://img.shields.io/travis/vinkla/translator/master.svg?style=flat)](https://travis-ci.org/vinkla/translator)
[![StyleCI](https://styleci.io/repos/24419399/shield?style=flat)](https://styleci.io/repos/24419399)
[![Latest Version](https://img.shields.io/github/release/vinkla/translator.svg?style=flat)](https://github.com/vinkla/translator/releases)
[![License](https://img.shields.io/packagist/l/vinkla/translator.svg?style=flat)](https://packagist.org/packages/vinkla/translator)

## Documentation

This package features an [extensive wiki](https://github.com/lucadegasperi/oauth2-server-laravel/wiki) to help you getting started implementing the translator in your Laravel and Lumen applications.

## License

Laravel Translator is licensed under [The MIT License (MIT)](LICENSE).
