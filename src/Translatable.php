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

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * This is the translatable trait.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
trait Translatable
{
    /**
     * The translations cache.
     *
     * @var array
     */
    protected $cache = [];

    /**
     * Get a translation.
     *
     * @param string|null $locale
     *
     * @return \Illuminate\Database\Eloquent\Model|static|null
     */
    public function translate($locale = null)
    {
        $locale = $locale ?: $this->getLocale();

        $translation = $this->getTranslation($locale);

        if (!$translation) {
            $translation = $this->getTranslation($this->getFallback());
        }

        return $translation;
    }

    /**
     * Get the translation table name.
     *
     * @return string
     */
    public function getTranslationTableName()
    {
        return Str::singular($this->getTable()).'_translations';
    }

    /**
     * Get a translation.
     *
     * @param string $locale
     *
     * @return \Illuminate\Database\Eloquent\Model|static|null
     */
    protected function getTranslation($locale)
    {
        if (isset($this->cache[$locale])) {
            return $this->cache[$locale];
        }

        $translation = DB::table($this->getTranslationTableName())
            ->where('locale', $locale)
            ->first();

        if ($translation) {
            $this->cache[$locale] = $translation;
        }

        return $translation;
    }

    /**
     * Get an attribute from the model.
     *
     * @param $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (in_array($key, $this->translatedAttributes)) {
            return $this->translate() ? $this->translate()->$key : null;
        }

        return parent::getAttribute($key);
    }

    /**
     * Get the locale.
     *
     * @return string
     */
    protected function getLocale()
    {
        return App::getLocale();
    }

    /**
     * Get the fallback locale.
     *
     * @return string
     */
    protected function getFallback()
    {
        return Config::get('app.fallback_locale');
    }
}
