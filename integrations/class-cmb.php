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
 * All the CMB related code.
 */
class LP_CMB extends LP_Base {

	/**
	 * Initialize CMB2.
	 *
	 * @since 1.0.0
	 */
	public function initialize() {
		parent::initialize();
		require_once LP_PLUGIN_ROOT . 'vendor/cmb2/init.php';
		require_once LP_PLUGIN_ROOT . 'vendor/cmb2-grid/Cmb2GridPluginLoad.php';
		add_action( 'cmb2_init', array( $this, 'cmb_demo_metaboxes' ) );
	}

	/**
	 * Your metabox on Demo CPT
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function cmb_demo_metaboxes() {
		// Start with an underscore to hide fields from custom fields list.
		$prefix   = '_demo_';
		$cmb_demo = new_cmb2_box(
			array(
				'id'           => $prefix . 'metabox',
				'title'        => __( 'Demo Metabox', 'leasepress' ),
				'object_types' => array( 'demo' ),
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true, // Show field names on the left.
			)
		);
		$cmb2Grid = new \Cmb2Grid\Grid\Cmb2Grid( $cmb_demo );
		$row      = $cmb2Grid->addRow();
		$field1   = $cmb_demo->add_field(
			array(
				'name' => __( 'Text', 'leasepress' ),
				'desc' => __( 'field description (optional)', 'leasepress' ),
				'id'   => $prefix . 'leasepress_text',
				'type' => 'text',
			)
		);
		$field2   = $cmb_demo->add_field(
			array(
				'name' => __( 'Text 2', 'leasepress' ),
				'desc' => __( 'field description (optional)', 'leasepress' ),
				'id'   => $prefix . 'leasepress_text2',
				'type' => 'text',
			)
		);

		$field3 = $cmb_demo->add_field(
			array(
				'name' => __( 'Text Small', 'leasepress' ),
				'desc' => __( 'field description (optional)', 'leasepress' ),
				'id'   => $prefix . 'leasepress_textsmall',
				'type' => 'text_small',
			)
		);
		$field4 = $cmb_demo->add_field(
			array(
				'name' => __( 'Text Small 2', 'leasepress' ),
				'desc' => __( 'field description (optional)', 'leasepress' ),
				'id'   => $prefix . 'leasepress_textsmall2',
				'type' => 'text_small',
			)
		);
		$row->addColumns( array( $field1, $field2 ) );
		$row = $cmb2Grid->addRow();
		$row->addColumns( array( $field3, $field4 ) );
	}

}
