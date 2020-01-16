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
 * Plugin Name Initializer
 */
class L_Initialize {

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Instance of this L_Is_Methods.
	 *
	 * @var object
	 */
	protected $is = null;

	/**
	 * List of class to initialize.
	 *
	 * @var array
	 */
	public $classes = null;

	/**
	 * The Constructor that load the entry classes
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
        $this->is        = new L_Is_Methods();
        $this->classes   = array();
        $this->classes[] = 'L_PostTypes';
        $this->classes[] = 'L_CMB';
        $this->classes[] = 'L_Cron';
        $this->classes[] = 'L_FakePage';
        $this->classes[] = 'L_Template';
		if ( $this->is->request( 'rest' ) ) {
			$this->classes[] = 'L_Rest';
		}
		$this->classes[] = 'L_Transient';
		if ( $this->is->request( 'cli' ) ) {
			$this->classes[] = 'L_WPCli';
		}
		if ( $this->is->request( 'ajax' ) ) {
			$this->classes[] = 'L_Ajax';
		}

		if ( $this->is->request( 'admin_backend' ) ) {
			if ( $this->is->request( 'ajax' ) ) {
				$this->classes[] = 'L_Ajax_Admin';
			}
			$this->classes[] = 'L_Pointers';
			$this->classes[] = 'L_ContextualHelp';
			$this->classes[] = 'L_Admin_ActDeact';
			$this->classes[] = 'L_Admin_Notices';
			$this->classes[] = 'L_Admin_Settings_Page';
			$this->classes[] = 'L_Admin_Enqueue';
			$this->classes[] = 'L_Admin_ImpExp';
		}

		if ( $this->is->request( 'frontend' ) ) {
			$this->classes[] = 'L_Enqueue';
			$this->classes[] = 'L_Extras';
		}

		$this->classes = apply_filters( 'l_class_instances', $this->classes );

		$this->load_classes();
	}

	private function load_classes() {
		foreach ( $this->classes as &$class ) {
			$class = apply_filters( strtolower( $class ) . '_instance', $class );
			$temp  = new $class;
			$temp->initialize();
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			try {
				self::$instance = new self;
			} catch ( Exception $err ) {
				do_action( 'leasepress_initialize_failed', $err );
				if ( WP_DEBUG ) {
					throw $err->getMessage();
				}
			}
		}

		return self::$instance;
	}

}
