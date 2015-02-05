<?php namespace Vinkla\Translator;

use Illuminate\Support\ServiceProvider;

class TranslatorServiceProvider extends ServiceProvider {

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->setupConfig();
		$this->setupMigrations();
	}

	/**
	 * Setup the config.
	 *
	 * @return void
	 */
	protected function setupConfig()
	{
		$source = realpath(__DIR__.'/../config/translator.php');
		$this->publishes([$source => config_path('translator.php')]);
		$this->mergeConfigFrom($source, 'translator');
	}

	/**
	 * Setup the migrations.
	 *
	 * @return void
	 */
	protected function setupMigrations()
	{
		$source = realpath(__DIR__.'/../database/migrations/');
		$this->publishes([$source => base_path('/database/migrations')], 'migrations');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {}

}
