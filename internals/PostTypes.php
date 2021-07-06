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
use CPT_columns;
use Seravo_Custom_Bulk_Action;
use WP_Query;
use function __;
use function add_action;
use function add_filter;
use function array_push;
use function is_admin;
use function is_array;
use function post_type_exists;
use function register_extended_post_type;
use function sprintf;
use function update_post_meta;
use function wp_count_posts;

/**
 * This class contain the Post Types and Taxonomy initialize code
 */
class PostTypes extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
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
				'meta_key' => '_demo_leasepress_text', // phpcs:ignore WordPress.DB
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
		$bulk_actions = new Seravo_Custom_Bulk_Action( array( 'post_type' => 'demo' ) );
		$bulk_actions->register_bulk_action(
			array(
				'menu_text'    => 'Mark meta',
				'admin_notice' => 'Written something on custom bulk meta',
				'callback'     => static function ( $post_ids ) {
					foreach ( $post_ids as $post_id ) {
						update_post_meta( $post_id, '_demo_leasepress_text', 'Random stuff' );
					}

					return true;
				},
			)
		);
		$bulk_actions->init();

		// Add CPT metaboxes.
		add_action( 'cmb2_init', array( $this, 'lp_add_floor_plans_metaboxes' ) );

		// Add bubble notification for cpt pending.
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
	public function filter_search( WP_Query $query ): WP_Query {
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
	 * Create Floor Plans CPT
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function load_cpts() {
		// Create Custom Post Type https://github.com/johnbillion/extended-cpts/wiki.
		register_extended_post_type(
			'lp-floor-plans',
			array(
				'archive'            => array(
					'nopaging' => true, // Show all posts on the post type archive.
				),
				'slug'               => 'lp-floor-plans',
				'show_in_rest'       => true,
				'block_editor'       => false,
				'dashboard_glance'   => false,
				'dashboard_activity' => false,
				'enter_title_here'   => 'Floor Plan Name',
				'show_in_feed'       => false,
				'supports'           => array( 'title', 'editor', 'custom-fields', 'revisions' ),
				'menu_icon'          => 'dashicons-screenoptions',
				'admin_cols'         => array(
					'title',
					// @codingStandardsIgnoreStart (These are meta_key queries and WPCS doesn't like meta_key queries)
					'lp_beds'              => array(
						'title'    => 'Beds',
						'meta_key' => 'lp_beds',
					),
					'lp_baths'             => array(
						'title'    => 'Baths',
						'meta_key' => 'lp_baths',
					),
					'lp_unit_type_mapping' => array(
						'title'    => 'Unit Type Mapping',
						'meta_key' => 'lp_unit_type_mapping',
						// @codingStandardsIgnoreEnd
					),
					'date'                 => array(
						'title'   => 'Date',
						'default' => 'ASC',
					),
				),
			),
			array(
				'singular' => __( 'Floor Plan', 'leasepress' ),
				'plural'   => __( 'Floor Plans', 'leasepress' ),
			)
		);
	}

	/**
	 * Add CMB2 Custom Metaboxes
	 */
	public function lp_add_floor_plans_metaboxes() {

		$cmb = new_cmb2_box(
			array(
				'id'           => 'lp_floor_plans_rentcafe_data_fields',
				'title'        => __( 'RENTCafe Data Fields', 'leasepress' ),
				'object_types' => array( 'lp-floor-plans' ),
				'context'      => 'after_title',
				'priority'     => 'high',
				'show_names'   => true,
				'cmb_styles'   => false,
			)
		);

		$cmb->add_field(
			array(
				'name' => __( 'Unit Type Mapping', 'leasepress' ),
				'id'   => 'lp_unit_type_mapping',
				'type' => 'text',
			)
		);

		$cmb->add_field(
			array(
				'name' => __( 'Beds', 'leasepress' ),
				'id'   => 'lp_beds',
				'type' => 'text',
			)
		);

		$cmb->add_field(
			array(
				'name' => __( 'Baths', 'leasepress' ),
				'id'   => 'lp_baths',
				'type' => 'text',
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

			if ( ! $cpt_count->pending ) {
				continue;
			}

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
		}
	}

	/**
	 * Required for the bubble notification
	 *
	 * Reference:  http://wordpress.stackexchange.com/questions/89028/put-update-like-notification-bubble-on-multiple-cpts-menus-for-pending-items/95058
	 *
	 * @param string $needle First parameter.
	 * @param array $haystack Second parameter.
	 *
	 * @return false|int|string
	 * @since 1.0.0
	 */
	private function recursive_array_search_php( string $needle, array $haystack ) {
		foreach ( $haystack as $key => $value ) {
			$current_key = $key;

			if (
				$needle === $value ||
				( is_array( $value ) &&
				  false !== self::recursive_array_search_php( $needle, $value ) )
			) {
				return $current_key;
			}
		}

		return false;
	}

}
