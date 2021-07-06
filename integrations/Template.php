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

use LeasePress\Engine\Base;
use function add_filter;
use function in_the_loop;
use function is_singular;
use function wpbp_get_template_part;

/**
 * Load custom template files
 */
class Template extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();
		// Override the template hierarchy for load /templates/content-demo.php.
		add_filter( 'template_include', array( self::class, 'load_content_demo' ) );
	}

	/**
	 * Example for override the template system on the frontend
	 *
	 * @param string $original_template The original template HTML.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public static function load_content_demo( string $original_template ): string {
		if ( is_singular( 'demo' ) && in_the_loop() ) {
			return wpbp_get_template_part( 'leasepress', 'content', 'demo', false );
		}

		return $original_template;
	}

}
