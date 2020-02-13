<div class="postbox">
	<h3 class="hndle"><span><?php _e( 'Export Settings', LP_TEXTDOMAIN ); ?></span></h3>
	<div class="inside">
		<p><?php _e( 'Export the plugin\'s settings for this site as a .json file. This will allows you to easily import the configuration to another installation.', LP_TEXTDOMAIN ); ?></p>
		<form method="post">
			<p><input type="hidden" name="lp_action" value="export_settings"/></p>
			<p>
				<?php wp_nonce_field( 'lp_export_nonce', 'lp_export_nonce' ); ?>
				<?php submit_button( __( 'Export' ), 'secondary', 'lp_export_submit', false ); ?>
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
				<?php submit_button( __( 'Import' ), 'secondary', 'lp_import_submit', false ); ?>
			</p>
		</form>
	</div>
</div>
