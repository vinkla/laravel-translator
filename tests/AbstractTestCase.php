<?php

/*
 * This file is part of Laravel Translator.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vinkla\Tests\Translator;

use ArticleTableSeeder;
use GrahamCampbell\TestBench\AbstractPackageTestCase;
use TranslationTableSeeder;
use Vinkla\Tests\Translator\Providers\DatabaseServiceProvider;

/**
 * This is the abstract test case class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
abstract class AbstractTestCase extends AbstractPackageTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->config->set('app.locale', 'sv');
        $app->config->set('app.fallback', 'en');
    }

    protected function getRequiredServiceProviders($app)
    {
        return [
            DatabaseServiceProvider::class,
        ];
    }

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate');

        $this->seed(ArticleTableSeeder::class);
        $this->seed(TranslationTableSeeder::class);
    }
}
