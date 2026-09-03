<?php
/**
 * Plugin Name: PV Simple WhatsApp Button
 * Description: Configurable floating WhatsApp button (number and message).
 * Version: 1.0.0
 * Author: Pedro Vidal
 * License: GPL v2 or later
 * Text Domain: pv-simple-whatsapp-button
 * Requires PHP: 8.1
 *
 * @package PV_Simple_WhatsApp_Button
 */

declare(strict_types=1);

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PV_SWB_PLUGIN_FILE', __FILE__ );

require_once __DIR__ . '/includes/class-pv-swb-settings.php';
require_once __DIR__ . '/includes/class-pv-swb-render.php';

/**
 * Initializes the plugin.
 */
function pv_swb_init(): void {
	load_plugin_textdomain(
		'pv-simple-whatsapp-button',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
	$settings = new PV_SWB_Settings();
	$settings->init();

	$render = new PV_SWB_Render();
	$render->init();
}
add_action( 'plugins_loaded', 'pv_swb_init' );
