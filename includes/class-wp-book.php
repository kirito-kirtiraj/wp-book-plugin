<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @category   Description
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 * @author     Kirtiraj Patil <officialkirtiraj@gmail.com>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://www.linkedin.com/in/kirtiraj-patil-00b01b185/
 * @since      1.0.0
 * 
 * 
 *
 * 
 * 
 */
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 * 
 * @category   Description
 * @package    Wp_Book
 * @subpackage Wp_Book/includes1
 * @author     Kirtiraj Patil <officialkirtiraj@gmail.com>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://www.linkedin.com/in/kirtiraj-patil-00b01b185/
 * @since      1.0.0
 */

class Wp_Book
{
    /**
     * The loader that's responsible for maintaining and registering all hooks
     * that power the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    Wp_Book_Loader    $loader    
     * Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $plugin_name    
     * The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used 
     * throughout the plugin. Load the dependencies, 
     * define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        if (defined('WP_BOOK_VERSION')) {
            $this->version = WP_BOOK_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'wp-book';

        $this->_loadDependencies();
        $this->_setLocale();
        $this->_defineAdminHooks();
        $this->_definePublicHooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Wp_Book_Loader. Orchestrates the hooks of the plugin.
     * - Wp_Book_i18n. Defines internationalization functionality.
     * - Wp_Book_Admin. Defines all hooks for the admin area.
     * - Wp_Book_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since  1.0.0
     * @access private
     * @return NULL
     */
    private function _loadDependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        include_once plugin_dir_path(dirname(__FILE__)) .
        'includes/class-wp-book-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 
        'includes/class-wp-book-i18n.php';

        /**
         * The class responsible for defining all actions
         * that occur in the admin area.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 
        'admin/class-wp-book-admin.php';

        /**
         * The class responsible for defining all actions
         * that occur in the public-facing
         * side of the site.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 
        'public/class-wp-book-public.php';

        $this->loader = new Wp_Book_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Wp_Book_i18n class in order
     * to set the domain and to register the hook
     * with WordPress.
     *
     * @since  1.0.0
     * @access private
     * @return NULL
     */
    private function _setLocale()
    {

        $plugin_i18n = new Wp_Book_i18n();

        $this->loader->add_action(
            'plugins_loaded', $plugin_i18n,
            'load_plugin_textdomain'
        );

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     * @return NULL
     */
    private function _defineAdminHooks()
    {

        $plugin_admin = new Wp_Book_Admin(
            $this->getPluginName(),
            $this->getVersion()
        );

        $this->loader->add_action(
            'admin_enqueue_scripts', $plugin_admin,
            'enqueueStyles'
        );
        
        $this->loader->add_action(
            'admin_enqueue_scripts', $plugin_admin,
            'enqueueScripts'
        );

        $this->loader->add_action(
            'init', $plugin_admin,
            'registerWPBookCPT'
        );

        $this->loader->add_action(
            'init', $plugin_admin,
            'registerWPBookCategory'
        );

        $this->loader->add_action(
            'init', $plugin_admin,
            'registerWPBookTag'
        );

        $this->loader->add_action(
            'add_meta_boxes', $plugin_admin, 
            'addWPBookMetaBox'
        );

        $this->loader->add_action(
            'save_post', $plugin_admin,
            'saveBookMeta', 10, 2
        );

        $this->loader->add_action(
            'before_delete_post', $plugin_admin,
            'deleteBookMeta', 10, 2
        );

        $this->loader->add_action(
            'init', $plugin_admin,
            'registerBookMetadataTable'
        );

        $this->loader->add_action(
            'admin_init', $plugin_admin,
            'registerBookSettings'
        );

        $this->loader->add_action(
            'admin_menu', $plugin_admin,
            'addBookSettingsPage'
        );

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     * @return NULL
     */
    private function _definePublicHooks()
    {

        $plugin_public = new Wp_Book_Public(
            $this->getPluginName(),
            $this->getVersion()
        );

        $this->loader->add_action(
            'wp_enqueue_scripts', $plugin_public,
            'enqueueStyles'
        );

        $this->loader->add_action(
            'wp_enqueue_scripts', $plugin_public, 
            'enqueueScripts'
        );

        $this->loader->add_action(
            'init', $plugin_public,
            'addBookShortcode'
        );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since  1.0.0
     * @return NULL
     */
    public function run() 
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since  1.0.0
     * @return string    The name of the plugin.
     */
    public function getPluginName() 
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since  1.0.0
     * @return Wp_Book_Loader    Orchestrates the hooks of the plugin.
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since  1.0.0
     * @return string    The version number of the plugin.
     */
    public function getVersion()
    {
        return $this->version;
    }

}
