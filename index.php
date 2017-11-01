<?php

/*
Plugin Name: Crypto Management
Plugin URI: http://nddh-demo.info/wordpress/
Description: Hello
Version: 1.0
Author: Mr. Vũ Tùng Lâm
Author URI: www.vn.freelancer.com/u/nddungha.html

*/

//define("WP_MEMORY_LIMIT", "256M");
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
 $jal_db_version = '1.2';
function cry_sm_db_install() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'wallet';
    $table_name2 = $wpdb->prefix . 'date_check';
    $table_name3 = $wpdb->prefix . 'date_check_wallet_balance';
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
        uid INT NOT NULL,
        ratebtc_usd varchar(255) NOT NULL,
        ratebtc_eur varchar(255) NOT NULL,
        rateeth_usd varchar(255) NOT NULL,
        rateeth_eur varchar(255) NOT NULL,
        ratexrp_usd varchar(255) NOT NULL,
        ratexrp_eur varchar(255) NOT NULL,
        rateltc_usd varchar(255) NOT NULL,
        rateltc_eur varchar(255) NOT NULL,
        rateuro_usd varchar(255) NOT NULL,
        rateuro_eur varchar(255) NOT NULL,
        ratebcy_usd varchar(255) NOT NULL,
        ratebcy_eur varchar(255) NOT NULL,
        ratedoge_usd varchar(255) NOT NULL,
        ratedoge_eur varchar(255) NOT NULL,      
        PRIMARY KEY  (id)
        ) $charset_collate;

        CREATE TABLE $table_name3 (
        id  INT NOT NULL AUTO_INCREMENT,
        date_check_id  INT NOT NULL ,
        wallet_id INT NOT NULL,
        amount text DEFAULT '' NOT NULL,       
        uid INT NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;

    ";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'cy_sm_db_version', $jal_db_version );
}
register_activation_hook( __FILE__, 'cry_sm_db_install' );
function cry_update_db_check() {
    global $jal_db_version;
    if ( get_site_option( 'cy_sm_db_version' ) != $jal_db_version ) {
        cry_sm_db_install();
    }
    
}
add_action( 'plugins_loaded', 'cry_update_db_check' );

register_uninstall_hook(  __FILE__, 'cry_prefix_uninstall' );

function cry_prefix_uninstall(){
    global $wpdb;
    global $jal_db_version;

    $table_name  = $wpdb->prefix . 'wallet';
    $table_name2 = $wpdb->prefix . 'date_check';
    $table_name3 = $wpdb->prefix . 'date_check_wallet_balance';

    $charset_collate = $wpdb->get_charset_collate();

    $sql  = "DROP TABLE IF EXISTS ".$table_name ." ; " ;     
    $sql2 = "DROP TABLE IF EXISTS ".$table_name2 ." ; " ;     
    $sql3 = "DROP TABLE IF EXISTS ".$table_name3 ." ; " ;    

    $wpdb->query( $sql );     
    $wpdb->query( $sql2 );   
     $wpdb->query( $sql3 );    

    delete_option('cy_sm_db_version');
}
/**-------------------------------- CORE FUNCTION REGION---------------------------------- */
/** BLOCKCYPHER FUNCTION */
 function cry_Createrequest($currency){
    update_option( "tokenblockchain", '0a45a7a148ca49a88056f9235ba0f513', true );
    //$apiContext = new \BlockCypher\Rest\ApiContext(new \BlockCypher\Auth\SimpleTokenCredential($token));
    $token = get_option( "tokenblockchain", TRUE );
	$apiContext = ApiContext::create(
		'main', $currency, 'v1',
		new SimpleTokenCredential($token)
    );
    $addressClient = new AddressClient($apiContext);
	return $addressClient;
}

function cry_ReturnAddressval($currency,$addresspublic){
    $address=null;
    try{
        $addressClient = cry_Createrequest($currency);
        $address = $addressClient->getBalance($addresspublic);
    }catch(Exception $ex){

    }    
	//$addressBalance = $addressClient->getBalance('0x249a0B8A85da020D53Bec45a4764998FC796Ab78');
	//echo "JSON Address: " . $address->getAddress() . "\n";
	return $address;
}
function cry_GetFullAddressval($currency,$addresspublic,$limit){
    $addressfull=null;
    try{
        $addressClient = cry_Createrequest($currency);
        $addressfull = $addressClient->get($addresspublic,array("limit"=>$limit));
    }catch(Exception $ex){

    }    
	//$addressBalance = $addressClient->getBalance('0x249a0B8A85da020D53Bec45a4764998FC796Ab78');
	//echo "JSON Address: " . $address->getAddress() . "\n";
	return $addressfull;
}

/**   */
// XRP BALANCE
function cry_getxrpbalance($address){
    $url = "https://data.ripple.com/v2/accounts/".$address."/balances?currency=XRP";
    $content = json_decode(file_get_contents($url));
    return  $content->balances[0]->value;
}
// check xrp address
function cry_checkxrpaddress($address){
    $url = "https://data.ripple.com/v2/accounts/".$address."/balances?currency=XRP";
    if (get_http_response_code($url)==200){
        $content = json_decode(file_get_contents($url));
        return  $content->result;  
    }else return "error";
}
// get xrp payments transaction
function cry_xrptransaction($address,$limit){
    $url = "https://data.ripple.com/v2/accounts/".$address."/payments?limit=".$limit;
    $content = json_decode((file_get_contents($url)));
    return $content->payments;
}
// get exchange money value
function cry_getallexchange($basecoin,$currency){   
    $coinurl = "https://api.cryptonator.com/api/ticker/".$basecoin."-".$currency."";
    $content = json_decode(file_get_contents($coinurl));
    return  $content->ticker->price;   
}
// check response code
function get_http_response_code($domain1) {
    $headers = get_headers($domain1);
    return substr($headers[0], 9, 3);
  }
// GET EX CHANGE FROM OPTION

function cry_exchangeoption($basecoin,$currency){
    $option = "cry_".$basecoin."_".$currency;
    return get_option($option);
}


/** API CONTENTS FUNCTION */


// function get wallet with id
function cry_getwalletwithid($id){
    $cuid = get_current_user_id();
    global $wpdb;
    $table = $wpdb->prefix."wallet";
    $sql = "SELECT * FROM ".$table." WHERE id = ".$id." AND uid = ".$cuid." ;";
    return $wpdb->get_results($sql);
}
// FUNCTION GET CHECKDATE POSITION OF USER
function cry_getcheckdatepos(){
    $cuid = get_current_user_id();
    global $wpdb;
    $table = $wpdb->prefix."date_check";
    $sql = "SELECT date_check FROM ".$table." WHERE uid = ".$cuid." GROUP BY DATE(date_check) ;";
    return $wpdb->get_results($sql);

}
// function get all wallet namne of user
function cry_getwalletnameuser(){
    $cuid = get_current_user_id();
    global $wpdb;
    $table = $wpdb->prefix."wallet";
    $sql = "SELECT wallet_name FROM ".$table." WHERE uid = ".$cuid." ORDER BY id ASC ;";
    return $wpdb->get_results($sql);
}
// function get check date
function cry_getcheckdate($date){
    $cuid = get_current_user_id();
    global $wpdb;
    $table1 = $wpdb->prefix."date_check_wallet_balance";
    $table2 = $wpdb->prefix."date_check";
    $table3 = $wpdb->prefix."wallet";
    $curday = new DateTime($date);
    
    $nextday = new DateTime($date);
    $nextday->add(new DateInterval('P1D'));
    
    $sql = "SELECT *, SUM(".$table1.".amount) AS total FROM ".$table2." JOIN ".$table1." ON ".$table2.".id  = ".$table1.".date_check_id JOIN ".$table3." ON ".$table3.".id = ".$table1.".wallet_id WHERE ".$table2.".date_check BETWEEN '".$curday->format('Y-m-d')."' AND '".$nextday->format('Y-m-d')."' AND ".$table2.".uid = ".$cuid." GROUP BY ".$table1.".wallet_id ;" ;
    return $wpdb->get_results($sql);
}
// function core get all wallet 
// function add wallet
function cry_addwallet($name,$address,$currency){
    $cuid = get_current_user_id();
    if (cry_ReturnAddressval($currency,$address)!=null||cry_checkxrpaddress($address)!="error"){
        global $wpdb;
        $table = $wpdb->prefix."wallet";
        // check if this wallet already added 
        $sqlcheck = "SELECT COUNT(*) FROM  ".$table." WHERE uid = ".$cuid." AND address = '".$address."' ;";
        $result = $wpdb->get_var($sqlcheck);

        if ($result>0){
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
// function update wallet
function cry_updatewallet($wid,$currency,$name,$address){
    $cuid = get_current_user_id();
    if (cry_ReturnAddressval($currency,$address)!=null||cry_checkxrpaddress($address)!="error"){
        global $wpdb;
        $table = $wpdb->prefix."wallet";
        // check if this wallet already added 
        $sqlcheck = "SELECT COUNT(*) FROM  ".$table." WHERE uid = ".$cuid." AND address = '".$address."' AND id <> '".$wid."' ;";
        $result = $wpdb->get_var($sqlcheck);

        if ($result>0){
            return 2;  
        }
        else {
            // success in checking
            $sql = "UPDATE ".$table." SET wallet_name = '".$name."', address = '".$address."', currency = '".$currency."' WHERE id = '".$wid."' ;";
            return $wpdb->query($sql);
        }
    }
    else return 0;
}
// function delete a wallet
function cry_deletewallet($wid){
    $cuid = get_current_user_id();
    global $wpdb;
    $table = $wpdb->prefix."wallet";   
    $table3 = $wpdb->prefix."date_check_wallet_balance";

    $sql = "DELETE FROM ".$table." WHERE id = '".$wid."' AND uid = '".$cuid."';" ;    
    $sql3 = "DELETE FROM ".$table3." WHERE wallet_id = '".$wid."' AND uid = '".$cuid."';" ;
    
    $wpdb->query($sql);
    $wpdb->query($sql3);
}
// insert date_check_wallet_balance
function cry_insert_checkdatebalance($wallet_id){
    $cuid = get_current_user_id();
    $datecheck = Date("Y-m-d H:i:s");   
    $date_check_id = cry_insert_checkdate();
    $balance = "0";
    global $wpdb;
    $table = $wpdb->prefix."wallet";
    $sql = "SELECT * FROM ".$table ." WHERE id= ".$wallet_id.";";
    $res =  $wpdb->get_results($sql);
    foreach ($res as $key => $value) {
        if ($value->currency=="xrp")
        $balance = floatval( cry_getxrpbalance($value->address));
        else
        if ($value->currency=="eth")
        $balance = floatval( current(cry_ReturnAddressval($value->currency,$value->address))['final_balance'])/1000000000000000000;
        else
        $balance = floatval( current(cry_ReturnAddressval($value->currency,$value->address))['final_balance'])/100000000000;
        break;
    }
    
    $tableinsert = $wpdb->prefix."date_check_wallet_balance";
    $sqlinsert = "INSERT INTO ".$tableinsert." (date_check_id,wallet_id,amount,uid) VALUES ( ".$date_check_id." , ".$wallet_id." , '".$balance."', ".$cuid." ) ;";
    return $wpdb->query($sqlinsert);
}
// insert check date
function cry_insert_checkdate(){
    $cuid = get_current_user_id();
    $datecheck = Date("Y-m-d H:i:s");    
    $btc_usd  = cry_exchangeoption("btc","usd");
    $btc_eur  = cry_exchangeoption("btc","eur");
    $eth_usd  = cry_exchangeoption("eth","usd");
    $eth_eur  = cry_exchangeoption("eth","eur");
    $xrp_usd  = cry_exchangeoption("xrp","usd");
    $xrp_eur  = cry_exchangeoption("xrp","eur");
    $ltc_usd  = cry_exchangeoption("ltc","usd");
    $ltc_eur  = cry_exchangeoption("ltc","eur");
    $uro_usd  = cry_exchangeoption("uro","usd");
    $uro_eur  = cry_exchangeoption("uro","eur");
    $bcy_usd  = cry_exchangeoption("bcy","usd");
    $bcy_eur  = cry_exchangeoption("bcy","eur");
    $doge_usd  = cry_exchangeoption("doge","usd");
    $doge_eur  = cry_exchangeoption("doge","eur");   
    global $wpdb;
    $table = $wpdb->prefix."date_check";
    $sql = "INSERT INTO ".$table. "(date_check,uid, ratebtc_usd ,ratebtc_eur , rateeth_usd ,rateeth_eur ,ratexrp_usd ,ratexrp_eur ,rateltc_usd , rateltc_eur ,rateuro_usd ,rateuro_eur ,ratebcy_usd ,ratebcy_eur ,ratedoge_usd ,ratedoge_eur )
            VALUES ('".$datecheck."', ".$cuid.",'".$btc_usd."','".$btc_eur."','".$eth_usd."','".$eth_eur."','".$xrp_usd."','".$xrp_eur."','".$ltc_usd."','".$ltc_eur."','".$uro_usd."','".$uro_eur."','".$bcy_usd."','".$bcy_eur."','".$doge_usd."','".$doge_eur."' ) ;";
    $wpdb->query($sql);
    return $wpdb->insert_id;

}

function test(){

    print_r(get_option("cry_btc_eur"));
    print_r(get_option("cry_btc_usd"));
   /* global $wpdb;
         $table_name  = $wpdb->prefix . 'wallet';
         $sql = "DELETE  FROM ".$table_name;
         return $wpdb->query($sql);
    /* global $wpdb;
         $table_name  = $wpdb->prefix . 'wallet';
         $sql = "SHOW TABLES";
         return $wpdb->get_results($sql);
*/
    /* $cuid = get_current_user_id();
        global $wpdb;
         $table_name  = $wpdb->prefix . 'wallet';
    $table_name2 = $wpdb->prefix . 'date_check';
    $table_name3 = $wpdb->prefix . 'date_check_wallet_balance';

   delete_option('cy_sm_db_version');
    delete_option('sm_db_version');

    $sql  = "DROP TABLE IF EXISTS ".$table_name ." ; " ;     
    $sql2 = "DROP TABLE IF EXISTS ".$table_name2 ." ; " ;     
    $sql3 = "DROP TABLE IF EXISTS ".$table_name3 ." ; " ;    

    $wpdb->query( $sql );     
    $wpdb->query( $sql2 );   
     $wpdb->query( $sql3 ); */

        //return $res;
}


/** ---------------------------------AJAX REGION------------------------------------------ */
// ajax get 
//ajax get all wallet name
    function cry_getwalletname(){
        echo json_encode(cry_getwalletnameuser());
        die();
    }
    add_action( 'wp_ajax_cry_getwalletname', 'cry_getwalletname' );
// ajax get data for area chart
    function cry_getarechart(){
        $cuid = get_current_user_id();
        $allcheckdate = cry_getcheckdatepos();
        $alldatawallet =array();
        foreach ($allcheckdate as $key => $value) {
            $alldatawallet[] = cry_getcheckdate($value->date_check);           
           
        }       

        echo json_encode($alldatawallet);
        die();
    } 
    add_action( 'wp_ajax_cry_getarechart', 'cry_getarechart' );   

// ajax insert check date to database
    function cry_insertcheckdate(){
        $cuid = get_current_user_id();
        global $wpdb;
        $table = $wpdb->prefix."wallet";
        $sql = "SELECT * FROM ".$table ." WHERE uid= ".$cuid.";";
        $a =array();
        $res =  $wpdb->get_results($sql);
        if (count($res)>0){
            foreach ($res as $key => $value) {
                cry_insert_checkdatebalance($value->id);
            }
            echo "Check date successfully !";
        }else echo "No data for insert!";
        die();
    }
    add_action( 'wp_ajax_cry_insertcheckdate', 'cry_insertcheckdate' );
//ajax calculate all balance in all wallet 
    function cry_returnallbalance(){
        $cuid = get_current_user_id();
        global $wpdb;
        $table = $wpdb->prefix."wallet";
        $sql = "SELECT * FROM ".$table ." WHERE uid= ".$cuid.";";
        $a =array();
        $res =  $wpdb->get_results($sql);
        foreach ($res as $key => $value) {
            if ($value->currency=="xrp")
            $balance = floatval( cry_getxrpbalance($value->address));
            else
            if ($value->currency=="eth")
            $balance = floatval( current(cry_ReturnAddressval($value->currency,$value->address))['final_balance'])/10000000000000000000;
            else
            $balance = floatval( current(cry_ReturnAddressval($value->currency,$value->address))['final_balance'])/100000000000;
            $a[] = array($value->wallet_name,$balance,$value->currency);
        }
        echo json_encode($a);	
        die();

    }
    add_action( 'wp_ajax_cry_returnallbalance', 'cry_returnallbalance' );
// ajax action calculate all money
    function cry_getallmoney(){
        $cuid = get_current_user_id();
        $cur_currency = get_user_meta( $cuid, "user_currency", TRUE );
        if ($cur_currency!='') $cur_currency="usd";
        $a =array();
        global $wpdb;
        $table = $wpdb->prefix."wallet";
        $sql = "SELECT * FROM ".$table ;
        $res =  $wpdb->get_results($sql);
        $balance=0.0;
        foreach ($res as $key => $value) {
            if ($value->currency=="xrp")
            {
                $exbl = floatval(cry_getxrpbalance($value->address));
               
                $balance += (((float)$exbl))*((float)cry_exchangeoption($value->currency,$cur_currency));
            }
            else if ($value->currency=="eth"){
                $exbl = floatval(current(cry_ReturnAddressval($value->currency,$value->address))['final_balance']);
                $balance += ( ((float)$exbl )/10000000000000000000)*((float)cry_exchangeoption($value->currency,$cur_currency));}
            else {
                $exbl = floatval(current(cry_ReturnAddressval($value->currency,$value->address))['final_balance']);
                $balance += ( ((float)$exbl )/100000000000)*((float)cry_exchangeoption($value->currency,$cur_currency));
            }
        }
        echo  $balance;
        die();
    }
    add_action( 'wp_ajax_cry_getallmoney', 'cry_getallmoney' );
// ajax get transaction in address
    function cry_gettransaction(){       
        $currency = $_POST['currency'];
        $address = $_POST['address'];
        $limit = $_POST['limit'];
        $return = array();
        $a = array();
        $response = array();
       
        if ($currency=="xrp"){
            //get transaction xrp
            $return = cry_xrptransaction($address,$limit);
            foreach ($return as $key => $value) {
                $a['id'] = $key;               
               
                $date = $value->executed_time;
                $a['dateconfirm'] =  date('Y-m-d H:i:s', strtotime($date));
                
                if ($value->destination!=$address){
                    $a['amount'] = floatval($value->amount)*(-1);
                }
                else {
                    $a['amount'] = floatval($value->amount);
                }
                $a['usd'] =  $a['amount']*((float)cry_exchangeoption($currency,"usd"));
                $a['eur'] =  $a['amount']*((float)cry_exchangeoption($currency,"eur")); 
                
                $response['data'][] = $a; 
            }
        }
        else {
            // get transaction other coin
            $return =  cry_GetFullAddressval($currency,$address,$limit);
            foreach (current($return)['txrefs'] as $key => $value) {
                $a['id'] = $key;
                 if (current($value)['tx_input_n']==-1){
                     if ($currency=="eth"){
                        $a['amount'] =  floatval(current($value)['value'])/1000000000000000000;
                     }else 
                        $a['amount'] =  floatval(current($value)['value'])/1000000000000;
                 }
                 else {
                    
                    if ($currency=="eth"){
                        $a['amount'] =  floatval(current($value)['value'])*(-1)/1000000000000000000;
                     }else 
                        $a['amount'] =  floatval(current($value)['value'])*(-1)/1000000000000;
                 }
                $a['usd'] =  $a['amount']*((float)cry_exchangeoption($currency,"usd"));
                $a['eur'] =  $a['amount']*((float)cry_exchangeoption($currency,"eur"));
                $date = current($value)['confirmed'];
                $a['dateconfirm'] =  date('Y-m-d H:i:s', strtotime($date));
                
                $response['data'][] = $a; 
                
            }
        }
        echo json_encode($response);
        die();
    }
    add_action( 'wp_ajax_cry_gettransaction', 'cry_gettransaction' );


// ajax get all wallet in table
    function cry_getallwallet(){
        $cuid = get_current_user_id();
        global $wpdb;
        $table = $wpdb->prefix."wallet";        
        $sql = "SELECT * FROM ".$table." WHERE uid = ".$cuid." ;";
        $a =array();
        $response = array();
        $res =  $wpdb->get_results($sql);
        
        foreach ($res as $key => $value) {
            if ($value->currency=="xrp") 
                $balance = cry_getxrpbalance($value->address);
            else 
            if  ($value->currency=="eth") 
                $balance = floatval(current(cry_ReturnAddressval($value->currency,$value->address))['final_balance'])/1000000000000000000; 
            else
                $balance = floatval(current(cry_ReturnAddressval($value->currency,$value->address))['final_balance'])/100000000; 
            
            $a['id'] =  $value->id;
            $a['name'] = $value->wallet_name;
            $a['currency'] = $value->currency;
            $a['amount'] = $balance;
            $a['eur'] = $balance*((float)cry_exchangeoption($value->currency,'eur'));
            $a['usd'] = $balance*((float)cry_exchangeoption($value->currency,'usd'));
            $response['data'][] = $a;
        }    
        echo json_encode($response);
        die();
    }
    add_action( 'wp_ajax_cry_getallwallet', 'cry_getallwallet' );
// ajax function save note
    function cry_save_note(){
        
        update_user_meta( get_current_user_id(), 'user_note', urlencode($_POST['user_note']));
        $rel = urldecode(get_user_meta( get_current_user_id(), 'user_note', true ));
        echo json_encode($rel);	
        die();
    }
    add_action( 'wp_ajax_cry_save_note', 'cry_save_note' );
// ajax function get wallet with id
    function cry_getwalletid(){
        $id = $_POST['walletid'];
        $rel = cry_getwalletwithid($id);
        echo json_encode($rel);	
        die();
    }
    add_action( 'wp_ajax_cry_getwalletid', 'cry_getwalletid' );


// ADD SHORTCODE 

function cry_exchangecron(){
    $basecoin = array("btc","eth","ltc","xrp","bcy","uro","doge");

    foreach ($basecoin as $key => $value) {
        $coinurl = "https://api.cryptonator.com/api/ticker/".$value."-USD";
        $content = json_decode(file_get_contents($coinurl));
        $priceusd =   $content->ticker->price;

        update_option("cry_".$value."_usd",$priceusd);

        $coinurl2 = "https://api.cryptonator.com/api/ticker/".$value."-EUR";
        $content2 = json_decode(file_get_contents($coinurl2));
        $priceeur =   $content2->ticker->price;
        
        update_option("cry_".$value."_eur",$priceeur);        
    }
}
add_shortcode( 'crypto_exchange_cronjob', 'cry_exchangecron' );
?>
