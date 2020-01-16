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
class LP_Admin_Base extends LP_Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
		if ( is_admin() ) {
			return parent::initialize();
		}

		return false;
	}

}

