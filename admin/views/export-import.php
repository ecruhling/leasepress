<div class="postbox">
	<h3 class="hndle"><span><?php esc_html_e( 'Export LeasePress Settings', 'leasepress' ); ?></span></h3>
	<div class="inside">
		<p><?php esc_html_e( 'Export LeasePress settings for this site as a .json file. This will allows you to easily import the configuration to another installation.', 'leasepress' ); ?></p>
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
	<h3 class="hndle"><span><?php esc_html_e( 'Import LeasePress Settings', 'leasepress' ); ?></span></h3>
	<div class="inside">
		<p><?php esc_html_e( 'Import LeasePress settings from a .json file. This file can be retrieved by exporting the settings from another installation.', 'leasepress' ); ?></p>
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
