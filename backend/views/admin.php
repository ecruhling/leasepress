<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that provides
 * the user interface to the end user.
 *
 * @package   LeasePress
 * @author    Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link      https://resourceatlanta.com
 */

?>

<div class="lp wrap">
	<div id="lp-main">
		<div class="header-wrap">
			<div class="wrapper grid-container">
				<div class="header">
					<h1>LeasePress</h1>
				</div>
			</div>
		</div>
		<div class="wrapper" id="tabs">
			<ul>
				<li><a href="#settings" title="Settings"><?php esc_html_e( 'Settings', 'leasepress' ); ?></a></li>
				<li><a href="#floor-plans" title="Floor Plans"><?php esc_html_e( 'Floor Plans', 'leasepress' ); ?></a></li>
				<li><a href="#tables" title="Tables"><?php esc_html_e( 'Tables', 'leasepress' ); ?></a></li>
				<li><a href="#import-export" title="Import/Export"><?php esc_html_e( 'Import/Export', 'leasepress' ); ?></a></li>
			</ul>
			<div id="settings" class="flex">
				<div class="settings-tab flex-50">
					<?php require_once plugin_dir_path( __FILE__ ) . '/tabs/settings.php'; ?>
				</div>
				<div id="right-column" class="flex-50" style="overflow: hidden;position:relative;min-height: 90px;">
					<div class="container-shadow" style="padding-bottom: 3rem;">
						<h3>RENTCafe Request Data:</h3>
							<svg id="data-loader" class="loader" width="60px" height="60px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
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
						<div id="rentcafe-request-data" style="overflow: hidden;"></div>
					</div>
				</div>
			</div>
			<div id="floor-plans" class="metabox-holder">
				<?php require_once plugin_dir_path( __FILE__ ) . '/tabs/floor-plans.php'; ?>
			</div>
			<div id="tables" class="metabox-holder">
				<?php require_once plugin_dir_path( __FILE__ ) . '/tabs/tables.php'; ?>
			</div>
			<div id="import-export" class="metabox-holder">
				<?php require_once plugin_dir_path( __FILE__ ) . '/tabs/export-import.php'; ?>
			</div>
		</div>
	</div>
</div>
