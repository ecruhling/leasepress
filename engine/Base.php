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

namespace LeasePress\Engine;

use function lp_get_settings;

/**
 * Base skeleton of the plugin
 */
class Base {

	/**
	 * The settings of the plugin
	 *
	 * @var $settings array
	 */
	public array $settings = array();

	/**
	 * Initialize the class and get the plugin settings
	 *
	 * @return void|bool
	 */
	public function initialize() {
		$this->settings = lp_get_settings();

		return true;
	}

}
