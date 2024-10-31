<?php

/**
 * 
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://newip.pe/
 * @since             1.0.0
 * @package           Newcallcenter
 *
 * @wordpress-plugin
 * Plugin Name:       Newcallcenter Webtocall 
 * Plugin URI:        https://newip.pe/
 * Description:       Plugin para activar funcionalidad de webtocall de Newcallcenter
 * Version:           1.0.0
 * Author:            New IP Solutions SAC
 * Author URI:        https://newip.pe 
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       newcallcenter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'NEWCALLCENTER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-newcallcenter-activator.php
 */
function activate_newcallcenter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-newcallcenter-activator.php';
	Newcallcenter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-newcallcenter-deactivator.php
 */
function deactivate_newcallcenter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-newcallcenter-deactivator.php';
	Newcallcenter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_newcallcenter' );
register_deactivation_hook( __FILE__, 'deactivate_newcallcenter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-newcallcenter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_newcallcenter() {

	$plugin = new Newcallcenter();
	$plugin->run();

}
run_newcallcenter();