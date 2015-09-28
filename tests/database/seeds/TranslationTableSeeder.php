<?php

/*
 * This file is part of Laravel Translator.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Seeder;
use Vinkla\Tests\Translator\Models\ArticleTranslation;

/**
 * This is the translation table seeder class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
final class TranslationTableSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        ArticleTranslation::create(['title' => 'Don\'t Hassle with the Hoff', 'article_id' => 1, 'locale'
        => 'en']);
        ArticleTranslation::create(['title' => 'Hassla inte med Hoffen', 'article_id' => 1, 'locale' => 'sv']);
    }
}
