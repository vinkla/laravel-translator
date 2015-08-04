<?php

/*
 * This file is part of Laravel Translator.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vinkla\Translator;

/**
 * This is the translatable trait interface.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
interface TranslatableInterface
{
    /**
     * Prepare a translator instance and fetch translations.
     *
     * @param string|null $locale
     *
     * @throws \Vinkla\Translator\TranslatorException
     *
     * @return mixed
     */
    public function translate($locale = null);

    /**
     * Get the translations relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations();
}
