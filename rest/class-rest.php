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
 * This class contain the Rest stuff
 */
class LP_Rest extends LP_Base {

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
     * @since 1.0.0
     *
     * @return void
     */
    public function add_custom_stuff() {
        $this->add_custom_field();
        $this->add_custom_ruote();
    }

    /**
     * Examples
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function add_custom_field() {
        register_rest_field( 'demo', LP_TEXTDOMAIN . '_text', array(
            'get_callback'    => array( $this, 'get_text_field' ),
            'update_callback' => array( $this, 'update_text_field' ),
            'schema'          => array(
                'description' => __( 'Text field demo of Post type', LP_TEXTDOMAIN ),
                'type'        => 'string',
            ),
        ));
    }

    /**
     * Examples
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function add_custom_ruote() {
        // Only an example with 2 parameters
        register_rest_route( 'wp/v2', '/calc', array(
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
        ) );
    }

    /**
     * Examples
     *
     * @since 1.0.0
     *
     * @param array $post_obj Post ID.
     *
     * @return string
     */
    public function get_text_field( $post_obj ) {
        $post_id = $post_obj['id'];
        return get_post_meta( $post_id, LP_TEXTDOMAIN . '_text', true );
    }

    /**
     * Examples
     *
     * @since 1.0.0
     *
     * @param string $value Value.
     * @param object $post  Post object.
     * @param string $key   Key.
     *
     * @return boolean|WP_Error
     */
    public function update_text_field( $value, $post, $key ) {
        $post_id = update_post_meta( $post->ID, $key, $value );

        if ( false === $post_id ) {
            return new WP_Error(
                'rest_post_views_failed',
                __( 'Failed to update post views.', LP_TEXTDOMAIN ),
                array( 'status' => 500 )
            );
        }

        return true;
    }

    /**
     * Examples
     *
     * @since 1.0.0
     *
     * @param array $data Values.
     *
     * @return array
     */
    public function sum( $data ) {
        return array( 'result' => $data[ 'first' ] + $data[ 'second' ] );
    }

}
