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
	 * @return bool
	 */
	public function initialize(): bool {
		$this->settings = \lp_get_settings();

		return true;
	}

}
