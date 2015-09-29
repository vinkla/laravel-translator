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

use Vinkla\Tests\Translator\Models\Article;

/**
 * This is the translator test class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
class TranslatorTest extends AbstractTestCase
{
    public function testHasManyRelation()
    {
        $this->assertCount(2, Article::first()->translations);
    }

    public function testTranslate()
    {
        $article = Article::first();

        $this->assertSame($article->translate('en')->title, 'Hassle with the Hoff');
        $this->assertSame($article->translate('sv')->title, 'Hassla med Hoffen');
    }
}
