<?php

/**
 * Plugin Name:       Admin Command Palette
 * Plugin URI:        http://wordpress.org/plugins/admin-command-palette/
 * Description:       Optimize WordPress admin navigation with a live search box and keyboard shortcuts.
 * Version:           1.0.1
 * Author: Glenn Welser, Sam Mello & Josh Nederveld
 * Author URI: http://clarknikdelpowell.com/agency/people/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       acp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'ACP_CACHE', TRUE );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-acp-activator.php
 */
function activate_admin_command_palette() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-acp-activator.php';
	ACP_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-acp-deactivator.php
 */
function deactivate_admin_command_palette() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-acp-deactivator.php';
	ACP_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_admin_command_palette' );
register_deactivation_hook( __FILE__, 'deactivate_admin_command_palette' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-acp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
$ACP;
function run_admin_command_palette() {

	global $ACP;
	$ACP = new ACP();
	$ACP->run();

}
run_admin_command_palette();
