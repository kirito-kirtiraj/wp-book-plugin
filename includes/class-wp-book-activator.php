<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.linkedin.com/in/kirtiraj-patil-00b01b185/
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 * @author     Kirtiraj Patil <officialkirtiraj@gmail.com>
 */
class Wp_Book_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * 
     * @since  1.0.0
     */
    public static function activate()
    {
        include_once get_home_path() . 'wp-admin/includes/upgrade.php';
        $response = dbDelta(
            "CREATE TABLE IF NOT EXISTS wp_bookmeta(
            meta_id BIGINT AUTO_INCREMENT NOT NULL,
            book_id BIGINT NOT NULL DEFAULT '0',
            meta_key varchar(255) DEFAULT NULL,
            meta_value longtext,
            KEY book_id (book_id),
            KEY meta_key (meta_key),
            primary key(meta_id)
            );"
        );

        // foreach($response as $res){
        //     echo $res;
        // }

        // die;
    }

    /*
    -- book_id bigint NOT NULL DEFAULT '0', 
            -- meta_key varchar(255) DEFAULT NULL, 
            -- meta_value longtext, 
            -- PRIMARY KEY (meta_id), 
            -- KEY book_id (book_id), 
            -- KEY meta_key (meta_key) ) 
            -- ENGINE=InnoDB DEFAULT CHARSET=utf8; "
    */

}
