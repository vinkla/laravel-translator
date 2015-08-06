<?php

/*
 * This file is part of Laravel Translator.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vinkla\Tests\Translator\Database\Seeds;

use Illuminate\Database\Seeder;
use Vinkla\Tests\Translator\Models\Locale;

/**
 * This is the locale table seeder class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class LocaleSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        foreach (['en', 'sv', 'no'] as $locale)
        {
            Locale::create(['id' => $locale]);
        }
    }
}
