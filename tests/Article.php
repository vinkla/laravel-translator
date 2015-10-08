<?php

/*
 * This file is part of Laravel Translator.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vinkla\Tests\Translator;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\Translatable;
use Vinkla\Translator\TranslatableInterface;

/**
 * This is the article eloquent model class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class Article extends Model implements TranslatableInterface
{
    use Translatable;

    /**
     * A list of methods protected from mass assignment.
     *
     * @var string[]
     */
    protected $guarded = ['_token', '_method'];

    /**
     * The translated attributes.
     *
     * @var string[]
     */
    public $translatedAttributes = ['title'];
}
