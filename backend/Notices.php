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
use function __;
use function wpdesk_wp_notice;

/**
 * Everything that involves notification on the WordPress dashboard
 */
class Notices extends Base {

	/**
	 * Initialize the class
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! parent::initialize() ) {
			return;
		}

		wpdesk_wp_notice( 'LeasePress activated. Now go to <a title="LeasePress settings" href="' . admin_url( 'options-general.php?page=leasepress' ) . '">settings</a> to configure.', 'info', true );

	}

}
