<?php

/*
 * This file is part of Laravel Translator.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vinkla\Translator;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the is translatable interface.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
interface IsTranslatable
{
    /**
     * Get the translations relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations(): HasMany;
}
