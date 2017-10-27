<?php

/*
Plugin Name: Crypto Management
Plugin URI: http://nddh-demo.info/wordpress/
Description: Hello
Version: 1.0
Author: Mr. Vũ Tùng Lâm
Author URI: www.vn.freelancer.com/u/nddungha.html

*/


/** Require client library */
require __DIR__ . '/php-client/blockcypher/php-client/sample/bootstrap.php';
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\AddressClient;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Api\Address; 



/** register template */
class PageTemplateCrypto {
    
        /**
         * A reference to an instance of this class.
         */
        private static $instance;
    
        /**
         * The array of templates that this plugin tracks.
         */
        protected $templates;
    
        /**
         * Returns an instance of this class. 
         */
        public static function get_instance() {
    
            if ( null == self::$instance ) {
                self::$instance = new PageTemplateCrypto();
            } 
    
            return self::$instance;
    
        } 
    
        /**
         * Initializes the plugin by setting filters and administration functions.
         */
        private function __construct() {
    
            $this->templates = array();
    
    
            // Add a filter to the attributes metabox to inject template into the cache.
            if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
    
                // 4.6 and older
                add_filter(
                    'page_attributes_dropdown_pages_args',
                    array( $this, 'register_project_templates' )
                );
    
            } else {
    
                // Add a filter to the wp 4.7 version attributes metabox
                add_filter(
                    'theme_page_templates', array( $this, 'add_new_template' )
                );
    
            }
    
            // Add a filter to the save post to inject out template into the page cache
            add_filter(
                'wp_insert_post_data', 
                array( $this, 'register_project_templates' ) 
            );
    
    
    
            // Add a filter to the template include to determine if the page has our 
            // template assigned and return it's path
            add_filter(
                'template_include', 
                array( $this, 'view_project_template') 
            );
    
    
            // Add your templates to this array.
            $this->templates = array(
                
                './include/crypto_page.php' => 'Crypto Management page'
               
            );
            if (!session_id())
                session_start();    
        } 
    
        /**
         * Adds our template to the page dropdown for v4.7+
         *
         */
        public function add_new_template( $posts_templates ) {
            $posts_templates = array_merge( $posts_templates, $this->templates );
            return $posts_templates;
        }
    
        /**
         * Adds our template to the pages cache in order to trick WordPress
         * into thinking the template file exists where it doens't really exist.
         */
        public function register_project_templates( $atts ) {
    
            // Create the key used for the themes cache
            $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
    
            // Retrieve the cache list. 
            // If it doesn't exist, or it's empty prepare an array
            $templates = wp_get_theme()->get_page_templates();
            if ( empty( $templates ) ) {
                $templates = array();
            } 
    
            // New cache, therefore remove the old one
            wp_cache_delete( $cache_key , 'themes');
    
            // Now add our template to the list of templates by merging our templates
            // with the existing templates array from the cache.
            $templates = array_merge( $templates, $this->templates );
    
            // Add the modified cache to allow WordPress to pick it up for listing
            // available templates
            wp_cache_add( $cache_key, $templates, 'themes', 1800 );
    
            return $atts;
    
        } 
    
        /**
         * Checks if the template is assigned to the page
         */
        public function view_project_template( $template ) {
            
            // Get global post
            global $post;
    
            // Return template if post is empty
            if ( ! $post ) {
                return $template;
            }
    
            // Return default template if we don't have a custom one defined
            if ( ! isset( $this->templates[get_post_meta( 
                $post->ID, '_wp_page_template', true 
            )] ) ) {
                return $template;
            } 
    
            $file = plugin_dir_path( __FILE__ ). get_post_meta( 
                $post->ID, '_wp_page_template', true
            );
    
            // Just to be safe, we check if the file exist first
            if ( file_exists( $file ) ) {
                return $file;
            } else {
                echo $file;
            }
    
            // Return template
            return $template;
    
        }
    
    } 
add_action( 'plugins_loaded', array( 'PageTemplateCrypto', 'get_instance' ) );


// add new db here
// check db and install
global $jal_db_version;
 $jal_db_version = '1.0';
function sm_db_install() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'wallet';
    $table_name2 = $wpdb->prefix . 'date_check';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id  INT NOT NULL AUTO_INCREMENT,
        date_create  TIMESTAMP NOT NULL ,
        wallet_name tinytext NOT NULL,
        address varchar(255) DEFAULT '' NOT NULL,
        uid INT NOT NULL,
        currency varchar(50) NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;

        CREATE TABLE $table_name2 (
        id  INT NOT NULL AUTO_INCREMENT,
        date_check  DATETIME NOT NULL ,
        amount text DEFAULT '' NOT NULL,
        note text DEFAULT '' NOT NULL,
        wid INT NOT NULL,
        uid INT NOT NULL,
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

register_uninstall_hook(  __FILE__, 'cry_prefix_uninstall' );

function cry_prefix_uninstall(){
    global $wpdb;
    global $jal_db_version;

    $table_name  = $wpdb->prefix . 'wallet';
    $table_name2 = $wpdb->prefix . 'date_check';

    $charset_collate = $wpdb->get_charset_collate();

    $sql  = "DROP TABLE IF EXISTS ".$table_name ." ; " ;     
    $sql2 = "DROP TABLE IF EXISTS ".$table_name2 ." ; " ;     

    $wpdb->query( $sql );     
    $wpdb->query( $sql2 );     

    delete_option('sm_db_version');
}
 function Createrequest($currency){
    update_option( "tokenblockchain", '096305d1e6e34f8890e1b70644ec7e9d', true );
    //$apiContext = new \BlockCypher\Rest\ApiContext(new \BlockCypher\Auth\SimpleTokenCredential($token));
    $token = get_option( "tokenblockchain", TRUE );
	$apiContext = ApiContext::create(
		'main', $currency, 'v1',
		new SimpleTokenCredential($token)
    );
    $addressClient = new AddressClient($apiContext);
	return $addressClient;
}
function ReturnAddressval($currency,$addresspublic){
    $address=null;
    try{
        $addressClient = Createrequest($currency);
        $address = $addressClient->getBalance($addresspublic);
    }catch(Exception $ex){

    }    
	//$addressBalance = $addressClient->getBalance('0x249a0B8A85da020D53Bec45a4764998FC796Ab78');
	//echo "JSON Address: " . $address->getAddress() . "\n";
	return $address;
}


// function add wallet
function addwallet($name,$address,$currency){
    $cuid = get_current_user_id();
    if (ReturnAddressval($currency,$address)!=null){
        global $wpdb;
        $table = $wpdb->prefix."wallet";
        // check if this wallet already added 
        $sqlcheck = "SELECT COUNT(*) FROM  ".$table." WHERE uid = ".$cuid." AND address = '".$address."' ;";
        $result = $wpdb->get_var($sqlcheck);

        if (count($result)>0){
            return 2;  
        }
        else {
            // success in checking
            $sql = "INSERT INTO ".$table." ( wallet_name , address, uid,currency) VALUES ('".$name."' , '".$address."' ,".$cuid.",'".$currency."' ) ;";
            return $wpdb->query($sql);
        }
    }
    else return 0;
}
// ajax get all wallet in table
function getallwallet(){
    $cuid = get_current_user_id();
    global $wpdb;
    $table = $wpdb->prefix."wallet";
    $sql = "SELECT * FROM ".$table ;
    $a =array();
    $res =  $wpdb->get_results($sql);
    foreach ($res as $key => $value) {
        $a['data'][] = $value;
    }
    echo json_encode($a);
    die();
}
add_action( 'wp_ajax_getallwallet', 'getallwallet' );
// ajax function save note
function save_note(){
    
    update_user_meta( get_current_user_id(), 'user_note', urlencode($_POST['user_note']));
    $rel = urldecode(get_user_meta( get_current_user_id(), 'user_note', true ));
    echo json_encode($rel);	
	die();
}
add_action( 'wp_ajax_save_note', 'save_note' );


?>
