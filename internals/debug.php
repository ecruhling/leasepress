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

$l_debug = new WPBP_Debug( __( 'Plugin Name', LP_TEXTDOMAIN ) );

function l_log( $text ) {
	global $l_debug;
	$l_debug->log( $text );
}

