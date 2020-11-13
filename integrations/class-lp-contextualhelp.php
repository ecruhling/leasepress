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
 * This class contain the contextual help code.
 */
class LP_ContextualHelp {

	/**
	 * Initialize the Contextual Help
	 */
	public function initialize() {
		add_filter( 'wp_contextual_help_docs_dir', array( $this, 'help_docs_dir' ) );
		add_filter( 'wp_contextual_help_docs_url', array( $this, 'help_docs_url' ) );
		add_action( 'init', array( $this, 'contextual_help' ) );
	}

	/**
	 * Filter for change the folder of Contextual Help
	 *
	 * @param array $paths The path.
	 *
	 * @return array The path.
	 * @since 1.0.0
	 */
	public function help_docs_dir( array $paths ) {
		$paths[] = plugin_dir_path( __FILE__ ) . 'help-docs/';

		return $paths;
	}

	/**
	 * Filter for change the folder image of Contextual Help
	 *
	 * @param array $paths The path.
	 *
	 * @return array the path
	 * @since 1.0.0
	 */
	public function help_docs_url( array $paths ) {
		$paths[] = plugin_dir_path( __FILE__ ) . 'help-docs/img';

		return $paths;
	}

	/**
	 * Contextual Help, docs in /help-docs folter
	 * Documentation https://github.com/kevinlangleyjr/wp-contextual-help
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function contextual_help() {
		WP_Contextual_Help::init();
		// Only display on the pages - post.php and post-new.php, but only on the `demo` post_type.
		WP_Contextual_Help::register_tab(
			'demo-example',
			__( 'Demo Management', 'leasepress' ),
			array(
				'page'      => array( 'post.php', 'post-new.php' ),
				'post_type' => 'demo',
				'wpautop'   => true,
			)
		);

		// Add to a custom plugin settings page.
		WP_Contextual_Help::register_tab(
			'lp_settings',
			__( 'Boilerplate Settings', 'leasepress' ),
			array(
				'page'    => 'settings_page_leasepress',
				'wpautop' => true,
			)
		);
	}

}
