<div id="tabs-1" class="wrap">
			<?php
			$cmb = new_cmb2_box( array(
				'id' => LP_TEXTDOMAIN . '_options',
				'hookup' => false,
				'show_on' => array( 'key' => 'options-page', 'value' => array( LP_TEXTDOMAIN ), ),
				'show_names' => true,
					) );
			$cmb->add_field( array(
				'name' => __( 'RENTCafe API Token', LP_TEXTDOMAIN ),
				'desc' => __( 'Format is: XXXXXXXX-XXXXXXXXXXXXXX', LP_TEXTDOMAIN ),
				'id' => 'lp_rentcafe_api_token',
				'type' => 'text',
				'default' => '',
			) );
			$cmb->add_field( array(
				'name' => __( 'RENTCafe Property Code', LP_TEXTDOMAIN ),
				'desc' => __( 'Format is: pXXXXXXX', LP_TEXTDOMAIN ),
				'id' => 'lp_rentcafe_property_code',
				'type' => 'text',
				'default' => '',
			) );
			$cmb->add_field( array(
				'name' => __( 'RENTCafe Property ID', LP_TEXTDOMAIN ),
				'desc' => __( 'Format is: XXXXXXX', LP_TEXTDOMAIN ),
				'id' => 'lp_rentcafe_property_id',
				'type' => 'text',
				'default' => '',
			) );
			$cmb->add_field( array(
				'name' => __( 'Template for Floor Plans page', LP_TEXTDOMAIN ),
				'desc' => __( 'page template that will contain site plans & floor plans', LP_TEXTDOMAIN ),
				'id' => 'lp_page_template',
				'type' => 'text',
				'default' => '',
			) );
//			$cmb->add_field( array(
//				'name' => __( 'Color Picker', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => 'colorpicker',
//				'type' => 'colorpicker',
//				'default' => '#bada55',
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Text Medium', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_textmedium',
//				'type' => 'text_medium',
//					// 'repeatable' => true,
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Website URL', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_url',
//				'type' => 'text_url',
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Text Email', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_email',
//				'type' => 'text_email',
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Time', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_time',
//				'type' => 'text_time',
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Date Picker', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_textdate',
//				'type' => 'text_date',
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Date Picker (UNIX timestamp)', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_textdate_timestamp',
//				'type' => 'text_date_timestamp',
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Date/Time Picker Combo (UNIX timestamp)', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_datetime_timestamp',
//				'type' => 'text_datetime_timestamp',
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Money', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_textmoney',
//				'type' => 'text_money',
//				'before_field' => '€', // Override '$' symbol if needed
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Text Area', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_textarea',
//				'type' => 'textarea',
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Text Area for Code', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_textarea_code',
//				'type' => 'textarea_code',
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Title Weeeee', LP_TEXTDOMAIN ),
//				'desc' => __( 'This is a title description', LP_TEXTDOMAIN ),
//				'id' => '_title',
//				'type' => 'title',
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Select', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_select',
//				'type' => 'select',
//				'show_option_none' => true,
//				'options' => array(
//					'standard' => __( 'Option One', LP_TEXTDOMAIN ),
//					'custom' => __( 'Option Two', LP_TEXTDOMAIN ),
//					'none' => __( 'Option Three', LP_TEXTDOMAIN ),
//				),
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Radio inline', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_radio_inline',
//				'type' => 'radio_inline',
//				'show_option_none' => 'No Selection',
//				'options' => array(
//					'standard' => __( 'Option One', LP_TEXTDOMAIN ),
//					'custom' => __( 'Option Two', LP_TEXTDOMAIN ),
//					'none' => __( 'Option Three', LP_TEXTDOMAIN ),
//				),
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Radio', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_radio',
//				'type' => 'radio',
//				'options' => array(
//					'option1' => __( 'Option One', LP_TEXTDOMAIN ),
//					'option2' => __( 'Option Two', LP_TEXTDOMAIN ),
//					'option3' => __( 'Option Three', LP_TEXTDOMAIN ),
//				),
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Taxonomy Radio', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_text_taxonomy_radio',
//				'type' => 'taxonomy_radio',
//				'taxonomy' => 'category', // Taxonomy Slug
//					// 'inline'  => true, // Toggles display to inline
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Taxonomy Select', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_taxonomy_select',
//				'type' => 'taxonomy_select',
//				'taxonomy' => 'category', // Taxonomy Slug
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Taxonomy Multi Checkbox', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_multitaxonomy',
//				'type' => 'taxonomy_multicheck',
//				'taxonomy' => 'category', // Taxonomy Slug
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Checkbox', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_checkbox',
//				'type' => 'checkbox',
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Multi Checkbox', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_multicheckbox',
//				'type' => 'multicheck',
//				'options' => array(
//					'check1' => __( 'Check One', LP_TEXTDOMAIN ),
//					'check2' => __( 'Check Two', LP_TEXTDOMAIN ),
//					'check3' => __( 'Check Three', LP_TEXTDOMAIN ),
//				),
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test wysiwyg', LP_TEXTDOMAIN ),
//				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
//				'id' => '_wysiwyg',
//				'type' => 'wysiwyg',
//				'options' => array( 'textarea_rows' => 5, ),
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Test Image', LP_TEXTDOMAIN ),
//				'desc' => __( 'Upload an image or enter a URL.', LP_TEXTDOMAIN ),
//				'id' => '_image',
//				'type' => 'file',
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'Multiple Files', LP_TEXTDOMAIN ),
//				'desc' => __( 'Upload or add multiple images/attachments.', LP_TEXTDOMAIN ),
//				'id' => '_file_list',
//				'type' => 'file_list',
//				'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
//			) );
//			$cmb->add_field( array(
//				'name' => __( 'oEmbed', LP_TEXTDOMAIN ),
//				'desc' => __( 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', LP_TEXTDOMAIN ),
//				'id' => '_embed',
//				'type' => 'oembed',
//			) );
//			$cmb->add_field( array(
//				'name' => 'Testing Field Parameters',
//				'id' => '_parameters',
//				'type' => 'text',
//				'before_row' => '<p>before_row_if_2</p>', // Callback
//				'before' => '<p>Testing <b>"before"</b> parameter</p>',
//				'before_field' => '<p>Testing <b>"before_field"</b> parameter</p>',
//				'after_field' => '<p>Testing <b>"after_field"</b> parameter</p>',
//				'after' => '<p>Testing <b>"after"</b> parameter</p>',
//				'after_row' => '<p>Testing <b>"after_row"</b> parameter</p>',
//			) );


			cmb2_metabox_form( LP_TEXTDOMAIN . '_options', LP_TEXTDOMAIN . '-settings' );
			?>

			<!-- Provide other markup for your options page here. -->
		</div>
