<?php namespace Vinkla\Translator; 

use Illuminate\Support\ServiceProvider;

class TranslatorServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Vinkla\Translator\Contracts\TranslatorInterface',
			'Vinkla\Translator\Translator'
		);
	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('vinkla/translator');
	}

}