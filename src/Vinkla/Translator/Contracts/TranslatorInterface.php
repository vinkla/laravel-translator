<?php namespace Vinkla\Contracts\Translator;

interface TranslatorInterface {

	/**
	 * Prepare a translator instance and fetch translations.
	 *
	 * @return mixed
	 */
	public function translate();

}
