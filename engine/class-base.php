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
 * This class is the base skeleton of the plugin
 */
class LP_Base {

	/**
	 * The settings of the plugin
	 */
	public $settings = array();

	/**
	 * Initialize the class
	 */
	public function initialize() {
		$this->settings = lp_get_settings();

		return true;
	}

}
