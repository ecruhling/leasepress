<?php
?>

<div class="container-shadow">
	<h3 class="handle"><span><?php esc_html_e( 'Create Floor Plans CPT', 'leasepress' ); ?></span></h3>
	<div class="inside">
		<p><?php esc_html_e( 'Using the data from RENTCafe, create a CPT Floor Plan for each floor plan.', 'leasepress' ); ?></p>
		<form method="post">
			<p><input type="hidden" name="lp_action" value="lp_create_floor_plans"/></p>
			<p class="lp_create_floor_plans">
				<?php wp_nonce_field( 'lp_create_floor_plans_nonce', 'lp_create_floor_plans_nonce' ); ?>
				<?php submit_button( esc_html__( 'Create Floor Plans' ), 'secondary lp_create_delete_floor_plans', 'lp_create_floor_plans', false ); ?>
				<svg id="lp_create_floor_plans_loader" class="loader" width="60px" height="60px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
				<path fill="#007cba" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
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
			</p>
		</form>
	</div>
</div>

<div class="container-shadow">
	<h3 class="handle"><span><?php esc_html_e( 'Delete Floor Plans CPT', 'leasepress' ); ?></span></h3>
	<div class="inside">
		<p><?php esc_html_e( 'Delete ALL Floor Plans CPT posts.', 'leasepress' ); ?></p>
		<form method="post">
			<p><input type="hidden" name="lp_action" value="lp_delete_floor_plans"/></p>
			<p class="lp_delete_floor_plans">
				<?php wp_nonce_field( 'lp_delete_floor_plans_nonce', 'lp_delete_floor_plans_nonce' ); ?>
				<?php submit_button( esc_html__( 'Delete Floor Plans' ), 'secondary lp_create_delete_floor_plans', 'lp_delete_floor_plans', false ); ?>
				<svg id="lp_delete_floor_plans_loader" class="loader" width="60px" height="60px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
				<path fill="#007cba" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
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
			</p>
		</form>
	</div>
</div>

