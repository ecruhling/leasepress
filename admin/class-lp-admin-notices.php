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
		 * Dismissible notice
		 */
		dnh_register_notice(
			'lp_activation_notice',
			'updated',
			'LeasePress activated! Now go to <a href="' . admin_url( 'options-general.php?page=leasepress' ) . '">' . __( 'Settings', 'leasepress' ) . '</a> to configure.',
			'leasepress',
		);

	}

}
