<?php

/*
 * This file is part of Laravel Translator.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vinkla\Translator\Contracts;

use Vinkla\Translator\Exceptions\TranslatorException;

/**
 * This is the translatable trait interface.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
interface Translatable
{
    /**
     * Prepare a translator instance and fetch translations.
     *
     * @param null $locale
     * @return mixed
     * @throws TranslatorException
     */
    public function translate($locale = null);

    /**
     * Setup a one-to-many relation.
     *
     * @return mixed
     */
    public function translations();
}
