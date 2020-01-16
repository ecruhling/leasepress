<?php

/**
 * Plugin_name
 *
 * @package   Plugin_name
 * @author    Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link      https://resourceatlanta.com
 */

/**
 * This class is the base skeleton of the plugin
 */
class L_Admin_Base extends L_Base {

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

