<?php

/*
 * This file is part of Laravel Translator.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vinkla\Tests\Translator\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\Translatable;

/**
 * This is the article eloquent model class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class Article extends Model
{
    use Translatable;

    /**
     * The translations model.
     *
     * @var \Vinkla\Tests\Translator\Models\ArticleTranslation
     */
    public $translator = ArticleTranslation::class;

    /**
     * The translated attributes.
     *
     * @var string[]
     */
    public $translatedAttributes = ['title', 'content'];
}
