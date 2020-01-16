
		<div id="tabs-2" class="wrap">
			<?php
			$cmb = new_cmb2_box( array(
				'id' => LP_TEXTDOMAIN . '_options-second',
				'hookup' => false,
				'show_on' => array( 'key' => 'options-page', 'value' => array( LP_TEXTDOMAIN ), ),
				'show_names' => true,
					) );
			$cmb->add_field( array(
				'name' => __( 'Text', LP_TEXTDOMAIN ),
				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
				'id' => '_text-second',
				'type' => 'text',
				'default' => 'Default Text',
			) );
			$cmb->add_field( array(
				'name' => __( 'Color Picker', LP_TEXTDOMAIN ),
				'desc' => __( 'field description (optional)', LP_TEXTDOMAIN ),
				'id' => '_colorpicker-second',
				'type' => 'colorpicker',
				'default' => '#bada55',
			) );

			cmb2_metabox_form( LP_TEXTDOMAIN . '_options-second', LP_TEXTDOMAIN . '-settings-second' );
			?>

			<!-- Provide other markup for your options page here. -->
		</div>
