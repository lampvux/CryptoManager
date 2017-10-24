<?php

/*
Plugin Name: Crypto Management
Plugin URI: http://nddh-demo.info/wordpress/
Description: Hello
Version: 1.0
Author: Mr. Vũ Tùng Lâm
Author URI: www.vn.freelancer.com/u/nddungha.html

*/

///Register style sheet.
add_action( 'wp_enqueue_scripts', 'cry_register_plugin_styles' );
/**
 * Register style sheet.
 */
function cry_register_plugin_styles() {	
}
// Register csript sheet.
add_action( 'wp_enqueue_scripts', 'cry_register_plugin_script' );
/**
 * Register script sheet.
 */
function cry_register_plugin_script() {
	
}
add_action("admin_enqueue_scripts", "cry_register_plugin_styles");
add_action("admin_enqueue_scripts", "cry_register_plugin_script");
// add new db here
// check db and install
global $jal_db_version;
/* $jal_db_version = '1.0';
function sm_db_install() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'investment_fund';
    $table_name2 = $wpdb->prefix . 'portfolio';
    $table_name3 = $wpdb->prefix . 'invested';
    $table_name4 = $wpdb->prefix . 'note';
    $table_name5 = $wpdb->prefix . 'data_invest';
    $table_name6 = $wpdb->prefix . 'share_info';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id  INT NOT NULL AUTO_INCREMENT,
        date_create  DATETIME NOT NULL ,
        title tinytext NOT NULL,
        logo text DEFAULT '' NOT NULL,
        uid INT NOT NULL,
        currency varchar(50) NOT NULL,
        view_type varchar(50) DEFAULT 'public' NOT NULL,
        share_info INT DEFAULT '0' NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;

        CREATE TABLE $table_name2 (
        id  INT NOT NULL AUTO_INCREMENT,
        date_create  DATETIME NOT NULL ,
        title text DEFAULT '' NOT NULL,
        description text DEFAULT '' NOT NULL,
        type text DEFAULT '' NOT NULL,
        fund_id INT NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;

        CREATE TABLE $table_name3 (
        id  INT NOT NULL AUTO_INCREMENT,
        date_create  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
        portfolio_id INT NULL,
        title text DEFAULT '' NOT NULL,
        currency text DEFAULT '' NOT NULL,                   
        PRIMARY KEY  (id)
        ) $charset_collate;

        CREATE TABLE $table_name4 (
        id  INT NOT NULL AUTO_INCREMENT,
        date_create  DATETIME NOT NULL  ,
        type text DEFAULT '' NOT NULL,
        father_id int  NULL,        
        note text DEFAULT '' NOT NULL,             
        PRIMARY KEY  (id)
        ) $charset_collate;

        CREATE TABLE $table_name5 (
        id  INT NOT NULL AUTO_INCREMENT,
        invest_id INT NOT NULL,
        date_create  DATETIME NOT NULL  ,
        type text DEFAULT '' NOT NULL,
        currency varchar(50) NOT NULL,        
        value text DEFAULT '' NOT NULL,             
        PRIMARY KEY  (id)
        ) $charset_collate;

        CREATE TABLE $table_name6 (
        id  INT NOT NULL AUTO_INCREMENT,
        portfolio_id INT NOT NULL,
        share_name text DEFAULT '' NOT NULL,               
        value FLOAT DEFAULT 0 NOT NULL,             
        PRIMARY KEY  (id)
        ) $charset_collate;
       
    ";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'sm_db_version', $jal_db_version );
}
register_activation_hook( __FILE__, 'sm_db_install' );

function sm_update_db_check() {
    global $jal_db_version;
    if ( get_site_option( 'sm_db_version' ) != $jal_db_version ) {
        sm_db_install();
    }

}
add_action( 'plugins_loaded', 'sm_update_db_check' );
 */

?>
