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
		$post_columns = new CPT_columns( 'demo' );
		$post_columns->add_column( 'cmb2_field', array(
				'label'    => __( 'CMB2 Field', LP_TEXTDOMAIN ),
				'type'     => 'post_meta',
				'meta_key' => '_demo_' . LP_TEXTDOMAIN . '_text',
				'orderby'  => 'meta_value',
				'sortable' => true,
				'prefix'   => '<b>',
				'suffix'   => '</b>',
				'def'      => 'Not defined', // Default value in case post meta not found
				'order'    => '-1',
			)
		);
		/*
		 * Custom Bulk Actions
		 */
		$bulk_actions = new Seravo_Custom_Bulk_Action( array( 'post_type' => 'demo' ) );
		$bulk_actions->register_bulk_action(
			array(
				'menu_text'    => 'Mark meta',
				'admin_notice' => 'Written something on custom bulk meta',
				'callback'     => function( $post_ids ) {
					foreach ( $post_ids as $post_id ) {
						update_post_meta( $post_id, '_demo_' . LP_TEXTDOMAIN . '_text', 'Random stuff' );
					}

					return true;
				},
			)
		);
		$bulk_actions->init();
		// Add bubble notification for cpt pending
		add_action( 'admin_menu', array( $this, 'pending_cpt_bubble' ), 999 );
		add_filter( 'pre_get_posts', array( $this, 'filter_search' ) );
	}

	/**
	 * Add support for custom CPT on the search box
	 *
	 * @param object $query Wp_Query.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function filter_search( $query ) {
		if ( $query->is_search && !is_admin() ) {
			$post_types = $query->get( 'post_type' );
			if ( $post_types === 'post' ) {
				$post_types = array( $post_types );
				$query->set( 'post_type', array_push( $post_types, array( 'demo' ) ) );
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
		// Create Custom Post Type https://github.com/johnbillion/extended-cpts/wiki
		$tax = register_extended_post_type( 'demo', array(
			// Show all posts on the post type archive:
			'archive' => array(
				'nopaging' => true
			),
			'slug'            => 'demo',
			'show_in_rest'    => true,
			'dashboard_activity' => true,
			'capability_type' => array( 'demo', 'demoes' ),
			// Add some custom columns to the admin screen:
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Featured Image',
					'featured_image' => 'thumbnail'
				),
				'title',
				'genre' => array(
					'taxonomy' => 'demo-section'
				),
				'custom_field' => array(
					'title' => 'By Lib',
					'meta_key' => '_demo_' . LP_TEXTDOMAIN . '_text',
					'cap'      => 'manage_options',
				),
				'date' => array(
					'title' => 'Date',
					'default' => 'ASC',
				),
			),
			# Add a dropdown filter to the admin screen:
			'admin_filters' => array(
				'genre' => array(
					'taxonomy' => 'demo-section'
				)
			)
		), array(
			# Override the base names used for labels:
			'singular' => __( 'Demo', LP_TEXTDOMAIN ),
			'plural'   => __( 'Demos', LP_TEXTDOMAIN ),
		)
		);

		$tax->add_taxonomy( 'demo-section', array(
			'hierarchical' => false,
			'show_ui' => false,
		) );
		// Create Custom Taxonomy https://github.com/johnbillion/extended-taxos
		register_extended_taxonomy( 'demo-section', 'demo', array(
			// Use radio buttons in the meta box for this taxonomy on the post editing screen:
			'meta_box'         => 'radio',
			// Show this taxonomy in the 'At a Glance' dashboard widget:
			'dashboard_glance' => true,
			// Add a custom column to the admin screen:
			'admin_cols'       => array(
				'featured_image' => array(
					'title'          => 'Featured Image',
					'featured_image' => 'thumbnail'
				),
			),
			'slug'             => 'demo-cat',
			'show_in_rest'     => true,
			'capabilities'     => array(
				'manage_terms' => 'manage_demoes',
				'edit_terms'   => 'manage_demoes',
				'delete_terms' => 'manage_demoes',
				'assign_terms' => 'read_demo',
			),
		), array(
			// Override the base names used for labels:
			'singular' => __( 'Demo Category', LP_TEXTDOMAIN ),
			'plural'   => __( 'Demo Categories', LP_TEXTDOMAIN ),
		)
		);
	}

	/**
	 * Bubble Notification for pending cpt<br>
	 * NOTE: add in $post_types your cpts<br>
	 *
	 *        Reference:  http://wordpress.stackexchange.com/questions/89028/put-update-like-notification-bubble-on-multiple-cpts-menus-for-pending-items/95058
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function pending_cpt_bubble() {
		global $menu;

		$post_types = array( 'demo' );
		foreach ( $post_types as $type ) {
			if ( !post_type_exists( $type ) ) {
				continue;
			}

			// Count posts
			$cpt_count = wp_count_posts( $type );

			if ( $cpt_count->pending ) {
				// Locate the key of
				$key = self::recursive_array_search_php( 'edit.php?post_type=' . $type, $menu );

				// Not found, just in case
				if ( !$key ) {
					return;
				}

				// Modify menu item
				$menu[ $key ][ 0 ] .= sprintf(
					'<span class="update-plugins count-%1$s"><span class="plugin-count">%1$s</span></span>', $cpt_count->pending
				);
			}
		}
	}

	/**
	 * Required for the bubble notification<br>
	 *
	 *        Reference:  http://wordpress.stackexchange.com/questions/89028/put-update-like-notification-bubble-on-multiple-cpts-menus-for-pending-items/95058
	 *
	 * @param string $needle   First parameter.
	 * @param array  $haystack Second parameter.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed
	 */
	private function recursive_array_search_php( $needle, $haystack ) {
		foreach ( $haystack as $key => $value ) {
			$current_key = $key;
			if ( $needle === $value || ( is_array( $value ) && self::recursive_array_search_php( $needle, $value ) !== false ) ) {
				return $current_key;
			}
		}

		return false;
	}

}
