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
 * This class contain all the snippets or extras that improve the experience on the backend
 */
class LP_Admin_Notices extends LP_Admin_Base {

	/**
	 * Initialize the snippet
	 */
	public function initialize() {
		if ( ! parent::initialize() ) {
			return;
		}

		/*
		 * Load Wp_Admin_Notice for the notices in the backend
		 *
		 * First parameter the HTML, the second is the css class
		 */
//		new WP_Admin_Notice( __( 'Updated Messages', 'leasepress' ), 'updated' );
//		new WP_Admin_Notice( __( 'Error Messages', 'leasepress' ), 'error' );

		/*
		 * Dismissible notice
		 */
		dnh_register_notice(
			'lp_activation_notice',
			'updated',
			'LeasePress activated! Now go to <a href="' . admin_url( 'options-general.php?page=leasepress' ) . '">' . __( 'Settings', 'leasepress' ) . '</a> to configure.',
			'leasepress',
		);

		/*
		 * Review Me notice
		 */
//		new WP_Review_Me(
//			array(
//				'days_after' => 15,
//				'type'       => 'plugin',
//				'slug'       => 'leasepress',
//				'rating'     => 5,
//				'message'    => __( 'Review me!', 'leasepress' ),
//				'link_label' => __( 'Click here to review', 'leasepress' ),
//			)
//		);
//		new Yoast_I18n_WordPressOrg_V3(
//			array(
//				'textdomain'  => 'leasepress',
//				'leasepress' => LP_NAME,
//				'hook'        => 'admin_notices',
//			)
//		);
	}

}
