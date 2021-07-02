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

namespace LeasePress\Internals;

use LeasePress\Engine\Base;
use function add_shortcode;
use function shortcode_atts;

/**
 * Shortcodes of this plugin
 */
class Shortcode extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		add_shortcode( 'foobar', array( $this, 'foobar_func' ) );
	}

	/**
	 * Shortcode example
	 *
	 * @param array $atts Parameters.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public static function foobar_func( array $atts ): string {
		shortcode_atts(
			array(
				'foo' => 'something',
				'bar' => 'something else',
			),
			$atts
		);

		return '<span class="foo">foo = ' . $atts['foo'] . '</span><span class="bar">foo = ' . $atts['bar'] . '</span>';
	}

}
