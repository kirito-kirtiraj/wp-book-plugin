<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * php version 7.3.11
 * 
 * @category Assignment
 * @package  Wp_Book
 * @author   Kirtiraj Patil <officialkirtiraj@gmail.com>
 * @license  GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link     https://www.linkedin.com/in/kirtiraj-patil-00b01b185/
 * @since    1.0.0
 * 
 * @wordpress-plugin
 * Plugin Name:       wp-book
 * Plugin URI:        https://github.com/kirito-kirtiraj/wp-book-plugin.git
 * Description:       Book plugin which registers a custom post type for books,
 *                    book category, book tag, a custom meta box, a custom meta
 *                    table for saving the book info in separate table, custom
 *                    admin settings and book shortcode.
 * Version:           1.0.0
 * Author URI:        https://www.linkedin.com/in/kirtiraj-patil-00b01b185/
 * Text Domain:       wp-book
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define('WP_BOOK_VERSION', '1.0.0');

//Global variable for storing the options for book custom post type.
$book_options = get_option('bookCPTSettings');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-book-activator.php
 * 
 * @return void
 */
function KPBook_Activate_Wp_book()
{
    include_once plugin_dir_path(__FILE__) .
    'includes/class-wp-book-activator.php';
    Wp_Book_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-book-deactivator.php
 * 
 * @return mixed
 */
function KPBook_Deactivate_Wp_book()
{
    include_once plugin_dir_path(__FILE__) . 
    'includes/class-wp-book-deactivator.php';
    Wp_Book_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'KPBook_Activate_Wp_book');
register_deactivation_hook(__FILE__, 'KPBook_Deactivate_Wp_book');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-wp-book.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since  1.0.0
 * @return none
 */
function Run_Wp_book()
{
    $plugin = new Wp_Book();
    $plugin->run();
}
Run_Wp_book();
