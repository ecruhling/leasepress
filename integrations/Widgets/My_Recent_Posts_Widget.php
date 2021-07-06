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

namespace LeasePress\Integrations\Widgets;

use WPH_Widget;
use function __;
use function add_action;
use function register_widget;
use function strlen;

/**
 * Create custom widget class extending WPH_Widget
 */
class My_Recent_Posts_Widget extends WPH_Widget {

	/**
	 * Initialize the widget
	 *
	 * @return void
	 * @noinspection PhpMissingParentConstructorInspection
	 */
	public function __construct() {
		$args = array(
			'label'       => __( 'My Recent Posts Example', 'leasepress' ),
			'description' => __( 'My Recent Posts Widget Description', 'leasepress' ),
			'slug'        => 'recent-posts',
		);

		$args['fields'] = array(
			// Title field.
			array(
				// Field name/label.
				'name'     => __( 'Title', 'leasepress' ),
				// Field description.
				'desc'     => __( 'Enter the widget title.', 'leasepress' ),
				// Field id.
				'id'       => 'title',
				// Field type ( text, checkbox, textarea, select, select-group, taxonomy, taxonomyterm, pages, hidden ).
				'type'     => 'text',
				// Class, rows, cols.
				'class'    => 'widefat',
				// Default value.
				'std'      => __( 'Recent Posts', 'leasepress' ),
				/**
				 * Set the field validation type/s
				 * 'alpha_dash'
				 * Returns FALSE if the value contains anything other than alpha-numeric characters, underscores or dashes.
				 * 'alpha'
				 * Returns FALSE if the value contains anything other than alphabetical characters.
				 * 'alpha_numeric'
				 * Returns FALSE if the value contains anything other than alpha-numeric characters.
				 * 'numeric'
				 * Returns FALSE if the value contains anything other than numeric characters.
				 * 'boolean'
				 * Returns FALSE if the value contains anything other than a boolean value ( true or false ).
				 * You can define custom validation methods. Make sure to return a boolean ( TRUE/FALSE ).
				 * Example:
				 * 'validate' => 'my_custom_validation',
				 * Will call for: $this->my_custom_validation( $value_to_validate );
				 */
				'validate' => 'alpha_dash',
				/**
				 * Filter data before entering the DB
				 * strip_tags ( default )
				 * wp_strip_all_tags
				 * esc_attr
				 * esc_url
				 * esc_textarea
				 */
				'filter'   => 'strip_tags|esc_attr',
			),
			// Taxonomy Field.
			array(
				'name'  => __( 'Taxonomy', 'leasepress' ),
				'desc'  => __( 'Set the taxonomy.', 'leasepress' ),
				'id'    => 'taxonomy',
				'type'  => 'taxonomy',
				'class' => 'widefat',
			),
			// Taxonomy Field.
			array(
				'name'     => __( 'Taxonomy terms', 'leasepress' ),
				'desc'     => __( 'Set the taxonomy terms.', 'leasepress' ),
				'id'       => 'taxonomyterm',
				'type'     => 'taxonomyterm',
				'taxonomy' => 'category',
				'class'    => 'widefat',
			),
			// Pages Field.
			array(
				'name'  => __( 'Pages', 'leasepress' ),
				'desc'  => __( 'Set the page.', 'leasepress' ),
				'id'    => 'pages',
				'type'  => 'pages',
				'class' => 'widefat',
			),
			// Post type Field.
			array(
				'name'     => __( 'Post type', 'leasepress' ),
				'desc'     => __( 'Set the post type.', 'leasepress' ),
				'id'       => 'posttype',
				'type'     => 'posttype',
				'posttype' => 'post',
				'class'    => 'widefat',
			),
			// Amount Field.
			array(
				'name'     => __( 'Amount', 'leasepress' ),
				'desc'     => __( 'Select how many posts to show.', 'leasepress' ),
				'id'       => 'amount',
				'type'     => 'select',
				// Selectbox fields.
				'fields'   => array(
					array(
						'name'  => __( '1 Post', 'leasepress' ),
						'value' => '1',
					),
					array(
						'name'  => __( '2 Posts', 'leasepress' ),
						'value' => '2',
					),
					array(
						'name'  => __( '3 Posts', 'leasepress' ),
						'value' => '3',
					),

					// Add more options.
				),
				'validate' => 'my_custom_validation',
				'filter'   => 'strip_tags|esc_attr',
			),
			// Output type checkbox.
			array(
				'name'   => __( 'Output as list', 'leasepress' ),
				'desc'   => __( 'Wraps posts with the <li> tag.', 'leasepress' ),
				'id'     => 'list',
				'type'   => 'checkbox',
				// Checked by default:.
				'std'    => 1, // 0 or 1
				'filter' => 'strip_tags|esc_attr',
			),
		);
		// Create widget.
		$this->create_widget( $args );
	}

	/**
	 * Custom validation for this widget
	 *
	 * @param string $value The text.
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public function my_custom_validation( string $value ): bool {
		return strlen( $value ) <= 1;
	}

	/**
	 * Output function
	 *
	 * @param array $args The argument shared to the output from WordPress.
	 * @param array $instance The settings saved.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function widget( $args, $instance ) { //phpcs:ignore
		$out = $args['before_widget'];
		// And here do whatever you want.
		$out .= $args['before_title'];
		$out .= $instance['title'];
		$out .= $args['after_title'];

		// Here you would get the most recent posts based on the selected amount: $instance['amount']
		// Then return those posts on the $out variable ready for the output.
		$out .= '<p>Hey There! </p>';

		$out .= $args['after_widget'];
		echo $out; // phpcs:ignore
	}

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		add_action(
			'widgets_init',
			static function () {
				register_widget( 'LeasePress\Integrations\Widgets\My_Recent_Posts_Widget' );
			}
		);
	}

}
