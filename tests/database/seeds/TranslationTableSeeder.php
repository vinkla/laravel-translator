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
use Illuminate\Support\Facades\DB;

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
        DB::table('article_translations')->insert([
            ['title' => 'Use the force Harry', 'article_id' => 1, 'locale' => 'en', 'created_at' => time(), 'updated_at' => time()],
            ['title' => 'Använd kraften Harry', 'article_id' => 1, 'locale' => 'sv', 'created_at' => time(), 'updated_at' => time()],
        ]);
    }
}
