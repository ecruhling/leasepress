<?php
/**
 * Settings tab for the administration dashboard.
 *
 * @package   LeasePress
 * @author    Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link      https://resourceatlanta.com
 */

$cmb = new_cmb2_box(
	array(
		'id'         => 'leasepress_options',
		'hookup'     => false,
		'show_on'    => array(
			'key'   => 'options-page',
			'value' => array( 'leasepress' ),
		),
		'show_names' => true,
	)
);

$cmb->add_field(
	array(
		'name'            => esc_html__( 'RENTCafe API Token', 'leasepress' ),
		'desc'            => esc_html__( 'Format is: XXXXXXXX-XXXXXXXXXXXXXX', 'leasepress' ),
		'id'              => 'lp_rentcafe_api_token',
		'type'            => 'text',
		'sanitization_cb' => 'lp_sanitize_api_token',
		'default'         => '',
	)
);

$cmb->add_field(
	array(
		'name'    => esc_html__( 'RENTCafe Property Code', 'leasepress' ),
		'desc'    => __( 'Format is: pXXXXXXX (Either the Property Code OR<br>the Property ID MUST be supplied)', 'leasepress' ),
		'id'      => 'lp_rentcafe_property_code',
		'type'    => 'text',
		'default' => '',
	)
);

$cmb->add_field(
	array(
		'name'    => esc_html__( 'RENTCafe Property ID', 'leasepress' ),
		'desc'    => __( 'Format is: XXXXXXX (Either the Property Code OR<br>the Property ID MUST be supplied)', 'leasepress' ),
		'id'      => 'lp_rentcafe_property_id',
		'type'    => 'text',
		'default' => '',
	)
);

$cmb->add_field(
	array(
		'name'             => esc_html__( 'Use for API lookups', 'leasepress' ),
		'desc'             => __( 'A valid Property Code OR Property ID must be used for all API lookups  <span class="lp-tooltip" data-tooltip="Use this when you want to rearrange the title parts manually." tabindex="0"><strong>[?]</strong></span>', 'leasepress' ),
		'id'               => 'lp_rentcafe_code_or_id',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'property_code' => esc_html__( 'Property Code', 'leasepress' ),
			'property_id'   => esc_html__( 'Property ID', 'leasepress' ),
		),
	)
);

$cmb->add_field(
	array(
		'name'             => esc_html__( 'Template for Floor Plans page', 'leasepress' ),
		'desc'             => __( 'The page template that will contain site plans & floor plans.<br>The scripts will only run on a page with this template.', 'leasepress' ),
		'id'               => 'lp_page_template',
		'type'             => 'select',
		'show_option_none' => 'Do Not Run',
		'default'          => '',
		'options'          => array_flip( get_page_templates() ),
	)
);

$cmb->add_field(
	array(
		'name'    => esc_html__( 'Length of time to cache data', 'leasepress' ),
		'desc'    => __( 'RENTCafe data is cached in a transient.<br>Set the length of time to cache this data. Default is One Hour.<br> After changing this setting Clear Cache for best results.', 'leasepress' ),
		'id'      => 'lp_cache_time',
		'type'    => 'select',
		'default' => HOUR_IN_SECONDS,
		'options' => array(
			HOUR_IN_SECONDS / 4 => esc_html__( 'Quarter Hour', 'leasepress' ),
			HOUR_IN_SECONDS / 2 => esc_html__( 'Half Hour', 'leasepress' ),
			HOUR_IN_SECONDS     => esc_html__( 'One Hour', 'leasepress' ),
			HOUR_IN_SECONDS * 2 => esc_html__( 'Two Hours', 'leasepress' ),
			HOUR_IN_SECONDS * 3 => esc_html__( 'Three Hours', 'leasepress' ),
		),
	)
);

$cmb->add_field(
	array(
		'name' => esc_html__( 'Do Not Display Any Prices', 'leasepress' ),
		'desc' => esc_html__( 'In some cases, you may want to disable the display of any prices.', 'leasepress' ),
		'id'   => 'lp_leasepress_disable_price',
		'type' => 'checkbox',
	)
);

$cmb->add_field(
	array(
		'name' => esc_html__( 'Do Not Display Price for Plans with no Availabilities', 'leasepress' ),
		'desc' => esc_html__( 'If a particular floor plan has no availabilities, then do not display the price.', 'leasepress' ),
		'id'   => 'lp_leasepress_disable_price_on_unavailable_plans',
		'type' => 'checkbox',
	)
);

$cmb->add_field(
	array(
		'name'            => esc_html__( 'Replace Price with text', 'leasepress' ),
		'desc'            => esc_html__( 'Disabled price will be replaced with this text.', 'leasepress' ),
		'id'              => 'lp_rentcafe_replace_price_text',
		'type'            => 'text',
		'sanitization_cb' => 'sanitize_text_field',
		'default'         => 'Call For Pricing',
	)
);

cmb2_metabox_form(
	'leasepress_options',
	'leasepress-settings',
	array(
		'form_format' => '<form class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<input id="save-button" type="submit" name="submit-cmb" value="%4$s" class="button-primary"></form>',
	)
);

?>

<div class="">
	<h3 class="hndle"><span><?php esc_html_e( 'Clear All Cached Data', 'leasepress' ); ?></span></h3>
	<div class="inside">
		<p><?php esc_html_e( 'clear all cached RENTCafe data (floorplan & apartmentavailability requestType) and performs a new lookup. Results are cached.', 'leasepress' ); ?></p>
		<form method="post">
			<p><input type="hidden" name="lp_action" value="api_clear_cache"/></p>
			<p class="clear-cached-data">
				<?php wp_nonce_field( 'lp_api_clear_cache_nonce', 'lp_api_clear_cache_nonce' ); ?>
				<?php submit_button( esc_html__( 'Clear Cache' ), 'secondary api_clear_cache', 'lp_api_clear_cache_submit', false ); ?>
				<svg id="cache-loader" class="loader" width="60px" height="60px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
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
<div class="">
	<h3 class="hndle"><span><?php esc_html_e( 'Create Floor Plans CPT', 'leasepress' ); ?></span></h3>
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
<div class="">
	<h3 class="hndle"><span><?php esc_html_e( 'Delete Floor Plans CPT', 'leasepress' ); ?></span></h3>
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
<div class="">
	<h3 class="hndle"><span><?php esc_html_e( 'RentCAFE API Floorplan Lookup', 'leasepress' ); ?></span></h3>
	<div class="inside">
		<p>
			<?php esc_html_e( 'perform a real-time lookup of the RentCAFE API Floorplan method, using the above information. Result is not cached.', 'leasepress' ); ?>
			<br>
			<?php esc_html_e( 'Use this to confirm that RENTCafe is returning valid data.', 'leasepress' ); ?>
		</p>
		<form method="post">
			<p><input type="hidden" name="lp_action" value="api_floorplans_lookup"/></p>
			<p>
				<?php wp_nonce_field( 'get_rentcafe_data_ajax', 'lp_api_floorplan_lookup_nonce' ); ?>
				<?php submit_button( esc_html__( 'Floorplans API Lookup' ), 'secondary api_lookup_button', 'lp_api_floorplans_lookup_submit', false, array( 'data-method' => 'floorplan' ) ); ?>
			</p>
		</form>
	</div>
</div>
<div class="">
	<h3 class="hndle"><span><?php esc_html_e( 'RentCAFE API Availabilities Lookup', 'leasepress' ); ?></span></h3>
	<div class="inside">
		<p>
			<?php esc_html_e( 'perform a real-time lookup of the RentCAFE API Availabilities method, using the above information. Result is not cached.', 'leasepress' ); ?>
			<br>
			<?php esc_html_e( 'Use this to confirm that RENTCafe is returning valid data.', 'leasepress' ); ?>
		</p>
		<form method="post">
			<p><input type="hidden" name="lp_action" value="api_availabilities_lookup"/></p>
			<p>
				<?php wp_nonce_field( 'get_rentcafe_data_ajax', 'lp_api_apartmentavailability_lookup_nonce' ); ?>
				<?php submit_button( esc_html__( 'Availabilities API Lookup' ), 'secondary api_lookup_button', 'lp_api_availabilities_lookup_submit', false, array( 'data-method' => 'apartmentavailability' ) ); ?>
			</p>
		</form>
	</div>
</div>
<div class="">
	<h3 class="hndle">
		<span><?php esc_html_e( 'RentCAFE API getRentCafeUrl residentLogin Lookup', 'leasepress' ); ?></span>
	</h3>
	<div class="inside">
		<p>
			<?php esc_html_e( 'perform a real-time lookup of the RentCAFE API getRentCafeUrl method, residentLogin type, using the above information. Result is not cached.', 'leasepress' ); ?>
			<br>
			<?php esc_html_e( 'Use this to confirm that RENTCafe is returning valid data.', 'leasepress' ); ?>
		</p>
		<form method="post">
			<p><input type="hidden" name="lp_action" value="api_getRENTCafeURL_residentLogin_lookup"/></p>
			<p>
				<?php wp_nonce_field( 'get_rentcafe_data_ajax', 'lp_api_getRENTCafeURL_residentLogin_lookup_nonce' ); ?>
				<?php
				submit_button(
					__( 'getRENTCafeURL residentLogin API Lookup' ),
					'secondary api_lookup_button',
					'lp_api_getRENTCafeURL_residentLogin_lookup_submit',
					false,
					array(
						'data-method' => 'getRENTCafeURL',
						'data-type'   => 'residentLogin',
					)
				);
				?>
			</p>
		</form>
	</div>
</div>
<div class="">
	<h3 class="hndle">
		<span><?php esc_html_e( 'RentCAFE API getRentCafeUrl applicantLogin Lookup', 'leasepress' ); ?></span>
	</h3>
	<div class="inside">
		<p><?php esc_html_e( 'perform a real-time lookup of the RentCAFE API getRentCafeUrl method, applicantLogin type, using the above information. Result is not cached. Use this to confirm that RENTCafe is returning valid data.', 'leasepress' ); ?></p>
		<form method="post">
			<p><input type="hidden" name="lp_action" value="api_getRENTCafeURL_applicantLogin_lookup"/></p>
			<p>
				<?php wp_nonce_field( 'get_rentcafe_data_ajax', 'lp_api_getRENTCafeURL_applicantLogin_lookup_nonce' ); ?>
				<?php
				submit_button(
					__( 'getRENTCafeURL applicantLogin API Lookup' ),
					'secondary api_lookup_button',
					'lp_api_getRENTCafeURL_applicantLogin_lookup_submit',
					false,
					array(
						'data-method' => 'getRENTCafeURL',
						'data-type'   => 'applicantLogin',
					)
				);
				?>
			</p>
		</form>
	</div>
</div>

