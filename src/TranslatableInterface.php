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
     * Get a translation.
     *
     * @param string|null $locale
     *
     * @return \Illuminate\Database\Eloquent\Model|static|null
     */
    public function translate($locale = null);

    /**
     * Get the translations relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations();
}
