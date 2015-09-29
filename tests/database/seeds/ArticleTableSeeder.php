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
use Vinkla\Tests\Translator\Models\Article;

/**
 * This is the article table seeder class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
final class ArticleTableSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        Article::create(['thumbnail' => 'http://i.imgur.com/V2wxB.jpg']);
    }
}
