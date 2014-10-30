Laravel Translator
==================

![image](https://raw.githubusercontent.com/vinkla/vinkla.github.io/master/images/laravel-translator.png)

This package gives you an easy way to translate Eloquent models into multiple languages.

```php
// Fetch the Eloquent object.
$foo = Foo::first();

// Display the default title.
echo $foo->title;

// Change the current language to Swedish.
App::setLocale('sv');

// Display the translated title in Swedish.
echo $foo->title;
```

[![Build Status](https://img.shields.io/travis/vinkla/translator/master.svg?style=flat)](https://travis-ci.org/vinkla/translator)
	[![Latest Stable Version](http://img.shields.io/packagist/v/vinkla/translator.svg?style=flat)](https://packagist.org/packages/vinkla/translator)
	[![License](https://img.shields.io/packagist/l/vinkla/translator.svg?style=flat)](https://packagist.org/packages/vinkla/translator)

## Installation

The library requires at least **PHP version 5.4** and comes with a **Laravel Service Provider** to simplify the framework integration.

Require this package in your `composer.json` and update composer.

```json
{
	"require": {
		"vinkla/translator": "~0.4"
	}
}
```

Add the service provider to `config/app.php` in the providers array.

```bash
'Vinkla\Translator\TranslatorServiceProvider'
```

To add the configuration files to the `app/config/packages` directory, run the command below.
```bash
php artisan publish:config vinkla/translator
```

## Getting started

Below we have examples of [migrations](#migrations), [models](#models) and [templating](#templating).

#### Migrations
Here's an example of the localisations migration.

```php
Schema::create('locales', function(Blueprint $table)
{
	$table->increments('id');
	$table->string('language', 2); // en, sv, da, no, etc.
	$table->timestamps();
});
```

Add the Laravel migration for the base table which you want to translate.

```php
Schema::create('articles', function(Blueprint $table)
{
	$table->increments('id');
	$table->string('thumbnail');
	$table->timestamps();
});
```

Add the Laravel migration for the translatable relation table.

```php
Schema::create('article_translations', function(Blueprint $table)
{
	$table->increments('id');

	// Translatable attributes
	$table->string('title');
	$table->string('content');
	// Translatable attributes

	$table->integer('article_id')->unsigned()->index();
	$table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');

	$table->integer('locale_id')->unsigned()->index();
	$table->foreign('locale_id')->references('id')->on('locales')->onDelete('cascade');

	$table->unique(['article_id', 'locale_id']);

	$table->timestamps();
});
```

#### Models

Here's an example of a translatable Laravel Eloquent model.

```php
<?php namespace Acme\Articles;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\TranslatorTrait;

class Article extends Model {

	use TranslatorTrait;

	/**
	 * @var string
	 */
	protected $translator = 'Acme\Articles\ArticleTranslation';

	/**
	 * @var array
	 */
	protected $translatedAttributes = ['title', 'content'];

}
```

### Templating

That's it! You're done. Now you can do:
```php
<h1>{{ $article->translate()->title }}</h1>
<img src="{{ $article->thumbnail }}">
<p>{{ $article->translate()->content }}</p>
```

Or if you added the `$translatedAttributes` array to your model (not required), you can do:
```php
<h1>{{ $article->title }}</h1>
<img src="{{ $article->thumbnail }}">
<p>{{ $article->content }}</p>
```

## Contributing

Thank you for considering contributing to the Translator package. If you are submitting a bug-fix, or an enhancement that is **not** a breaking change, submit your pull request to the the latest stable release of the package, the `master` branch. If you are submitting a breaking change or an entirely new component, submit your pull request to the `develop` branch.

## License

The Translator package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
