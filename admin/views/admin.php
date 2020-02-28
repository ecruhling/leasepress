<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   LeasePress
 * @author    Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link      https://resourceatlanta.com
 */
?>

<div class="wrap">
	<h2><?= esc_html( get_admin_page_title() ); ?></h2>
	<div id="tabs" class="settings-tab">
		<ul>
			<li><a href="#tabs-1" title="Settings"><?php _e( 'Settings', LP_TEXTDOMAIN ); ?></a></li>
			<li><a href="#tabs-2" title="More Settings"><?php _e( 'More Settings', LP_TEXTDOMAIN ); ?></a></li>
			<li><a href="#tabs-3" title="Import/Export"><?php _e( 'Import/Export', LP_TEXTDOMAIN ); ?></a></li>
		</ul>
		<div id="tabs-1" class="wrap">
			<div class="settings-tab">
				<?php require_once( plugin_dir_path( __FILE__ ) . 'settings.php' ); ?>
<!--				--><?php //lp_log( \LP_Transient::get_or_cache_transient( 'apartmentavailability' ) ); ?>
<!--				--><?php //\LP_Transient::print_transient_output( 'floorplan' ); ?>
			</div>
			<div id="right-column" class="right-column-settings-page" style="overflow: hidden;">
				<h3>RENTCafe Request Data:</h3>
				<svg version="1.1" id="data-loader" class="loader" width="60px" height="60px" xmlns="http://www.w3.org/2000/svg"
				     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				     viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
    <path fill="#007cba"
          d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
	    <animateTransform
		    attributeName="transform"
		    attributeType="XML"
		    type="rotate"
		    dur="1s"
		    from="0 50 50"
		    to="360 50 50"
		    repeatCount="indefinite"/>
    </path>
</svg>
				<div id="rentcafe-request-data">
				</div>
			</div>
		</div>
		<div id="tabs-2" class="metabox-holder">
			<div class="more-settings-tab">
			</div>
		</div>
		<div id="tabs-3" class="metabox-holder">
			<?php require_once( plugin_dir_path( __FILE__ ) . 'export-import.php' ); ?>
		</div>
	</div>
</div>
