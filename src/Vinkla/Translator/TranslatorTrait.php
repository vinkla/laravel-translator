<?php namespace Vinkla\Translator;

use Vinkla\Translator\Exceptions\TranslatorException;
use Illuminate\Support\Facades\Session;

trait TranslatorTrait {

	/**
	 * Translator instance.
	 *
	 * @var mixed
	 */
	protected $translatorInstance;

	/**
	 * Prepare a translator instance and fetch translations.
	 *
	 * @throws TranslatorException
	 * @return mixed
	 */
	public function translate()
	{
		if (!$this->translator || !class_exists($this->translator))
		{
			throw new TranslatorException('Please set the $translator property to your translation model path.');
		}

		if (!$this->translatorInstance)
		{
			$this->translatorInstance = new $this->translator();
		}

		return $this->translatorInstance
			->where($this->getForeignKey(), $this->id)
			->where($this->getLocaleKey(), $this->getLocale())
			->first();
	}

	/**
	 * Fetch the default localisation key comparison.
	 *
	 * @return mixed
	 */
	public function getLocale()
	{
		return Session::get($this->getLocaleKey());
	}

	/**
	 * Fetch the localisation key.
	 *
	 * @return string
	 */
	private function getLocaleKey()
	{
		return $this->localeKey ? $this->localeKey : 'locale_id';
	}
}
