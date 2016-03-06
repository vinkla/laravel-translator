Laravel Translator
==================

![translator](https://cloud.githubusercontent.com/assets/499192/13553952/98b2db00-e39a-11e5-9e82-aca4df0961be.jpg)

An Eloquent translator for Laravel. Read more about how this package was created and why it exists [in this blog post](http://vinkla.com/2014/11/laravel-translator/).

```php
// Fetch an Eloquent object
$article = Article::find(1);

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

## Installation
Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
composer require vinkla/translator
```

Create a new migration for the translations. In our case we want to translate the `articles` table.

```bash
php artisan make:migration create_article_translations_table
```

Make sure you add the `article_id` and `locale` columns. Also, make them unique.

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * This is the article translations table seeder class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class CreateArticleTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_translations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title'); // Translated column.

            $table->integer('article_id')->unsigned()->index();
            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onDelete('cascade');

            $table->string('locale')->index();

            $table->unique(['article_id', 'locale']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article_translations');
    }
}
```

Create a new empty `ArticleTranslation` Eloquent model.

```php
use Illuminate\Database\Eloquent\Model;

/**
 * This is the article translation eloquent model class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class ArticleTranslation extends Model
{
    /**
     * A list of methods protected from mass assignment.
     *
     * @var string[]
     */
    protected $guarded = ['_token', '_method'];
}

```

Add the `Translatable` trait and the `IsTranslatable` interface to the `Article` Eloquent model. Add the has-many `translations()` relation method and fill the `$translatedAttributes` array with translatable attributes.

```php
use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\IsTranslatable;
use Vinkla\Translator\Translatable;

/**
 * This is the article eloquent model class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class Article extends Model implements IsTranslatable
{
    use Translatable;

    /**
     * A list of methods protected from mass assignment.
     *
     * @var string[]
     */
    protected $guarded = ['_token', '_method'];

    /**
     * The translated attributes.
     *
     * @var string[]
     */
    protected $translatedAttributes = ['title'];

    /**
     * Get the translations relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations()
    {
        return $this->hasMany(ArticleTranslation::class);
    }
}
```

Now you're ready to start translating your Eloquent models!

Want more? Then you should definitely check out [the tests](tests). They showcase how to setup a basic project and are quite readable. Happy hacking!

## Usage

Fetch pre-filled translated attributes.

```php
$article->title;
```

Fetch translated attributes with the `translate()` method.

```php
$article->translate()->title;
```

Fetch translated attributes for a specific locale with the `translate()` method.

```php
$article->translate('sv')->title;
```

Fetch translated attributes without fallback support.

```php
$article->translate('de', false)->title;
```

Create instance with translated attributes.

```php
Article::create(['title' => 'Use the force Harry']);
```

> Note that this package will automatically find translated attributes based on items from the `$translatedAttributes` array in the Eloquent model.

Create instance with translated attributes for a specific locale.

```php
App::setLocale('sv');

Article::create(['title' => 'Använd kraften Harry']);
```

Update translated attributes.

```php
$article->update(['title' => 'Whoa. This is heavy.']);
```

Update translated attributes for a specific locale.

```php
App::setLocale('sv');

$article->update(['title' => 'Whoa. Detta är tung.']);
```

Delete an article with translations.

```php
$article->delete();
```

Delete translations.

```php
$article->translations()->delete();
```

## License

Laravel Translator is licensed under [The MIT License (MIT)](LICENSE).
