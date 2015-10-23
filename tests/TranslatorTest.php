<?php

/*
 * This file is part of Laravel Translator.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vinkla\Tests\Translator;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use ReflectionClass;
use SebastianBergmann\PeekAndPoke\Proxy;
use Vinkla\Translator\TranslatableInterface;

/**
 * This is the translator test class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
class TranslatorTest extends AbstractTestCase
{
    public function testInterface()
    {
        $article = new ReflectionClass(Article::class);
        $this->assertTrue($article->implementsInterface(TranslatableInterface::class));
    }

    public function testTranslate()
    {
        $article = Article::first();
        $this->assertSame($article->translate('en')->title, 'Use the force Harry');
        $this->assertSame($article->translate('sv')->title, 'Använd kraften Harry');
    }

    public function testFallback()
    {
        $article = Article::first();
        $this->assertSame($article->translate('de')->title, 'Use the force Harry');
    }

    public function testSetLocale()
    {
        $article = Article::first();
        $this->assertSame($article->title, 'Använd kraften Harry');
        $this->assertSame($article->translate()->title, 'Använd kraften Harry');
        App::setLocale('en');
        $this->assertSame($article->title, 'Use the force Harry');
        $this->assertSame($article->translate()->title, 'Use the force Harry');
    }

    public function testCachedTranslations()
    {
        $article = Article::first();
        $translations = ['en' => $article->translate('en'), 'sv' => $article->translate('sv')];
        $cache = (new Proxy($article))->cache;
        $this->assertCount(2, $cache);
        $this->assertSame($translations, $cache);
        DB::enableQueryLog();
        $article->translate('en');
        $this->assertEmpty(DB::getQueryLog());
    }

    public function testGetAttributes()
    {
        $article = Article::first();
        $this->assertSame($article->translate()->title, 'Använd kraften Harry');
        $this->assertSame($article->title, 'Använd kraften Harry');
    }

    public function testSetAttributes()
    {
        App::setLocale('en');
        $article = Article::first();
        $this->assertSame($article->title, 'Use the force Harry');
        $article->title = 'I\'m your father Hagrid';
        $this->assertSame($article->title, 'I\'m your father Hagrid');
        $this->assertSame($article->translate()->title, 'I\'m your father Hagrid');
        $this->assertSame($article->translate('sv')->title, 'Använd kraften Harry');
    }

    public function testCreate()
    {
        App::setLocale('en');
        $article = Article::create(['title' => 'Whoa. This is heavy.', 'thumbnail' => 'http://i.imgur.com/tyfwfEX.jpg']);
        $this->seeInDatabase('article_translations', ['title' => 'Whoa. This is heavy.', 'article_id' => $article->id, 'locale' => 'en']);
        $this->seeInDatabase('articles', ['thumbnail' => 'http://i.imgur.com/tyfwfEX.jpg']);

        App::setLocale('de');
        $article = Article::create(['title' => 'Whoa. Das ist schwer.', 'thumbnail' => 'http://i.imgur.com/tyfwfEX.jpg']);
        $this->seeInDatabase('article_translations', ['title' => 'Whoa. Das ist schwer.', 'article_id' => $article->id, 'locale' => 'de']);
        $this->seeInDatabase('articles', ['thumbnail' => 'http://i.imgur.com/tyfwfEX.jpg']);
    }
}
