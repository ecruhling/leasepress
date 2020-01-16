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
function l_get_settings() {
	return apply_filters( 'l_get_settings', get_option( L_TEXTDOMAIN . '-settings' ) );
}
