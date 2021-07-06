<?php
/**
 * LeasePress
 *
 * @package   LeasePress
 * @author    Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link      https://resourceatlanta.com
 * @noinspection PhpUnused
 */

namespace LeasePress\Frontend\Extras;

use LeasePress\Engine\Base;
use function add_filter;

/**
 * Add custom css class to <body>
 */
class Body_Class extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		add_filter( 'body_class', array( self::class, 'add_lp_class' ), 10, 3 );
	}

	/**
	 * Add class in the body on the frontend
	 *
	 * @param array $classes The array with all the classes of the page.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public static function add_lp_class( array $classes ): array {
		$classes[] = 'leasepress';

		return $classes;
	}

}
