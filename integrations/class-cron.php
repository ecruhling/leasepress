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
 * This class contain the Widget stuff
 */
class LP_Cron extends LP_Base {

	/**
	 * Initialize the class
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
        // Schedule the event
		$cronplus->schedule_event();
        // Remove the event by the schedule
        //$cronplus->clear_schedule_by_hook();
        // Jump the scheduled event
        //$cronplus->unschedule_specific_event();
	}

	/**
	 * Cron Hourly example
	 *
	 * @param integer $id The ID.
	 *
	 * @return void
	 */
	public function hourly_cron( $id ) {
		echo esc_html( $id );
	}

}

