<?php
namespace CodeGun\Ini;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-10-13 at 09:19:17.
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers CodeGun\Ini\Parser::load
	 */
	public function testLoad()
	{
		$ini = array
		(
			"foo" => "bar",
			"bar" => "foo"
		);

		$parser = Parser::load($ini);
		$this->assertTrue(is_object($parser));
		$this->assertCount(2, $parser->config);
	}

	/**
	 * @covers CodeGun\Ini\Parser::loadFromString
	 */
	public function testLoadFromString()
	{
		$string = $this->combine(
			"foo = bar",
			"bar = foo"
		);

		$parser = Parser::loadFromString($string);
		$this->assertTrue(is_object($parser));
		$this->assertCount(2, $parser->config);
	}

	/**
	 * @covers CodeGun\Ini\Parser::loadFromFile
	 */
	public function testLoadFromFile()
	{
		$tmp = tempnam("/tmp", "parsertest_");
		$content = $this->combine(
			"test = test",
			"foo = bar"
		);

		$expectedArray = array(
			"test" => "test",
			"foo" => "bar"
		);

		file_put_contents($tmp, $content);

		$parser = Parser::loadFromFile($tmp);
		if(is_file($tmp))
			unlink($tmp);

		$this->assertTrue( is_object( $parser ) );
		$this->assertEquals($expectedArray, $parser->config);
	}

	/**
	 * @covers CodeGun\Ini\Parser::get
	 */
	public function testGet()
	{
		$string = $this->combine(
			"foo = bar",
			"named.var = ok",
			"further.named.var = yup"
		);

		$p = Parser::loadFromString($string);
		$this->assertEquals("bar", $p->get("foo"));
		$this->assertEquals("ok", $p->get("named.var"));
		$this->assertEquals("yup", $p->get("further.named.var"));

	}

	/**
	 * @return string
	 */
	public function combine()
	{
		return join(PHP_EOL, func_get_args()) . PHP_EOL;
	}
}
