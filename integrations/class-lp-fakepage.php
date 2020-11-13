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

/**
 * This class contain the Fake Page
 */
class LP_FakePage extends LP_Base {

	/**
	 * Initialize the class
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
