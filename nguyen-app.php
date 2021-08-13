<?php
/**
 *
 * @link              https://baonguyenyam.github.io/
 * @since             1.0.0
 * @package           BEST_SUGGESTION_BOXES
 *
 * @wordpress-plugin
 * Plugin Name:       Best Suggestion Boxes
 * Plugin URI:        https://wordpress.org/plugins/best-suggestion-boxes
 * Description:       A Better Way to Connect With Customers. You don't have time to talk with some online customers? This plugin will help you connect with them.
 * Version:           1.0.0
 * Author:            Nguyen Pham
 * Author URI:        https://github.com/wp-best-suggestion-boxes
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       best-suggestion-boxes
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
define( 'BEST_SUGGESTION_BOXES_DOMAIN', 'best-suggestion-boxes' );
define( 'BEST_SUGGESTION_BOXES_NICENAME', 'Best Suggestion Boxes' );
define( 'BEST_SUGGESTION_BOXES_PREFIX', 'best_suggestion_boxes' );
define( 'BEST_SUGGESTION_BOXES_VERSION', '1.0.0' );
define( 'WPLANG', '');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-activator.php
 */
function activate_bestSuggestionBoxes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-activator.php';
	Best_Suggestion_Boxes_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-deactivator.php
 */
function deactivate_bestSuggestionBoxes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deactivator.php';
	Best_Suggestion_Boxes_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bestSuggestionBoxes' );
register_deactivation_hook( __FILE__, 'deactivate_bestSuggestionBoxes' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-core.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bestSuggestionBoxes() {

	$plugin = new Best_Suggestion_Boxes();
	$plugin->run();

}
run_bestSuggestionBoxes();
