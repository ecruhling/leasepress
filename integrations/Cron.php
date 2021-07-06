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

namespace LeasePress\Integrations;

use CronPlus;
use LeasePress\Engine\Base;
use function esc_html;

/**
 * The various Cron of this plugin
 */
class Cron extends Base {

	/**
	 * Initialize the class
	 *
	 * @return void
	 */
	public function initialize() {
		/*
		 * Load CronPlus
		 */
		$args = array(
			'recurrence'       => 'hourly',
			'schedule'         => 'schedule',
			'name'             => 'hourly_cron',
			'cb'               => array( $this, 'hourly_cron' ),
			'plugin_root_file' => 'leasepress.php',
		);

		$cronplus = new CronPlus( $args );
		// Schedule the event.
		$cronplus->schedule_event();
		// Remove the event by the schedule.
		// $cronplus->clear_schedule_by_hook();
		// Jump the scheduled event.
		// $cronplus->unschedule_specific_event();.
	}

	/**
	 * Cron Hourly example
	 *
	 * @param int $id The ID.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function hourly_cron( int $id ) {
		echo esc_html( (string) $id );
	}

}

