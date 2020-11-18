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
 * Utility function to fix extension if needed.
 *
 * @param string $original_extension the original file extension.
 * @param string $filename the filename.
 *
 * @return string
 */
function fix_extension_if_needed( string $original_extension, string $filename ) {
	if ( extension_is_too_small( $original_extension ) ) {
		return get_extension_from_filename( $filename );
	}

	return $original_extension;
}

/**
 * Utility function to check length of extension.
 *
 * @param string $extension the extension.
 *
 * @return bool
 */
function extension_is_too_small( string $extension ) {
	return ( strlen( $extension ) < 1 );
}

/**
 * Utility function to get the extension from the filename.
 *
 * @param string $filename the filename.
 *
 * @return mixed|string
 */
function get_extension_from_filename( string $filename ) {
	$parts       = explode( '.', $filename );
	$lower_parts = array_map( 'strtolower', $parts );
	$last_part   = array_pop( $lower_parts );

	if ( dual_part_extension( $last_part ) ) {
		$penultimate_part = array_pop( $lower_parts );

		return "{$penultimate_part}.{$last_part}";
	} elseif ( has_no_extension( $filename ) ) {
		return '';
	}

	return $last_part;
}

/**
 * Utility function for dual part extensions.
 *
 * @param string $extension the extension.
 *
 * @return bool
 */
function dual_part_extension( string $extension ) {
	return in_array(
		$extension,
		array(
			'gz',
			'xz',
			'bz2',
		),
		true
	);
}

/**
 * Utility function; check if file has no extension.
 *
 * @param string $filename the filename.
 *
 * @return bool
 */
function has_no_extension( string $filename ) {
	return (
		( strpos( $filename, '.', 0 ) === false )
		||
		(
			( substr_count( $filename, '.' ) < 2 )
			&&
			is_dot_file( $filename )
		)
	);
}

/**
 * Utility function; check if dot is in filename.
 *
 * @param string $filename the filename.
 *
 * @return bool
 */
function is_dot_file( string $filename ) {
	return ( strpos( $filename, '.', 0 ) === 0 );
}

/**
 * Enable SVG support
 */
class LP_SVG_Support {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'add_svg_upload' ), 75 );
		add_action( 'admin_head', array( $this, 'custom_admin_css' ), 75 );
		add_action( 'load-post.php', array( $this, 'add_editor_styles' ), 75 );
		add_action( 'load-post-new.php', array( $this, 'add_editor_styles' ), 75 );
		add_action( 'after_setup_theme', array( $this, 'theme_prefix_setup' ), 75 );
		add_filter( 'wp_check_filetype_and_ext', array( $this, 'fix_mime_type_svg' ), 75, 4 );
		add_filter( 'wp_update_attachment_metadata', array( $this, 'ensure_svg_metadata' ), 10, 2 );
	}

	/**
	 * Custom CSS to be injected. Fixes the display of SVG images.
	 * Used in a multiple places.
	 */
	protected function custom_css() {
		echo 'img[src$=".svg"]:not(.emoji) { width: 100% !important; height: auto !important; }';
	}

	/**
	 * Allow SVG files to be uploaded.
	 */
	public function add_svg_upload() {
		add_action( 'wp_ajax_adminlc_mce_svg.css', array( $this, 'tiny_mce_svg_css' ), 10 );
		add_filter( 'image_send_to_editor', array( $this, 'remove_dimensions_svg' ), 10, 1 );
		add_filter( 'upload_mimes', array( $this, 'filter_mimes' ), 10, 1 );
	}

	/**
	 * Inject Custom CSS into the Tiny MCE Editor.
	 */
	public function tiny_mce_svg_css() {
		header( 'Content-type: text/css' );
		$this->custom_css();
		exit();
	}

	/**
	 * Remove the dimensions from SVG images.
	 *
	 * @param string $html HTML markup; image dimensions.
	 *
	 * @return string|string[]
	 */
	public function remove_dimensions_svg( $html = '' ) {
		return str_ireplace( array( ' width=\"1\"', ' height=\"1\"' ), '', $html );
	}

	/**
	 * Add the SVG mime type.
	 *
	 * @param array $mimes A list of mime types.
	 *
	 * @return array|mixed
	 */
	public function filter_mimes( $mimes = array() ) {
		$mimes['svg'] = 'image/svg+xml';

		return $mimes;
	}

	/**
	 * Inject Custom CSS into the backend (Admin).
	 */
	public function custom_admin_css() {
		echo '<style>';
		$this->custom_css();
		echo '</style>';
	}

	/**
	 * Add & filter CSS in the editor.
	 */
	public function add_editor_styles() {
		add_filter( 'mce_css', array( $this, 'filter_mce_css' ) );
	}

	/**
	 * Filter MCE CSS
	 *
	 * @param string $mce_css the CSS.
	 *
	 * @return string
	 */
	public function filter_mce_css( string $mce_css ) {
		$mce_css .= ', ' . get_admin_url( 'admin-ajax.php?action=adminlc_mce_svg.css' );

		return $mce_css;
	}

	/**
	 * Fix for SVG custom logo display in Theme Customizer.
	 */
	public function theme_prefix_setup() {
		$existing = get_theme_support( 'custom-logo' );
		if ( $existing ) {
			$existing                = current( $existing );
			$existing['flex-width']  = true;
			$existing['flex-height'] = true;
			add_theme_support( 'custom-logo', $existing );
		}
	}

	/**
	 * Fixes for SVG mime type.
	 *
	 * @param null $data file data.
	 * @param null $file the file.
	 * @param null $filename the filename.
	 * @param null $mimes mime types list.
	 *
	 * @return mixed|null
	 */
	public function fix_mime_type_svg( $data = null, $file = null, $filename = null, $mimes = null ) {
		$original_extension = ( isset( $data['ext'] ) ? $data['ext'] : '' );
		$ext                = fix_extension_if_needed( $original_extension, $filename );
		if ( 'svg' === $ext ) {
			$data['type'] = 'image/svg+xml';
			$data['ext']  = 'svg';
		}

		return $data;
	}

	/**
	 * Ensure that the metadata associated with the SVG file is correct.
	 *
	 * @param array  $data the data.
	 * @param string $id the ID.
	 *
	 * @return mixed
	 */
	public function ensure_svg_metadata( array $data, string $id ) {
		$attachment = get_post( $id );
		$mime_type  = $attachment->post_mime_type;
		if ( 'image/svg+xml' === $mime_type ) {
			if ( $this->missing_or_invalid_svg_dimensions( $data ) ) {
				$xml  = simplexml_load_file( get_attached_file( $id ) );
				$attr = $xml->attributes();
				// @codingStandardsIgnoreStart (viewBox is the correct name and cannot be changed)
				$view_box = explode( ' ', $attr->viewBox );
				// @codingStandardsIgnoreEnd
				$this->fill_svg_dimensions( $view_box, $attr, $data, 'width', 2 );
				$this->fill_svg_dimensions( $view_box, $attr, $data, 'height', 3 );
			}
		}

		return $data;
	}

	/**
	 * Check for missing or invalid SVG dimensions.
	 *
	 * @param array $data the data.
	 *
	 * @return bool
	 */
	protected function missing_or_invalid_svg_dimensions( array $data ) {
		if ( ! is_array( $data ) ) {
			return true;
		}
		if ( ! isset( $data['width'] ) || ! isset( $data['height'] ) ) {
			return true;
		}
		if ( is_nan( $data['width'] ) || is_nan( $data['height'] ) ) {
			return true;
		}

		return (
			empty( $data ) || empty( $data['width'] ) || empty( $data['height'] )
			||
			intval( $data['width'] < 1 ) || intval( $data['height'] < 1 )
		);
	}

	/**
	 * Create all the SVG dimensions.
	 *
	 * @param array   $viewbox which image in the view are we looking at?.
	 * @param object  $attr image attributes.
	 * @param array   $data the data.
	 * @param integer $dimension the image dimensions.
	 * @param integer $viewboxoffset the image offset in list.
	 */
	protected function fill_svg_dimensions( array $viewbox, $attr, array &$data, int $dimension, int $viewboxoffset ) {
		if ( isset( $attr->{$dimension} ) ) {
			$data[ $dimension ] = intval( $attr->{$dimension} );
		}
		if ( ! isset( $data[ $dimension ] ) ) {
			$data[ $dimension ] = 0;
		}
		if ( is_nan( $data[ $dimension ] ) ) {
			$data[ $dimension ] = 0;
		}
		if ( $data[ $dimension ] < 1 ) {
			$data[ $dimension ] = count( $viewbox ) === 4 ? intval( $viewbox[ $viewboxoffset ] ) : null;
		}
	}

}

