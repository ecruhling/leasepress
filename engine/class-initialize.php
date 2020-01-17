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
 * LeasePress Initializer
 */
class LP_Initialize {

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Instance of this LP_Is_Methods.
	 *
	 * @var object
	 */
	protected $is = null;

	/**
	 * List of classes to initialize.
	 *
	 * @var array
	 */
	public $classes = null;

	/**
	 * The Constructor that loads the entry classes
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
        $this->is        = new LP_Is_Methods();
        $this->classes   = array();
        $this->classes[] = 'LP_PostTypes';
        $this->classes[] = 'LP_CMB';
        $this->classes[] = 'LP_Cron';
        $this->classes[] = 'LP_FakePage';
        $this->classes[] = 'LP_Template';
		if ( $this->is->request( 'rest' ) ) {
			$this->classes[] = 'LP_Rest';
		}
		$this->classes[] = 'LP_Transient';
		if ( $this->is->request( 'cli' ) ) {
			$this->classes[] = 'LP_WPCli';
		}
		if ( $this->is->request( 'ajax' ) ) {
			$this->classes[] = 'LP_Ajax';
		}

		if ( $this->is->request( 'admin_backend' ) ) {
			if ( $this->is->request( 'ajax' ) ) {
				$this->classes[] = 'LP_Ajax_Admin';
			}
			$this->classes[] = 'LP_Pointers';
			$this->classes[] = 'LP_ContextualHelp';
			$this->classes[] = 'LP_Admin_ActDeact';
			$this->classes[] = 'LP_Admin_Notices';
			$this->classes[] = 'LP_Admin_Settings_Page';
			$this->classes[] = 'LP_Admin_Enqueue';
			$this->classes[] = 'LP_Admin_ImpExp';
		}

		if ( $this->is->request( 'frontend' ) ) {
			$this->classes[] = 'LP_Enqueue';
			$this->classes[] = 'LP_Extras';
		}

		$this->classes = apply_filters( 'lp_class_instances', $this->classes );

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
	 * @return object A single instance of this class.
	 * @throws Exception
	 * @since 1.0.0
	 *
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			try {
				self::$instance = new self;
			} catch ( Exception $err ) {
				do_action( 'leasepress_initialize_failed', $err );
				if ( WP_DEBUG ) {
					throw new Exception($err->getMessage());
				}
			}
		}

		return self::$instance;
	}

}
