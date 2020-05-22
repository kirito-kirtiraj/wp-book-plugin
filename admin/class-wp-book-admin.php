<?php

/**
 * The admin-specific functionality of the plugin.
 * 
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 * @since      1.0.0
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, _version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 * @author     Kirtiraj Patil <officialkirtiraj@gmail.com>
 */
class Wp_Book_Admin
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
     * The _version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $_version    The current _version of this plugin.
     */
    private $_version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version     The version of this plugin.
     * 
     * @since 1.0.0
     */
    public function __construct( $plugin_name, $version )
    {

        $this->_plugin_name = $plugin_name;
        $this->_version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     * 
     * @return void
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

        wp_enqueue_style($this->_plugin_name, plugin_dir_url(__FILE__) . 'css/wp-book-admin.css', array(), $this->_version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     * 
     * @return void
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

        wp_enqueue_script($this->_plugin_name, plugin_dir_url(__FILE__) . 'js/wp-book-admin.js', array( 'jquery' ), $this->_version, false);

    }
    
    /**
     * Registers custom post type for Books.
     *
     * @return void
     */
    public function registerWPBookCPT()
    {
            $labels = array(
              'name'               => _x('Books', 'post type general name', 'wp-book'),
              'singular_name'      => _x('Book', 'post type singular name', 'wp-book'),
              'add_new'            => _x('Add New', 'book', 'wp-book'),
              'add_new_item'       => __('Add New Book', 'wp-book'),
              'edit_item'          => __('Edit Book', 'wp-book'),
              'new_item'           => __('New Book', 'wp-book'),
              'all_items'          => __('All Books', 'wp-book'),
              'view_item'          => __('View Book', 'wp-book'),
              'search_items'       => __('Search Books', 'wp-book'),
              'not_found'          => __('No books found', 'wp-book'),
              'not_found_in_trash' => __('No books found in the Trash', 'wp-book'),
              'menu_name'          => 'Books'
            );
            $args = array(
              'labels'        => $labels,
              'description'   => __('Holds our books and book specific data', 'wp-book'),
              'public'        => true,
              'menu_position' => 5,
              'supports'      => array(
                  'title', 'editor', 'thumbnail', 'excerpt', 'comments'
                ),
              'has_archive'   => true,
            );
            register_post_type('book', $args);
    }

    /**
     * Register book taxonomy
     *
     * @return void
     */
    public function registerWPBookCategory()
    {
        $labels = array(
          'name'              => _x('Book Categories', 'taxonomy general name'),
          'singular_name'     => _x('Book Category', 'taxonomy singular name'),
          'search_items'      => __('Search Book Categories'),
          'all_items'         => __('All Book Categories'),
          'parent_item'       => __('Parent Book Category'),
          'parent_item_colon' => __('Parent Book Category:'),
          'edit_item'         => __('Edit Book Category'), 
          'update_item'       => __('Update Book Category'),
          'add_new_item'      => __('Add New Book Category'),
          'new_item_name'     => __('New Book Category'),
          'menu_name'         => __('Book Categories'),
        );
        $args = array(
          'labels' => $labels,
          'hierarchical' => true,
        );
        register_taxonomy('book_category', 'book', $args);
    }

    /**
     * Registers book tag.
     *
     * @return void
     */
    public function registerWPBookTag()
    {
        $labels = array(
          'name'              => _x('Book Tags', 'taxonomy general name'),
          'singular_name'     => _x('Book Tag', 'taxonomy singular name'),
          'search_items'      => __('Search Book Tags'),
          'all_items'         => __('All Book Tags'),
          'edit_item'         => __('Edit Book Tag'), 
          'update_item'       => __('Update Book Tag'),
          'add_new_item'      => __('Add New Book Tag'),
          'new_item_name'     => __('New Book Tag'),
          'menu_name'         => __('Book Tags'),
        );
        $args = array(
          'labels' => $labels,
          'hierarchical' => false,
        );
        register_taxonomy('book_tag', 'book', $args);
    }

    /**
     * Registers book custom meta box.
     *
     * @return void
     */
    public function addWPBookMetaBox()
    {
        add_meta_box(
            'book_info_meta_box',
            'Book Information',
            array($this, 'bookMetaContent'),
            'book',
            'side'
        );
    }

    /**
     * Form for the meta box.
     * 
     * @param mixed $post 
     * 
     * @return void
     */
    public function bookMetaContent($post)
    {
        wp_nonce_field(plugin_basename(__FILE__), 'product_price_box_content_nonce');
        echo '<label for="author_name"></label>';
        echo '<input type="text" id="author_name" name="author_name" placeholder="' . __('Enter author name', 'wp-book') . '" />';
        echo '<label for="price"></label>';
        echo '<input type="text" id="price" name="price" placeholder="' . __('Enter price', 'wp-book') . '" />';
        echo '<label for="publisher"></label>';
        echo '<input type="text" id="publisher" name="publisher" placeholder="' . __('Enter publisher name', 'wp-book') . '" />';
        echo '<label for="year"></label>';
        echo '<input type="text" id="year" name="year" placeholder="' . __('Enter year of publishing', 'wp-book') . '" />';
    }

    /**
     * Saving the book information.
     *
     * @param [type] $post_id 
     * @param [type] $post 
     * 
     * @return void
     */
    public function saveBookMeta($post_id, $post)
    {
        if (isset($_POST['author_name']) && !empty($_POST['author_name'])) {
            $author_name = sanitize_text_field($_POST['author_name']);
            update_metadata('book', $post_id, 'author_name', $author_name);
        }

        if (isset($_POST['price']) && !empty($_POST['price'])) {
            $price = sanitize_text_field($_POST['price']);
            update_metadata('book', $post_id, 'price', $price);
        }

        if (isset($_POST['publisher']) && !empty($_POST['publisher'])) {
            $publisher = sanitize_text_field($_POST['publisher']);
            update_metadata('book', $post_id, 'publisher', $publisher);
        }

        if (isset($_POST['year']) && !empty($_POST['year'])) {
            $year = sanitize_text_field($_POST['year']);
            update_metadata('book', $post_id, 'year', $year);
        }
    }

    /**
     * Deleting book information.
     *
     * @param [type] $post_id 
     * @param [type] $post     
     * 
     * @return void
     */
    public function deleteBookMeta($post_id)
    {
        delete_metadata('book', $post_id, 'author_name');
    }

    /**
     * Lets wordpress know about the custom meta table
     *
     * @return void
     */
    public function registerBookMetadataTable()
    {
        global $wpdb;
        $wpdb->bookmeta = $wpdb->prefix . 'bookmeta';
    }

    /**
     * Registers a settings group for book CPT.
     *
     * @return void
     */
    public function registerBookSettings()
    {
        register_setting('bookCPTGroup', 'bookCPTSettings');
    }

    /**
     * Content to display on settings submenu of Book menu.
     *
     * @return void
     */
    public function bookOptionPageContent()
    {
        global $book_options;
        ob_start(); ?>
        <div class="wrap">
            <h2>Book Settings</h2>
            <form method="POST" action="options.php">
                <?php settings_fields('bookCPTGroup'); ?>

                <h4><?php _e('Currency', 'wp-book') ?></h4>
                <?php $currencies = array('INR', 'USD', 'EUR', 'JPY', 'GBP'); ?>
                <select name="bookCPTSettings[currency]"
                        id="bookCPTSettings[currency]">
                    <?php foreach ($currencies as $currency) { ?>
                        <?php if ($book_options['currency'] == $currency) {
                            $selected = 'selected=selected';
                        } else {
                            $selected = '';
                        } ?>
                        <option value="<?php echo $currency; ?>"
                                        <?php echo $selected; ?> >
                                        <?php echo $currency; ?>
                        </option>
                    <?php } ?>
                </select>

                <h4><?php _e('Number of books per page', 'wp-book') ?></h4>
                <?php $numPerPage = array(5, 10, 20); ?>
                <select name="bookCPTSettings[numPerPage]"
                        id="bookCPTSettings[numPerPage]">
                    <?php foreach ($numPerPage as $numPerPage) { ?>
                        <?php if ($book_options['numPerPage'] == $numPerPage) {
                            $selected = 'selected=selected';
                        } else {
                            $selected = '';
                        } ?>
                        <option value="<?php echo $numPerPage; ?>"
                                        <?php echo $selected; ?> >
                                        <?php echo $numPerPage; ?>
                        </option>
                    <?php } ?>
                </select>
                
                <p class="submit">
                    <input  type="submit" 
                            class="button-primary"
                            value="Save Options" />
                </p>

            </form>
        </div>
        <?php
            echo ob_get_clean();
    }

    /**
     * Adds the actual submenu page under Book menu
     *
     * @return void
     */
    public function addBookSettingsPage()
    {
        add_submenu_page(
            'edit.php?post_type=book', 'Book Settings', 'Book Settings',
            'manage_options', 'book-settings-page',
            array($this, 'bookOptionPageContent')
        );
    }



}
