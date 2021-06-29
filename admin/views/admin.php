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

<div class="resource-lp wrap">
	<div id="resource-lp-main">
		<div class="header-wrap">
			<div class="wrapper">
				<div class="header mdb-header bg-brand-light flex-container">
					<h1>LeasePress</h1>
				</div>
			</div>
		</div>
		<div class="wrapper">
		<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1" title="Settings"><?php esc_html_e( 'Settings', 'leasepress' ); ?></a></li>
			<li><a href="#tabs-2" title="More Settings"><?php esc_html_e( 'More Settings', 'leasepress' ); ?></a></li>
			<li><a href="#tabs-3" title="Import/Export"><?php esc_html_e( 'Import/Export', 'leasepress' ); ?></a></li>
		</ul>
		<div id="tabs-1" class="wrap">
			<div class="settings-tab">
				<?php require_once plugin_dir_path( __FILE__ ) . 'settings.php'; ?>
			</div>
			<div id="right-column" class="right-column-settings-page" style="overflow: hidden;position:relative;min-height: 90px;">
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
				<div id="rentcafe-request-data">
				</div>
			</div>
		</div>
		<div id="tabs-2" class="metabox-holder">
			<div class="more-settings-tab">
				<?php require_once plugin_dir_path( __FILE__ ) . 'more-settings.php'; ?>
			</div>
		</div>
		<div id="tabs-3" class="metabox-holder">
			<?php require_once plugin_dir_path( __FILE__ ) . 'export-import.php'; ?>
		</div>
	</div>
		</div>
	</div>
</div>
