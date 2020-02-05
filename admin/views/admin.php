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
			<?php
			require_once( plugin_dir_path( __FILE__ ) . 'settings.php' );
			?>
		</div>
		<div id="tabs-2" class="metabox-holder">
			<div class="postbox">
				<h3 class="hndle"><span><?php _e( 'Export Settings', LP_TEXTDOMAIN ); ?></span></h3>
				<div class="inside">
					<p><?php _e( 'Export the plugin\'s settings for this site as a .json file. This will allows you to easily import the configuration to another installation.', LP_TEXTDOMAIN ); ?></p>
					<form method="post">
						<p><input type="hidden" name="lp_action" value="export_settings"/></p>
						<p>
							<?php wp_nonce_field( 'lp_export_nonce', 'lp_export_nonce' ); ?>
							<?php submit_button( __( 'Export' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
				</div>
			</div>

			<div class="postbox">
				<h3 class="hndle"><span><?php _e( 'Import Settings', LP_TEXTDOMAIN ); ?></span></h3>
				<div class="inside">
					<p><?php _e( 'Import the plugin\'s settings from a .json file. This file can be retrieved by exporting the settings from another installation.', LP_TEXTDOMAIN ); ?></p>
					<form method="post" enctype="multipart/form-data">
						<p>
							<input type="file" name="lp_import_file"/>
						</p>
						<p>
							<input type="hidden" name="lp_action" value="import_settings"/>
							<?php wp_nonce_field( 'lp_import_nonce', 'lp_import_nonce' ); ?>
							<?php submit_button( __( 'Import' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
				</div>
			</div>
		</div>
		<?php
		( new LP_Transient() )->print_transient_output('floorplan');

		lp_log(( new LP_Transient )->get_or_cache_transient('floorplan'));
		?>
	</div>
</div>
