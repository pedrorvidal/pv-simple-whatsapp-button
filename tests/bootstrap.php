<?php
/**
 * PHPUnit bootstrap file.
 *
 * @package PV_Simple_WhatsApp_Button
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

define( 'ABSPATH', __DIR__ . '/' );
define( 'PV_SWB_PLUGIN_FILE', dirname( __DIR__ ) . '/pv-simple-whatsapp-button.php' );

require_once dirname( __DIR__ ) . '/includes/class-pv-swb-settings.php';
require_once dirname( __DIR__ ) . '/includes/class-pv-swb-render.php';
