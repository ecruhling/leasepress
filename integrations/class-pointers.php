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
 * All the WP pointers.
 */
class L_Pointers extends L_Base {

	/**
	 * Initialize the Pointers.
	 *
	 * @since 1.0.0
	 */
	public function initialize() {
        parent::initialize();
		new PointerPlus( array( 'prefix' => L_TEXTDOMAIN ) );
		add_filter( L_TEXTDOMAIN . '-pointerplus_list', array( $this, 'custom_initial_pointers' ), 10, 2 );
	}

	/**
	 * Add pointers.
	 * Check on https://github.com/Mte90/pointerplus/blob/master/pointerplus.php for examples
	 *
	 * @param array $pointers The list of pointers.
	 * @param string $prefix   For your pointers.
	 *
	 * @return mixed
	 */
	public function custom_initial_pointers( $pointers, $prefix ) {
		return array_merge( $pointers, array(
			$prefix . '_contextual_tab' => array(
				'selector'   => '#contextual-help-link',
				'title'      => __( 'Boilerplate Help', L_TEXTDOMAIN ),
				'text'       => __( 'A pointer for help tab.<br>Go to Posts, Pages or Users for other pointers.', L_TEXTDOMAIN ),
				'edge'       => 'top',
				'align'      => 'right',
				'icon_class' => 'dashicons-welcome-learn-more',
			),
		) );
	}

}

new L_Pointers();
