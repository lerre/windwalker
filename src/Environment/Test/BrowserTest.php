<?php
/**
 * Part of Windwalker project Test files.
 *
 * @copyright  Copyright (C) 2014 - 2015 LYRASOFT Taiwan, Inc. All rights reserved.
 * @license    GNU Lesser General Public License version 3 or later.
 */

namespace Windwalker\Environment\Test;

use Windwalker\Environment\Test\Stub\StubBrowser;

/**
 * Test class of Browser
 *
 * @since 2.0
 */
class BrowserTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Property inspector.
	 *
	 * @var  StubBrowser
	 */
	protected $instance;

	/**
	 * Provides test data for user agent parsing.
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public static function userAgent_Provider()
	{
		// Platform, Mobile, Engine, Browser, Version, User Agent
		return include __DIR__ . '/Stub/agents.php';
	}

	/**
	 * Provides test data for encoding parsing.
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public static function getEncodingData()
	{
		// HTTP_ACCEPT_ENCODING, Supported Encodings
		return array(
			array('gzip, deflate', array('gzip', 'deflate')),
			array('x-gzip, deflate', array('x-gzip', 'deflate')),
			array('gzip, x-gzip, deflate', array('gzip', 'x-gzip', 'deflate')),
			array(' gzip, deflate ', array('gzip', 'deflate')),
			array('deflate, x-gzip', array('deflate', 'x-gzip')),
			array('goober , flasm', array('goober', 'flasm')),
			array('b2z, base64', array('b2z', 'base64'))
		);
	}

	/**
	 * Provides test data for language parsing.
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public static function getLanguageData()
	{
		// HTTP_ACCEPT_LANGUAGE, Supported Language
		return array(
			array('en-US, en-GB', array('en-US', 'en-GB')),
			array('fr-FR, de-DE', array('fr-FR', 'de-DE')),
			array('en-AU, en-CA, en-GB', array('en-AU', 'en-CA', 'en-GB')),
			array(' nl-NL, de-DE ', array('nl-NL', 'de-DE')),
			array('en, nl-NL', array('en', 'nl-NL')),
			array('nerd , geek', array('nerd', 'geek')),
			array('xx-XX, xx', array('xx-XX', 'xx'))
		);
	}

	/**
	 * Provides test data for isRobot method.
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public static function detectRobotData()
	{
		return array(
			array('Googlebot/2.1 (+http://www.google.com/bot.html)', true),
			array('msnbot/1.0 (+http://search.msn.com/msnbot.htm)', true),
			array('Mozilla/4.0 compatible ZyBorg/1.0 (wn-14.zyborg@looksmart.net; http://www.WISEnutbot.com)', true),
			array('Mozilla/2.0 (compatible; Ask Jeeves/Teoma; +http://sp.ask.com/docs/about/tech_crawling.html)', true),
			array('Mozilla/5.0 (iPad; U; CPU OS 3_2_1 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Mobile/7B405', false),
			array('Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.168 Safari/535.19', false),
			array('BlackBerry8300/4.2.2 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/107 UP.Link/6.2.3.15.02011-10-16 20:20:17', false),
			array('IE 7 ? Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)2011-10-16 ' .
				'20:20:09', false)
		);
	}

	/**
	 * Setup for testing.
	 *
	 * @return  void
	 *
	 * @since   2.0
	 */
	public function setUp()
	{
		parent::setUp();

		$_SERVER['HTTP_HOST'] = 'mydomain.com';
		$_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0';
		$_SERVER['HTTP_CUSTOM_HEADER'] = 'Client custom header';
		$_SERVER['HTTP_AUTHORIZATION'] = 'Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==';

		$this->instance = new StubBrowser;
	}

	/**
	 * Tests the \Windwalker\Environment\Browser\Browser::__construct method.
	 *
	 * @return void
	 *
	 * @since 2.0
	 */
	public function test__construct()
	{
		$this->markTestIncomplete();
	}

	/**
	 * Tests the \Windwalker\Environment\Browser\Browser::__get method.
	 *
	 * @return void
	 *
	 * @since 2.0
	 */
	public function test__get()
	{
		$this->markTestIncomplete();
	}

	/**
	 * Tests the \Windwalker\Environment\Browser\Browser::detectBrowser method.
	 *
	 * @param   string   $device     The expected device.
	 * @param   boolean  $mobile     The expected mobile result.
	 * @param   string   $engine     The expected engine.
	 * @param   string   $browser    The expected browser.
	 * @param   string   $version    The expected browser version.
	 * @param   string   $ua         The input user agent.
	 *
	 * @return  void
	 *
	 * @dataProvider userAgent_Provider
	 * @since   2.0
	 */
	public function testDetectBrowser($device, $mobile, $engine, $browser, $version, $ua)
	{
		$this->instance->detectBrowser($ua);

		// Test the assertions.
		$this->assertEquals($browser, $this->instance->getBrowser(), 'Browser detection failed: ' . $ua);
		$this->assertEquals($version, $this->instance->getBrowserVersion(), 'Version detection failed: ' . $ua);
	}

	/**
	 * Tests the \Windwalker\Environment\Browser\Browser::detectEncoding method.
	 *
	 * @param   string  $ae  The input accept encoding.
	 * @param   array   $e   The expected array of encodings.
	 *
	 * @return  void
	 *
	 * @dataProvider getEncodingData
	 * @since   2.0
	 */
	public function testDetectEncoding($ae, $e)
	{
		$this->instance->detectEncoding($ae);

		// Test the assertions.
		$this->assertEquals($e, $this->instance->getEncodings(), 'Encoding detection failed');
	}

	/**
	 * Tests the \Windwalker\Environment\Browser\Browser::detectEngine method.
	 *
	 * @param   string   $p   The expected device.
	 * @param   boolean  $m   The expected mobile result.
	 * @param   string   $e   The expected engine.
	 * @param   string   $b   The expected browser.
	 * @param   string   $v   The expected browser version.
	 * @param   string   $ua  The input user agent.
	 *
	 * @return  void
	 *
	 * @dataProvider userAgent_Provider
	 * @since   2.0
	 */
	public function testDetectEngine($p, $m, $e, $b, $v, $ua)
	{
		$this->instance->detectEngine($ua);

		// Test the assertion.
		$this->assertEquals($e, $this->instance->getEngine(), 'Engine detection failed: ' . $ua);
	}

	/**
	 * Tests the \Windwalker\Environment\Browser\Browser::detectLanguage method.
	 *
	 * @param   string  $al  The input accept language.
	 * @param   array   $l   The expected array of languages.
	 *
	 * @return  void
	 *
	 * @dataProvider getLanguageData
	 * @since   2.0
	 */
	public function testDetectLanguage($al, $l)
	{
		$this->instance->detectLanguage($al);

		// Test the assertions.
		$this->assertEquals($l, $this->instance->getLanguages(), 'Language detection failed');
	}

	/**
	 * Tests the \Windwalker\Environment\Browser\Browser::detectPlatform method.
	 *
	 * @param   string   $p   The expected device.
	 * @param   boolean  $m   The expected mobile result.
	 * @param   string   $e   The expected engine.
	 * @param   string   $b   The expected browser.
	 * @param   string   $v   The expected browser version.
	 * @param   string   $ua  The input user agent.
	 *
	 * @return  void
	 *
	 * @dataProvider userAgent_Provider
	 * @since   2.0
	 */
	public function testDetectPlatform($p, $m, $e, $b, $v, $ua)
	{
		$this->instance->detectDevice($ua);

		// Test the assertions.
		$this->assertEquals($this->instance->isMobile(), $m, 'Mobile detection failed.');
		$this->assertEquals($this->instance->getDevice(), $p, 'Platform detection failed.');
	}

	/**
	 * Tests the \Windwalker\Environment\Browser\Browser::detectRobot method.
	 *
	 * @param   string   $userAgent  The user agent
	 * @param   boolean  $expected   The expected results of the function
	 *
	 * @return  void
	 *
	 * @dataProvider detectRobotData
	 * @since   2.0
	 */
	public function testDetectRobot($userAgent, $expected)
	{
		$this->instance->detectRobot($userAgent);

		// Test the assertions.
		$this->assertEquals($this->instance->isRobot(), $expected, 'Robot detection failed');
	}
}
