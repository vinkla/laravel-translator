<?php namespace Vinkla\Translator\Contracts;

use Vinkla\Translator\Exceptions\TranslatorException;

interface Translatable {

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
