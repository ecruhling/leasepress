<?php

define( 'LP_VERSION', '0.0.0' );
define( 'LP_TEXTDOMAIN', 'leasepress' );
define( 'LP_NAME', 'LeasePress' );
define( 'LP_PLUGIN_ROOT', './' );
define( 'LP_PLUGIN_ABSOLUTE', 'leasepress.php' );

define( 'CMB2_DIR', dirname( __DIR__, 2 ) . '/vendor/cmb2/' );
require_once dirname( __DIR__, 2 ) . '/vendor/cmb2/includes/helper-functions.php';
spl_autoload_register( 'cmb2_autoload_classes' );
