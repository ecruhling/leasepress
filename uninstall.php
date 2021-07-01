<?php
/**
 * LeasePress
 *
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * @package   LeasePress
 * @author    Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link      https://resourceatlanta.com
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Loop for uninstall
 *
 * @return void
 */
function lp_uninstall_multisite() {
	if ( is_multisite() ) {
		$blogs = get_sites();

		if ( ! empty( $blogs ) ) {
			foreach ( $blogs as $blog ) {
				switch_to_blog( (int) $blog->blog_id );
				lp_uninstall();
				restore_current_blog();
			}

			return;
		}
	}

	lp_uninstall();
}

/**
 * What happens on uninstall?
 *
 * @global WP_Roles $wp_roles
 * @return void
 */
function lp_uninstall() {
	global $wp_roles;
	/*   // phpcs:ignore
	@TODO
	// Delete all transient and options
	delete_transient( 'TRANSIENT_NAME' );
	delete_option( 'OPTION_NAME' );
	remove_role( 'advanced' );
	// Remove custom file directory
	$upload_dir = wp_upload_dir();
	$directory = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . "CUSTOM_DIRECTORY_NAME" . DIRECTORY_SEPARATOR;
	if (is_dir($directory)) {
		foreach(glob($directory.'*.*') as $v){
			unlink($v);
		}
		rmdir($directory);
		// Delete post meta data
		$posts = get_posts(array('posts_per_page' => -1));
		foreach ($posts as $post) {
			$post_meta = get_post_meta($post->ID);
			delete_post_meta($post->ID, 'your-post-meta');
		}
		// Delete user meta data
		$users = get_users();
		foreach ($users as $user) {
			delete_user_meta($user->ID, 'your-user-meta');
		}
		// Remove and optimize tables
		$GLOBALS['wpdb']->query("DROP TABLE `".$GLOBALS['wpdb']->prefix."TABLE_NAME`");
		$GLOBALS['wpdb']->query("OPTIMIZE TABLE `" .$GLOBALS['wpdb']->prefix."options`");
		*/

	// Remove the capabilities of the plugin.
	if ( ! isset( $wp_roles ) ) {
		$wp_roles = new WP_Roles(); // phpcs:ignore
	}

	$caps = array(
		'create_plugins',
		'read_demo',
		'read_private_demos',
		'edit_demo',
		'edit_demos',
		'edit_private_demos',
		'edit_published_demos',
		'edit_others_demos',
		'publish_demos',
		'delete_demo',
		'delete_demos',
		'delete_private_demos',
		'delete_published_demos',
		'delete_others_demos',
		'manage_demos',
	);

	foreach ( $wp_roles as $role ) {
		foreach ( $caps as $cap ) {
			$role->remove_cap( $cap );
		}
	}
}

lp_uninstall_multisite();
