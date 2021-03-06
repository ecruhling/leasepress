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

namespace LeasePress\Rest;

use LeasePress\Engine\Base;
use WP_Error;
use WP_Post;
use WP_REST_Server;
use function add_action;
use function get_post_meta;
use function register_rest_field;
use function register_rest_route;
use function update_post_meta;

/**
 * Example class for REST
 */
class Example extends Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
		parent::initialize();

		add_action( 'rest_api_init', array( $this, 'add_custom_stuff' ) );
	}

	/**
	 * Examples
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function add_custom_stuff() {
		$this->add_custom_field();
		$this->add_custom_route();
	}

	/**
	 * Examples
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function add_custom_field() {
		register_rest_field(
			'demo',
			'leasepress_text',
			array(
				'get_callback'    => array( $this, 'get_text_field' ),
				'update_callback' => array( $this, 'update_text_field' ),
				'schema'          => array(
					'description' => __( 'Text field demo of Post type', 'leasepress' ),
					'type'        => 'string',
				),
			)
		);
	}

	/**
	 * Examples
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function add_custom_route() {
		// Only an example with 2 parameters.
		register_rest_route(
			'wp/v2',
			'/calc',
			array(
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this, 'sum' ),
				'args'     => array(
					'first'  => array(
						'default'           => 10,
						'sanitize_callback' => 'absint',
					),
					'second' => array(
						'default'           => 1,
						'sanitize_callback' => 'absint',
					),
				),
			)
		);
	}

	/**
	 * Examples
	 *
	 * @param array $post_obj Post ID.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function get_text_field( array $post_obj ): string {
		$post_id = $post_obj['id'];

		return get_post_meta( $post_id, 'leasepress_text', true );
	}

	/**
	 * Examples
	 *
	 * @param string  $value Value.
	 * @param WP_Post $post Post object.
	 * @param string  $key Key.
	 *
	 * @return boolean|WP_Error
	 * @since 1.0.0
	 */
	public function update_text_field( string $value, WP_Post $post, string $key ) {
		$post_id = update_post_meta( $post->ID, $key, $value );

		if ( false === $post_id ) {
			return new WP_Error(
				'rest_post_views_failed',
				__( 'Failed to update post views.', 'leasepress' ),
				array( 'status' => 500 )
			);
		}

		return true;
	}

	/**
	 * Examples
	 *
	 * @param array $data Values.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function sum( array $data ): array {
		return array( 'result' => $data['first'] + $data['second'] );
	}

}
