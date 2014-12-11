<?php namespace Vinkla\Translator;

use Illuminate\Database\Eloquent\MassAssignmentException;
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
	 * The current translation.
	 *
	 * @var mixed
	 */
	protected $translation;

	/**
	 * Translator instance.
	 *
	 * @var mixed
	 */
	protected $translatorInstance;

	/**
	 * @var mixed
	 */
	protected $localeInstance;

	/**
	 * Prepare a translator instance and fetch translations.
	 *
	 * @param $locale
	 * @throws TranslatorException
	 * @return mixed
	 */
	public function translate($locale = null)
	{
		return $this->getTranslation($locale);
	}

	/**
	 * Fetch the translation by their relations and locale.
	 *
	 * @param $locale
	 * @throws TranslatorException
	 * @return mixed
	 */
	private function getTranslation($localeId = null)
	{
		if (!$this->translator || !class_exists($this->translator))
		{
			throw new TranslatorException('Please set the $translator property to your translation model path.');
		}

		if (!$this->translatorInstance)
		{
			$this->translatorInstance = new $this->translator();
		}

		// Fetch the translation by their locale.
		$translation = $this->getTranslationByLocale($localeId ?: $this->getLocale()->id);

		if ($translation)
		{
			return $translation;
		}

		// If we can't find a translation, create a new instance.
		return $this->newTranslatorInstance([
			$this->getLocaleKey() => $this->getLocale()->id
		]);
	}

	/**
	 * Fetch the translation by their locale.
	 *
	 * @param $localeId
	 * @return mixed
	 */
	public function getTranslationByLocale($localeId)
	{
		return $this->translatorInstance
			->where('locale_id', $localeId)
			->where($this->getForeignKey(), $this->id)
			->first();
	}

	/**
	 * Fill the model with an array of attributes.
	 *
	 * @param array $attributes
	 * @return $this
	 *
	 * @throws \Illuminate\Database\Eloquent\MassAssignmentException
	 */
	public function fill(array $attributes)
	{
		$totallyGuarded = $this->totallyGuarded();

		foreach ($attributes as $key => $value)
		{
			if (!in_array($key, $this->translatedAttributes)) { continue; }

			$this->translation = $this->getTranslation($this->getLocale()->id, false);

			if ($this->isFillable($key))
			{
				$this->translation->setAttribute($key, $value);
			}
			elseif ($totallyGuarded)
			{
				throw new MassAssignmentException($key);
			}

			unset($attributes[$key]);
		}

		return parent::fill($attributes);
	}

	/**
	 * Save the model to the database.
	 *
	 * @param array $options
	 * @return bool
	 */
	public function save(array $options = [])
	{
		$saved = parent::save($options);

		if ($saved && $this->translation)
		{
			$this->translations()->save($this->translation);
		}

		return $saved;
	}

	/**
	 * Update the model in the database.
	 *
	 * @param array $attributes
	 * @return bool|int
	 */
	public function update(array $attributes = [])
	{
		$updated = parent::update($attributes);

		if ($updated)
		{
			$this->translations()->save($this->translation);
		}

		return $updated;
	}

	/**
	 * Create a new instance of the translator model.
	 *
	 * @param array $attributes
	 * @param bool $exists
	 * @return mixed
	 */
	public function newTranslatorInstance($attributes = [], $exists = false)
	{
		$model = new $this->translatorInstance((array) $attributes);

		$model->exists = $exists;

		return $model;
	}

	/**
	 * Set a given attribute on the model.
	 *
	 * @param $key
	 * @param $value
	 * @return mixed
	 */
	public function setAttribute($key, $value)
	{
		if (in_array($key, $this->translatedAttributes))
		{
			return $this->getTranslation()->$key = $value;
		}

		return parent::setAttribute($key, $value);
	}

	/**
	 * Get an attribute from the model.
	 *
	 * @param $key
	 * @return mixed
	 */
	public function getAttribute($key)
	{
		if (in_array($key, $this->translatedAttributes))
		{
			return $this->getTranslation() ? $this->getTranslation()->$key : null;
		}

		return parent::getAttribute($key);
	}

	/**
	 * Get the default locale being used.
	 *
	 * If you want to fetch the localisation identifier from
	 * another resource, this can be overwritten in the model.
	 *
	 * @return mixed
	 */
	public function getLocale()
	{
		if (!$this->localeInstance)
		{
			$this->setLocaleInstance();
		}

		return $this->localeInstance->where(
			$this->getLocaleKey(),
			App::getLocale()
		)->first();
	}

	/**
	 * Get the locale column key.
	 *
	 * @return string
	 */
	public function getLocaleKey()
	{
		return Config::get('translator::key');
	}

	public function setLocaleInstance()
	{
		$this->localeInstance = App::make(Config::get('translator::locale'));
	}

	/**
	 * Setup a one-to-many relation.
	 *
	 * @return mixed
	 */
	public function translations()
	{
		return $this->hasMany($this->translator);
	}

}
