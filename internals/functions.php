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
 * Get the settings of the plugin in a filterable way
 *
 * @return array
 */
function lp_get_settings() {
	return apply_filters( 'lp_get_settings', get_option( LP_TEXTDOMAIN . '-settings' ) );
}
