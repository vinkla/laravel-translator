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

    public function testCachedTranslations()
    {
        $article = Article::first();
        $translations = ['en' => $article->translate('en'), 'sv' => $article->translate('sv')];
        $proxy = new Proxy($article);
        $this->assertCount(2, $proxy->cache);
        $this->assertSame($translations, $proxy->cache);
        DB::enableQueryLog();
        $article->translate('en');
        $this->assertEmpty(DB::getQueryLog());
    }
}
