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

namespace LeasePress\Backend;

use LeasePress\Engine\Base;
use PointerPlus;
use function __;
use function add_filter;
use function array_merge;

/**
 * All the WP pointers.
 */
class Pointers extends Base {

	/**
	 * Initialize the Pointers.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function initialize() {
		parent::initialize();

		new PointerPlus( array( 'prefix' => 'leasepress' ) );
		add_filter( 'leasepress-pointerplus_list', array( $this, 'custom_initial_pointers' ), 10, 2 );
	}

	/**
	 * Add pointers.
	 * Check on https://github.com/Mte90/pointerplus/blob/master/pointerplus.php for examples
	 *
	 * @param array  $pointers The list of pointers.
	 * @param string $prefix For your pointers.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function custom_initial_pointers( array $pointers, string $prefix ): array {
		return array_merge(
			$pointers,
			array(
				$prefix . '_contextual_help' => array(
					'selector'   => '#show-settings-link',
					'title'      => __( 'Boilerplate Help', 'leasepress' ),
					'text'       => __( 'A pointer for help tab.<br>Go to Posts, Pages or Users for other pointers.', 'leasepress' ),
					'edge'       => 'top',
					'align'      => 'left',
					'icon_class' => 'dashicons-welcome-learn-more',
				),
			)
		);
	}

}
