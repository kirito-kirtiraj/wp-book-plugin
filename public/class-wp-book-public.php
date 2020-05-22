<?php

/**
 * The public-facing functionality of the plugin.
 * 
 * @package    Wp_Book
 * @subpackage Wp_Book/public
 * @since      1.0.0
 *
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/public
 * @author     Kirtiraj Patil <officialkirtiraj@gmail.com>
 */
class Wp_Book_Public
{
    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $_plugin_name    The ID of this plugin.
     */
    private $_plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $_version    The current version of this plugin.
     */
    private $_version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version     The version of this plugin.
     * 
     * @since 1.0.0
     */
    public function __construct( $plugin_name, $version ) {

        $this->_plugin_name = $plugin_name;
        $this->_version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function enqueueStyles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Book_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Book_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->_plugin_name, plugin_dir_url(__FILE__) . 'css/wp-book-public.css', array(), $this->_version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function enqueueScripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Book_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Book_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->_plugin_name, plugin_dir_url(__FILE__) . 'js/wp-book-public.js', array( 'jquery' ), $this->_version, false);

    }

    /**
     * Handler function which adds book shortcode.
     *
     * @return void
     */
    public function addBookShortcode()
    {
        add_shortcode('book', array($this, 'bookShortcode'));
    }
    
    /**
     * Shortcode content for showing book information.
     *
     * @param [type] $atts 
     * 
     * @return void 
     */

    public function bookShortcode($atts) 
    {
        $params = shortcode_atts(
            array(
                'id' => 'Default ID',
                'author_name' => 'Default author name',
                'year' => 'Default year',
                'category' => 'Default category',
                'tag' => 'Default tag',
                'publisher' => 'Default publisher'
            ),
            $atts
        );

        $content = "<div>
                        <h2>Book Info</h2>
                        <ul>
                            <li>ID: {$params['id']}</li>
                            <li>Author: {$params['author_name']}</li>
                            <li>Year: {$params['year']}</li>
                            <li>Category: {$params['category']}</li>
                            <li>Tag: {$params['tag']}</li>
                            <li>Publisher: {$params['publisher']}</li>
                        </ul>
                    </div>";

        return $content;
    }

}
