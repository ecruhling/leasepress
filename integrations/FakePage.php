<?php
/**
 * LeasePress
 *
 * @package   LeasePress
 * @author    Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link      https://resourceatlanta.com
 */

namespace LeasePress\Integrations;

use Fake_Page;
use LeasePress\Engine\Base;

/**
 * Fake Pages inside WordPress
 *
 * @noinspection PhpUnused
 */
class FakePage extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();
		new Fake_Page(
			array(
				'slug'         => 'fake_slug',
				'post_title'   => 'Fake Page Title',
				'post_content' => 'This is the fake page content',
			)
		);
	}

}
