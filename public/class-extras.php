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
 * This class contain all the snippet or extra that improve the experience on the frontend
 */
class LP_Extras extends LP_Base {

	/**
	 * Initialize the snippet
	 */
	public function initialize() {
		parent::initialize();
		add_filter( 'body_class', array( __CLASS__, 'add_lp_class' ), 10, 3 );
	}

	/**
	 * Add class in the body on the frontend
	 *
	 * @param array $classes The array with all the classes of the page.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function add_lp_class( $classes ) {
		$classes[] = LP_TEXTDOMAIN;
		return $classes;
	}

}
