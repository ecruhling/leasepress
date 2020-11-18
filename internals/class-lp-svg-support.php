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
 * Enable SVG support
 */
class LP_SVG_Support {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'add_svg_support' ) );
		add_action( 'admin_footer', array( $this, 'fix_svg_thumbnail_size' ) );
		add_filter( 'upload_mimes', array( $this, 'add_svg_mime' ) );
		add_filter( 'wp_check_filetype_and_ext', array( $this, 'wp_check_filetype_and_ext' ), 100, 4 );
		add_filter( 'wp_generate_attachment_metadata', array( $this, 'wp_generate_attachment_metadata' ), 10, 2 );
		add_filter( 'fl_module_upload_regex', array( $this, 'fl_module_upload_regex' ), 10, 4 );
	}

	/**
	 * Filter function for Beaver Builder
	 *
	 * @param array  $regex regular expression.
	 * @param string $ext extension.
	 *
	 * @return mixed
	 */
	public function fl_module_upload_regex( array $regex, string $ext ) {
		if ( 'svg' === $ext || 'svgz' === $ext ) {
			$regex['photo'] = str_replace( '|png|', '|png|svgz?|', $regex['photo'] );
		}

		return $regex;
	}

	/**
	 * Fix the thumbnail size of the SVG
	 */
	public function fix_svg_thumbnail_size() {
		echo '<style>.attachment-info .thumbnail img[src$=".svg"],#postimagediv .inside img[src$=".svg"]{width:100%}</style>';
	}

	/**
	 * Generate the correct attachment metadata of the SVG
	 *
	 * @param array  $metadata image metadata.
	 * @param string $attachment_id attachment ID.
	 *
	 * @return mixed
	 */
	public function wp_generate_attachment_metadata( array $metadata, string $attachment_id ) {
		if ( get_post_mime_type( $attachment_id ) === 'image/svg+xml' ) {
			$svg_path           = get_attached_file( $attachment_id );
			$dimensions         = $this->svg_dimensions( $svg_path );
			$metadata['width']  = $dimensions->width;
			$metadata['height'] = $dimensions->height;
		}

		return $metadata;
	}

	/**
	 * Check that the SVG extension is correct, and that it is in fact an image
	 *
	 * @param array  $filetype_ext_data file extension & type.
	 * @param string $filename file name.
	 *
	 * @return mixed
	 */
	public function wp_check_filetype_and_ext( array $filetype_ext_data, string $filename ) {
		if ( substr( $filename, - 4 ) === '.svg' ) {
			$filetype_ext_data['ext']  = 'svg';
			$filetype_ext_data['type'] = 'image/svg+xml';
		}
		if ( substr( $filename, - 5 ) === '.svgz' ) {
			$filetype_ext_data['ext']  = 'svgz';
			$filetype_ext_data['type'] = 'image/svg+xml';
		}

		return $filetype_ext_data;
	}

	/**
	 * Add SVG support
	 */
	public function add_svg_support() {

		/**
		 * Filter the SVG thumbnail
		 *
		 * @param string $content the content.
		 *
		 * @return mixed|void
		 */
		function svg_thumbs( string $content ) {
			return apply_filters( 'final_output', $content );
		}

		ob_start( 'svg_thumbs' );

		add_filter( 'final_output', array( $this, 'final_output' ) );
		add_filter( 'wp_prepare_attachment_for_js', array( $this, 'wp_prepare_attachment_for_js' ), 10, 3 );
	}

	/**
	 * The final output
	 *
	 * @param string $content string.
	 *
	 * @return string|string[]
	 */
	public function final_output( string $content ) {
		$content = str_replace(
			'<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
			'<# } else if ( \'svg+xml\' === data.subtype ) { #>
				<img class="details-image" src="{{ data.url }}" alt="" draggable="false" />
			<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
			$content
		);

		$content = str_replace(
			'<# } else if ( \'image\' === data.type && data.sizes ) { #>',
			'<# } else if ( \'svg+xml\' === data.subtype ) { #>
				<div class="centered">
					<img src="{{ data.url }}" class="thumbnail" alt="" draggable="false" />
				</div>
			<# } else if ( \'image\' === data.type && data.sizes ) { #>',
			$content
		);

		return $content;
	}

	/**
	 * Add SVG mime type
	 *
	 * @param array $mimes mime types.
	 *
	 * @return array|mixed
	 */
	public function add_svg_mime( $mimes = array() ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';

		return $mimes;
	}

	/**
	 * Prepare the attachment for JS
	 *
	 * @param array  $response the response.
	 * @param object $attachment the attachment.
	 *
	 * @return mixed
	 */
	public function wp_prepare_attachment_for_js( array $response, $attachment ) {
		if ( 'image/svg+xml' && empty( $response['sizes'] ) === $response['mime'] ) {
			$svg_path = get_attached_file( $attachment->ID );
			if ( ! file_exists( $svg_path ) ) {
				$svg_path = $response['url'];
			}
			$dimensions        = $this->svg_dimensions( $svg_path );
			$response['sizes'] = array(
				'full' => array(
					'url'         => $response['url'],
					'width'       => $dimensions->width,
					'height'      => $dimensions->height,
					'orientation' => $dimensions->width > $dimensions->height ? 'landscape' : 'portrait',
				),
			);
		}

		return $response;
	}

	/**
	 * The dimensions of the SVG
	 *
	 * @param string $svg the SVG object.
	 *
	 * @return object
	 */
	private function svg_dimensions( string $svg ) {
		$loaded_svg = simplexml_load_file( $svg );
		$width      = 0;
		$height     = 0;
		if ( $loaded_svg ) {
			$attributes = $loaded_svg->attributes();
			if ( isset( $attributes->width, $attributes->height ) ) {
				$width  = floatval( $attributes->width );
				$height = floatval( $attributes->height );
				// @codingStandardsIgnoreStart (viewBox is the correct name and cannot be changed)
			} elseif ( isset( $attributes->viewBox ) ) {
				$sizes = explode( ' ', $attributes->viewBox );
				// @codingStandardsIgnoreEnd
				if ( isset( $sizes[2], $sizes[3] ) ) {
					$width  = floatval( $sizes[2] );
					$height = floatval( $sizes[3] );
				}
			}
		}

		return (object) array(
			'width'  => $width,
			'height' => $height,
		);
	}
}

