<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Application Locale Driver
	|--------------------------------------------------------------------------
	|
	| Either use the App::getLocale() to fetch the current locale key or use
	| the session driver to fetch the data you want to compare with.
	|
	| Supported: 'app', 'session'
	|
	*/

	'driver' => 'app',

	/*
	|--------------------------------------------------------------------------
	| Localisation Column Key
	|--------------------------------------------------------------------------
	|
	| The default localisation column identifier to compare the data with.
	|
	*/

	'key' => 'language',

	/*
	|--------------------------------------------------------------------------
	| Session Fallback Locale
	|--------------------------------------------------------------------------
	|
	| If driver is set to 'session' you can set the default locale key
	| identifier to compare with. If using 'app' as driver this will ignored
	| and the locale key will be fetched from Laravel's app configuration.
	|
	*/

	'fallback_locale' => 'en'

];
