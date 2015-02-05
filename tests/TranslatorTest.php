<?php namespace Vinkla\Tests\Translator;

use PHPUnit_Framework_TestCase;
use Vinkla\Translator\Translatable;
use Vinkla\Translator\Contracts\Translatable as TranslatableContract;

class TranslatorTest extends PHPUnit_Framework_TestCase {

	protected $foo;

	public function setUp()
	{
		$this->foo = new Foo();
	}

	public function testTranslatorTrait()
	{
		$this->assertTrue(method_exists($this->foo, 'translate'));
		$this->assertTrue(method_exists($this->foo, 'translations'));
	}

	public function testTranslatedAttributes()
	{
		$this->assertTrue(is_array($this->foo->translatedAttributes));
	}

	/**
	 * @expectedException Vinkla\Translator\Exceptions\TranslatorException
	 */
	public function testException()
	{
		$this->foo->translator = null;
		$this->foo->translate()->title;
	}

}

class Foo implements TranslatableContract {
	
	use Translatable;

	public $translator = 'FooTranslation';

	public $translatedAttributes = ['one', 'two'];
}

class FooTranslation {}
