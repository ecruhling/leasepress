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
			<li><a href="#tabs-1" title="Settings"><?php _e( 'Settings' ); ?></a></li>
			<li><a href="#tabs-2" title="Import/Export"><?php _e( 'Import/Export', LP_TEXTDOMAIN ); ?></a></li>
		</ul>
		<div id="tabs-1" class="wrap">
			<div class="settings-tab">
				<?php require_once( plugin_dir_path( __FILE__ ) . 'settings.php' ); ?>
			</div>
			<div class="right-column-settings-page">
				<h3>RentCAFE Request Data:</h3>
				<code id="rentcafe-request-data">
					<!--				--><?php //lp_log(( new LP_Transient )->get_or_cache_transient('floorplan')); ?>
					<!--				--><?php //( new LP_Transient() )->print_transient_output('floorplan'); ?>
				</code>
			</div>
		</div>
		<div id="tabs-2" class="metabox-holder">
			<?php require_once( plugin_dir_path( __FILE__ ) . 'export-import.php' ); ?>
		</div>
	</div>
</div>
