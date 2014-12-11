<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Locale Eloquent Model
	|--------------------------------------------------------------------------
	|
	| This is the Eloquent model that handles what languages you support within
	| your project. Please provide the full namespaced path.
	|
	*/

	'locale' => 'Acme\Locales\Locale',

	/*
	|--------------------------------------------------------------------------
	| Locale Identifier Column
	|--------------------------------------------------------------------------
	|
	| Specify the column that you want to compare with when fetching
	| translations trough the App::getLocale() method.
	|
	*/

	'key' => 'language'

];
