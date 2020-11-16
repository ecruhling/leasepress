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
 * This class contain the Post Types and Taxonomy initialize code
 */
class LP_PostTypes extends LP_Base {

	/**
	 * Initialize the custom post types
	 */
	public function initialize() {
		parent::initialize();
		add_action( 'init', array( $this, 'load_cpts' ) );

		/*
		 * Custom Columns
		 */
		$post_columns = new CPT_columns( 'lp-floor-plans' );
		$post_columns->add_column(
			'cmb2_field',
			array(
				'label'    => __( 'CMB2 Field', 'leasepress' ),
				'type'     => 'post_meta',
				'orderby'  => 'meta_value',
				'sortable' => true,
				'prefix'   => '<b>',
				'suffix'   => '</b>',
				'def'      => 'Not defined', // Default value in case post meta not found.
				'order'    => '-1',
			)
		);

		/*
		 * Custom Bulk Actions
		 */
		$bulk_actions = new Seravo_Custom_Bulk_Action( array( 'post_type' => 'lp-floor-plans' ) );
		$bulk_actions->register_bulk_action(
			array(
				'menu_text'    => 'Mark meta',
				'admin_notice' => 'Written something on custom bulk meta',
				'callback'     => function ( $post_ids ) {
					foreach ( $post_ids as $post_id ) {
						update_post_meta( $post_id, '_demo_leasepress_text', 'Random stuff' );
					}

					return true;
				},
			)
		);
		$bulk_actions->init();
		// Add bubble notification for CPT pending.
		add_action( 'admin_menu', array( $this, 'pending_cpt_bubble' ), 999 );
		add_filter( 'pre_get_posts', array( $this, 'filter_search' ) );
	}

	/**
	 * Add support for custom CPT on the search box
	 *
	 * @param WP_Query $query WP_Query.
	 *
	 * @return WP_Query
	 * @since 1.0.0
	 */
	public function filter_search( WP_Query $query ) {
		if ( $query->is_search && ! is_admin() ) {
			$post_types = $query->get( 'post_type' );
			if ( 'post' === $post_types ) {
				$post_types = array( $post_types );
				$query->set( 'post_type', array_push( $post_types, array( 'lp-floor-plans' ) ) );
			}
		}

		return $query;
	}

	/**
	 * Load CPT and Taxonomies on WordPress
	 *
	 * @return void
	 */
	public function load_cpts() {
		// Create Custom Post Type https://github.com/johnbillion/extended-cpts/wiki.
		$tax = register_extended_post_type(
			'lp-floor-plans',
			array(
				'archive'            => array(
					'nopaging' => true, // Show all posts on the post type archive.
				),
				'slug'               => 'lp-floor-plans',
				'show_in_rest'       => true,
				'dashboard_activity' => true,
				'menu_icon'          => 'dashicons-screenoptions',
				'admin_cols'         => array( // Add some custom columns to the admin screen.
					'featured_image' => array(
						'title'          => 'Featured Image',
						'featured_image' => 'thumbnail',
					),
					'title',
					'genre'          => array(
						'taxonomy' => 'lp-floor-plan-taxonomy',
					),
					'date'           => array(
						'title'   => 'Date',
						'default' => 'ASC',
					),
				),
				'admin_filters'      => array( // Add a dropdown filter to the admin screen.
					'genre' => array(
						'taxonomy' => 'lp-floor-plan-taxonomy',
					),
				),
			),
			array(
				// Override the base names used for labels.
				'singular' => __( 'Floor Plan', 'leasepress' ),
				'plural'   => __( 'Floor Plans', 'leasepress' ),
			)
		);

		$tax->add_taxonomy(
			'lp-floor-plan-taxonomy',
			array(
				'hierarchical' => false,
				'show_ui'      => false,
			)
		);
		// Create Custom Taxonomy https://github.com/johnbillion/extended-taxos.
		register_extended_taxonomy(
			'lp-floor-plan-taxonomy',
			'lp-floor-plans',
			array(
				// Use radio buttons in the meta box for this taxonomy on the post editing screen.
				'meta_box'         => 'radio',
				// Show this taxonomy in the 'At a Glance' dashboard widget.
				'dashboard_glance' => true,
				// Add a custom column to the admin screen.
				'admin_cols'       => array(
					'featured_image' => array(
						'title'          => 'Featured Image',
						'featured_image' => 'thumbnail',
					),
				),
				'slug'             => 'lp-floor-plan-category',
				'show_in_rest'     => true,
			),
			array(
				// Override the base names used for labels.
				'singular' => __( 'Floor Plan Category', 'leasepress' ),
				'plural'   => __( 'Floor Plan Categories', 'leasepress' ),
			)
		);
	}

	/**
	 * Bubble Notification for pending cpt<br>
	 * NOTE: add in $post_types your cpts<br>
	 *
	 * Reference:  http://wordpress.stackexchange.com/questions/89028/put-update-like-notification-bubble-on-multiple-cpts-menus-for-pending-items/95058
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function pending_cpt_bubble() {
		global $menu;

		$post_types = array( 'lp-floor-plans' );
		foreach ( $post_types as $type ) {
			if ( ! post_type_exists( $type ) ) {
				continue;
			}

			// Count posts.
			$cpt_count = wp_count_posts( $type );

			if ( $cpt_count->pending ) {
				// Locate the key of.
				$key = self::recursive_array_search_php( 'edit.php?post_type=' . $type, $menu );

				// Not found, just in case.
				if ( ! $key ) {
					return;
				}

				// Modify menu item.
				// @codingStandardsIgnoreStart
				$menu[ $key ][0] .= sprintf(
					'<span class="update-plugins count-%1$s"><span class="plugin-count">%1$s</span></span>',
					$cpt_count->pending
				);
				// @codingStandardsIgnoreEnd
			}
		}
	}

	/**
	 * Required for the bubble notification<br>
	 *
	 * Reference:  http://wordpress.stackexchange.com/questions/89028/put-update-like-notification-bubble-on-multiple-cpts-menus-for-pending-items/95058
	 *
	 * @param string $needle First parameter.
	 * @param array  $haystack Second parameter.
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	private function recursive_array_search_php( string $needle, array $haystack ) {
		foreach ( $haystack as $key => $value ) {
			$current_key = $key;
			if ( $needle === $value || ( is_array( $value ) && self::recursive_array_search_php( $needle, $value ) !== false ) ) {
				return $current_key;
			}
		}

		return false;
	}

}
