<?php namespace Vinkla\Translator;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Vinkla\Translator\Exceptions\TranslatorException;

trait TranslatorTrait {

	/**
	 * The default localization column key.
	 *
	 * @var string
	 */
	protected $localeKey;

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

		return $this->getTranslation();
	}

	/**
	 * Setup a one to many relation.
	 *
	 * @return mixed
	 */
	public function translations()
	{
		return $this->hasMany($this->translator);
	}

	/**
	 * Fetch the translation by their relations.
	 *
	 * @return mixed
	 */
	private function getTranslation()
	{
		return $this->translatorInstance
			->where($this->getForeignKey(), $this->id)
			->where($this->getLocaleKey(), $this->getLocale())
			->first();
	}

	/**
	 * Fetch the default localisation data comparison.
	 *
	 * If you want to fetch the localisation identifier from
	 * another resource, this can be overwritten in the model.
	 *
	 * @return mixed
	 */
	public function getLocale()
	{
		if (Config::get('translator::driver') === 'session')
		{
			return Session::get($this->getLocaleKey());
		}

		return App::getLocale();
	}

	/**
	 * Fetch the localisation column key.
	 *
	 * @return string
	 */
	public function getLocaleKey()
	{
		return $this->localeKey ?: Config::get('translator::key');
	}

}
