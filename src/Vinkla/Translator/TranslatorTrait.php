<?php namespace Vinkla\Translator;

use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Vinkla\Translator\Exceptions\TranslatorException;
use Vinkla\Translator\Models\Translation;

trait TranslatorTrait {

	/**
	 * The current translation.
	 *
	 * @var mixed
	 */
	protected $translation;

	/**
	 * The translation instance.
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
		return $this->getTranslation();
	}

	/**
	 * Fetch the translation by their relations and locale.
	 *
	 * @throws TranslatorException
	 * @return mixed
	 */
	private function getTranslation()
	{
		if (!$this->translator || !class_exists($this->translator))
		{
			throw new TranslatorException('Please set the $translator property to your translation model path.');
		}

		if (!$this->translatorInstance)
		{
			$this->translatorInstance = new $this->translator();
		}

		// If there already is a current translation, use it.
		if ($this->translation)
		{
			return $this->translation;
		}

		// Fetch the translation by their locale id.
		$translation = $this->getTranslationByLocale($this->getLocaleId());

		if (!$translation)
		{
			// If we can't find a translation, create a new instance.
			$translation = $this->newTranslation();
		}

		return $translation;
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

			$this->translation = $this->getTranslation();

			if ($this->isFillable($key))
			{
				$this->setAttribute($key, $value);
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
	 * Get the current locale set within the app.
	 *
	 * @return mixed
	 */
	public function getLocaleId()
	{
		$localeInstance = $this->getLocaleInstance();

		$key = $this->getLocaleKey();
		$value = App::getLocale();

		return $localeInstance->where($key, $value)->first()->id;
	}

	/**
	 * Create a new translation instance of the translator model.
	 *
	 * @param array $attributes
	 * @param bool $exists
	 * @return mixed
	 */
	public function newTranslation($attributes = [], $exists = false)
	{
		$attributes = array_add($attributes, 'locale_id', $this->getLocaleId());

		$model = new $this->translatorInstance((array) $attributes);

		$model->exists = $exists;

		return $model;
	}

	/**
	 * Get the locale column key.
	 *
	 * @return string
	 */
	public function getLocaleKey()
	{
		return Config::get('translator::key') ?: 'language';
	}

	/**
	 * Fetch the locale instance.
	 *
	 * @return mixed
	 * @throws TranslatorException
	 */
	public function getLocaleInstance()
	{
		if (!Config::has('translator::locale'))
		{
			throw new TranslatorException(
				"Please set the 'locale' property in the configuration to your Locale model path."
			);
		}

		return App::make(Config::get('translator::locale'));
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
