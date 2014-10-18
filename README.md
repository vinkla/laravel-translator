Laravel Translator
==================

![image](https://raw.githubusercontent.com/vinkla/vinkla.github.io/master/images/laravel-translator.png)

This package gives you an easy way to translate Eloquent models into multiple languages.

[![Build Status](https://img.shields.io/travis/vinkla/translator/master.svg?style=flat)](https://travis-ci.org/vinkla/translator)
	[![Latest Stable Version](http://img.shields.io/packagist/v/vinkla/translator.svg?style=flat)](https://packagist.org/packages/vinkla/translator)
	[![License](https://img.shields.io/packagist/l/vinkla/translator.svg?style=flat)](https://packagist.org/packages/vinkla/translator)

## Install

Pull this package in through Composer.

```json
{
    "require": {
        "vinkla/translator": "0.3.*"
    }
}
```

#### Configuration Files

Add the service provider to `config/app.php` in the providers array.

```bash
'Vinkla\Translator\TranslatorServiceProvider'
```

To add the configuration files to the `app/packages` directory, run the command below.
```bash
php artisan config:publish vinkla/translator
```

## Usage

Below we have some example [migrations](#migrations) and [models](#models). More documentation is comming soon…

#### Migrations
Here's an example of the localisations migration.

```php
Schema::create('locales', function(Blueprint $table)
{
    $table->increments('id');
    $table->string('language', 2);
    $table->timestamps();
});
```

Migrations for the base table and the translatable relation table.

```php
Schema::create('posts', function(Blueprint $table)
{
    $table->increments('id');
    $table->timestamps();
});

Schema::create('post_translations', function(Blueprint $table)
{
    $table->increments('id');

    // Translatable columns
    $table->string('title');
    $table->string('content');

    $table->integer('post_id')->unsigned()->index();
    $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

    $table->integer('locale_id')->unsigned()->index();
    $table->foreign('locale_id')->references('id')->on('locales')->onDelete('cascade');

    $table->unique(['post_id', 'locale_id']);

    $table->timestamps();
});
```

#### Models

Here's an example of a translatable Laravel Eloquent model.

```php
<?php namespace Acme\Posts;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\TranslatorTrait;

class Post extends Model {

	use TranslatorTrait;

	/**
     * @var string
     */
    protected $translator = 'Acme\Posts\PostTranslation';

	/**
     * @var array
     */
    protected $translatedAttributes = ['title', 'content'];

}
```

That's it! You're done. Now you can do:
```php
<h1>{{ $post->translate()->title }}</h1>
<p>{{ $post->translate()->content }}</p>
```

Or if you added the `$translatedAttributes` (not required) array to your model:
```php
<h1>{{ $post->title }}</h1>
<p>{{ $post->content }}</p>
```

## License

The Translator package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
