<?php
/**
 * LeasePress
 *
 * @package   LeasePress
 * @author    Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link      https://resourceatlanta.com
 * @noinspection PhpUnused
 */

namespace LeasePress\Internals;

use WP_Super_Duper;
use function __;
use function add_action;
use function esc_html__;
use function extract; // phpcs:ignore
use function register_widget;

/**
 * Create Shortcode and Gutenberg Block with Widget support
 */
class ShortCodeBlock extends WP_Super_Duper {

	/**
	 * Parameters shared between methods
	 *
	 * @var array
	 */
	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$options = array(
			'block-icon'     => 'fas fa-globe-americas',
			'block-category' => 'widgets',
			'block-keywords' => "['placeholder']",
			'block-output'   => array( // the block visual output elements as an array.
				array(
					'element' => 'p',
					'title'   => __( 'Placeholder', 'leasepress' ),
					'class'   => '[%className%]',
					'content' => 'Hello: [%after_text%]', // block properties can be added by wrapping them in [%name%].
				),
			),
			'block-wrap'     => '',
			// You can specify the type of element to wrap the block `div` or `span` etc.. Or blank for no wrap at all.
			'class_name'     => self::class,
			// The calling class name.
			'base_id'        => 'placeholder_leasepress_block',
			// this is used as the widget id and the shortcode id.
			'name'           => __( 'Placeholder', 'leasepress' ),
			// the name of the widget/block.
			'widget_ops'     => array(
				'classname'   => 'leasepress-placeholder-class',
				// widget class.
				'description' => esc_html__( 'This is an example that will take a text parameter and output it after `Hello:`.', 'leasepress' ),
				// widget description.
			),
			'no_wrap'        => true,
			// This will prevent the widget being wrapped in the containing widget class div.
			'arguments'      => array( // these are the arguments that will be used in the widget, shortcode and block settings.
				'after_text' => array( // this is the input name=''.
					'title'       => __( 'Text after hello:', 'leasepress' ),
					// input title.
					'desc'        => __( 'This is the text that will appear after `Hello:`.', 'leasepress' ),
					// input description.
					'type'        => 'text',
					// the type of input, test, select, checkbox etc.
					'placeholder' => 'Test',
					// the input placeholder text.
					'desc_tip'    => true,
					// if the input should show the widget description text as a tooltip.
					'default'     => 'Test',
					// the input default value.
					'advanced'    => false,
					// not yet implemented.
				),
			),
		);

		parent::__construct( $options );
	}

	/**
	 * This is the output function for the widget, shortcode and block (front end).
	 *
	 * @param array  $args The arguments values.
	 * @param array  $widget_args The widget arguments when used.
	 * @param string $content The shortcode content argument.
	 *
	 * @return string
	 */
	public function output( $args = array(), $widget_args = array(), $content = '' ): string {
		$after_text    = '';
		$another_input = '';

		extract( $args, EXTR_SKIP ); // phpcs:ignore

		return 'Hello: ' . $after_text . '' . $another_input;
	}

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		// To enable as a widget.
		add_action(
			'widgets_init',
			static function () {
				register_widget( 'LeasePress\Internals\ShortCodeBlock' );
			}
		);
	}

}
