<?php

/**
 * Fired during plugin activation
 *
 * @link       https://newip.pe
 * @since      1.0.0
 *
 * @package    Newcallcenter
 * @subpackage Newcallcenter/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Newcallcenter
 * @subpackage Newcallcenter/includes
 * @author     New IP Solutions SAC <soporte@newip.pe>
 */
class Newcallcenter_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

            global $wpdb;
            $table_name = $wpdb->prefix . 'newcallcenter_call_log';
            $charset_collate = $wpdb->get_charset_collate();
            if($wpdb->get_var( "show tables like '$table_name'" ) != $table_name) {
                $sql = "CREATE TABLE $table_name (
                  id mediumint(11) NOT NULL AUTO_INCREMENT,
                  time datetime DEFAULT now() NOT NULL,
                  phone_number varchar(100) DEFAULT '' NOT NULL,
                  username varchar(255) DEFAULT '' NOT NULL,
                  password varchar(255) DEFAULT '' NOT NULL,                  
                  idcampana varchar(255) DEFAULT '' NOT NULL,                                 
                  api_response text DEFAULT '' NOT NULL,
                  status varchar(255) DEFAULT '1' NOT NULL,
                  PRIMARY KEY  (id)
                ) $charset_collate;";

                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );
               
            }

	}

}
