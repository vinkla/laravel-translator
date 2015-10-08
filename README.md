Laravel Translator
==================

![laravel-translator](https://cloud.githubusercontent.com/assets/499192/7440607/b7c867cc-f0bf-11e4-9d13-0ce90882ae14.png)

An Eloquent translator for Laravel. Read more about how this package was created and why it exists [in this blog post](http://vinkla.com/2014/11/laravel-translator/).

```php
// Fetch an Eloquent object
$article = Article::find(1)

// Display title in default language
echo $article->title;

// Change the current locale to Swedish
App::setLocale('sv');

// Display title in Swedish
echo $article->title;
```

[![Build Status](https://img.shields.io/travis/vinkla/translator/master.svg?style=flat)](https://travis-ci.org/vinkla/translator)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/vinkla/translator.svg?style=flat)](https://scrutinizer-ci.com/g/vinkla/translator/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/vinkla/translator.svg?style=flat)](https://scrutinizer-ci.com/g/vinkla/translator)
[![Latest Version](https://img.shields.io/github/release/vinkla/translator.svg?style=flat)](https://github.com/vinkla/translator/releases)
[![License](https://img.shields.io/packagist/l/vinkla/translator.svg?style=flat)](https://packagist.org/packages/vinkla/translator)

## Documentation

This package features an [extensive wiki](https://github.com/vinkla/translator/wiki) to help you getting started implementing the translator in your Laravel and Lumen applications. [Take me to the docs!](https://github.com/vinkla/translator/wiki)

## License

Laravel Translator is licensed under [The MIT License (MIT)](LICENSE).
