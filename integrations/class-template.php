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
 * This class contain the Templating stuff for the frontend
 */
class LP_Template extends LP_Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
        parent::initialize();
		// Override the template hierarchy for load /templates/content-demo.php
		add_filter( 'template_include', array( __CLASS__, 'load_content_demo' ) );
	}

	/**
	 * Example for override the template system on the frontend
	 *
	 * @param string $original_template The original template HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function load_content_demo( $original_template ) {
		if ( is_singular( 'demo' ) && in_the_loop() ) {
			return wpbp_get_template_part( LP_TEXTDOMAIN, 'content', 'demo', false );
		}

		return $original_template;
	}

}
