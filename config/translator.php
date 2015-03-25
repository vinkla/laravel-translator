<?php

/*
 * This file is part of Laravel Translator.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Locale Eloquent Model
    |--------------------------------------------------------------------------
    |
    | This is the Eloquent model that handles what languages you support within
    | your project. Please provide the full namespaced path.
    |
    */

    'locale' => 'Acme\Locales\Locale',

    /*
    |--------------------------------------------------------------------------
    | Locale Identifier Column
    |--------------------------------------------------------------------------
    |
    | Specify the column key that you want to compare with when fetching
    | translations trough the App::getLocale() method.
    |
    */

    'column' => 'language',

    /*
    |--------------------------------------------------------------------------
    | Fallback Support
    |--------------------------------------------------------------------------
    |
    | Set this to true if you want to fetch the default translation if the
    | current locale doesn't have any translated attributes yet. The default
    | fallback is fetched from app/config/app.php
    |
    */

    'fallback' => false,

];
