<?php
// Empecher l'appel direct de la page
defined('ABSPATH') or die("Accès interdit!");
if(!isset($_SESSION)){session_start();}
/*
Plugin Name: SAMM
Plugin URI: 
Description: Plugin de Solution Africaine pour Marchés Multi-vendeurs
Author: Vido Jishu
Author URI: https://vido-int.com/
Version: 1.0.0 



*/

add_action("admin_menu", "addMenu_samm");
function addMenu_samm()
{
  add_menu_page("Solution Africaine pour Marchés Multi-vendeurs", "SAMM", 4, "solution-africaine-pour-marches-multi-vendeurs", "wellcome_samm" );
  add_submenu_page("solution-africaine-pour-marches-multi-vendeurs", "Liste des affiliés", "Liste des affilies", 4, "affilies", "table_affilies");
  add_submenu_page("solution-africaine-pour-marches-multi-vendeurs", "Liste des vendeurs", "Liste des vendeurs", 4, "vendeurs", "table_vendeurs");
  add_submenu_page("solution-africaine-pour-marches-multi-vendeurs", "Demandes de retraits", "Demandes de retraits", 4, "retraits", "table_retraits");
  add_submenu_page("solution-africaine-pour-marches-multi-vendeurs", "Statistiques", "Statistiques", 4, "rapports", "table_rapports");
  add_submenu_page("solution-africaine-pour-marches-multi-vendeurs", "Paramètre", "Paramètre", 4, "parametre", "table_parametre");
}
//////////////////
date_default_timezone_set('Africa/Porto-Novo');

require __DIR__ . '/model/functions.php'; 
require __DIR__ . '/shortcodes.php';
//require __DIR__ . '/css/style.css'; 





// Créer les pages necessaire lors de l'installation
register_activation_hook(__FILE__,'create_page_install');

function create_page_install() {
  create_page( 'Affiliate', '[reg_affiliation_samm]');
  create_page( 'Dashboard Affiliate', '[dashboard_affiliation_samm]');
      //create_page( 'Marchands', '[dashboard_marchands_samm]');
  create_page( 'Pr', '[samm_shot_link]');
  create_page( 'Checkout', '[woocommerce_checkout] [samm_distribution] ');

  if(!wc_get_checkout_url()) {
   create_page( 'Checkout', '[woocommerce_checkout] [samm_distribution] ');
 } else {

   $checkout_pg_id=url_to_postid(wc_get_checkout_url());

   /** @var WP_Post $post */
   $post = get_post( $checkout_pg_id );

   $post->post_content = "[woocommerce_checkout] [samm_distribution] ";

   wp_update_post( $post );


 }
}



//Créer la base de donnée necessaire
register_activation_hook(__FILE__,'create_samm_db');

function create_samm_db() {
  create_affiliate_prod_link_table();
  create_demande_compte_marchant_table();
  create_gain_affiliate_salle_table();
  create_produits_table();
  create_retrait_table();
  create_samm_utilisateurs_table();
  create_utilisateurs_tempo_table();
  create_samm_admin_details_table();
  create_samm_cmd_details_table();
  add_samm_admin_details_table();

}





add_action('plugins_loaded', 'woomomo_payment_gateway_init');
//definir les class du gatway
/**
 * @class          WC_Gateway_Momo
 * @extends        WC_Payment_Gateway
 * @version        1.0.0
 */


//Request payment function start//
add_action( 'init', function() {
  /** Add a custom path and set a custom query argument. */
  add_rewrite_rule( '^/payment/?([^/]*)/?', 'index.php?payment_action=1', 'top' );
} );
add_filter( 'query_vars', function( $query_vars ) {
  /** Make sure WordPress knows about this custom action. */
  $query_vars []= 'payment_action';
  return $query_vars;
} );
add_action( 'wp', function() {
  /** This is an call for our custom action. */
  if ( get_query_var( 'payment_action' ) ) {
        // your code here
    woomomo_request_payment();
  }
} );
//Request payment function end
//Results scanner function start
add_action( 'init', function() {
  
  add_rewrite_rule( '^/scanner/?([^/]*)/?', 'index.php?scanner_action=1', 'top' );
} );
add_filter( 'query_vars', function( $query_vars ) {
  
  $query_vars []= 'scanner_action';
  return $query_vars;
} );
add_action( 'wp', function() {
  
    //if ( get_query_var( 'scanner_action' ) ) {
        // invoke scanner function
		//woomomo_scan_transactions();
    //}
} );
//Results scanner function end
function woomomo_payment_gateway_init() {
  if( !class_exists( 'WC_Payment_Gateway' )) return;
  class WC_Gateway_Momo extends WC_Payment_Gateway {
/**
*  Plugin constructor for the class
*/
public function __construct(){		
  
  if(!isset($_SESSION)){
   session_start(); 
 }
 $this->id                 = 'samm_momo';
 $this->icon               = plugin_dir_url(__FILE__) . 'samm_momo.jpg';
 $this->has_fields         = false;
 $this->method_title       = __( 'MTN Momo', 'woocommerce' );
 $this->method_description = __( 'SAMM intègre le moyen de paiement le plus accessible à tous!' );
 
        // load the settings
 $this->init_form_fields();
 $this->init_settings();
        // Define variables set by the user in the admin section
 $this->title            = $this->get_option( 'title' );
 $this->description      = $this->get_option( 'description' );
 $this->instructions     = $this->get_option( 'instructions', $this->description );
 $this->mer              = $this->get_option( 'mer' );	
 
 $_SESSION['order_status'] = $this->get_option('order_status');
 $_SESSION['environment_type'] = $this->get_option('environment_type');
 $_SESSION['credentials_endpoint_momo']   = $this->get_option( 'credentials_endpoint' ); 
 $_SESSION['payments_endpoint_momo']   	= $this->get_option( 'payments_endpoint' ); 
 $_SESSION['passkey_momo']      			= $this->get_option( 'passkey_momo' ); 
 $_SESSION['ck_momo']      				= $this->get_option( 'api_user' ); 
 $_SESSION['cs_momo']   					= $this->get_option( 'api_key' );
 $_SESSION['currency']   					= $this->get_option( 'currency' );
 
        //Save the admin options
 if ( version_compare( WOOCOMMERCE_VERSION, '2.0.0', '>=' ) ) {
  add_action( 'woocommerce_update_options_payment_gateways_'.$this->id, array( $this, 'process_admin_options' ) );
} else {
  add_action( 'woocommerce_update_options_payment_gateways', array( $this, 'process_admin_options' ) );
}
add_action( 'woocommerce_receipt_momo', array( $this, 'receipt_page' ));

}
/**
*Initialize form fields that will be displayed in the admin section.
*/
public function init_form_fields() {
  $this->form_fields = array(
    'enabled' => array(
      'title'   => __( 'Enable/Disable', 'woocommerce' ),
      'type'    => 'checkbox',
      'label'   => __( 'Activer MTN Momo de SAMM', 'woocommerce' ),
      'default' => 'yes'
    ),
    'title' => array(
      'title'       => __( 'Title', 'woocommerce' ),
      'type'        => 'text',
      'description' => __( 'Titre de la méthode de paiement sur votre page checkout.', 'woocommerce' ),
      'default'     => __( 'Payer par MTN MoMo avec SAMM', 'woocommerce' ),
      'desc_tip'    => true,
    ),
    'description' => array(
      'title'       => __( 'Description', 'woocommerce' ),
      'type'        => 'textarea',
      'description' => __( 'Description sur la page checkout.', 'woocommerce' ),
      'default'     => __( 'Commandez et payez par MTN MoMo.'),
      'desc_tip'    => true,
    ),
    'instructions' => array(
      'title'       => __( 'Instructions', 'woocommerce' ),
      'type'        => 'textarea',
      'description' => __( 'Instructions Sur la page de remerciement.', 'woocommerce' ),
      'default'     => __( 'Commandez et payez par MTN MoMo.', 'woocommerce' ),
                // 'css'         => 'textarea { read-only};',
      'desc_tip'    => true,
    ),
    'mer' => array(
      'title'       => __( 'Nom commercial', 'woocommerce' ),
      'description' => __( 'Nom commercial de votre boutique', 'woocommerce' ),
      'type'        => 'text',
      'default'     => __( 'Nom commercial', 'woocommerce'),
      'desc_tip'    => false,
    ),
    
      ///Give option to choose order status
    
    'order_status' => array( 
      'title'       => __( 'Successful Payment Status', 'woocommerce' ),
      'type'        => 'select',  
      'options' => array(   
        1 => __( 'On Hold', 'woocommerce' ),  
        2 => __( 'Processing', 'woocommerce' ), 
        3 => __( 'Completed', 'woocommerce' ) 
      ),          
      'description' => __( 'Statut des paiements.', 'woocommerce' ),  
      'desc_tip'    => false, 
    ),
    
    'environment_type' => array( 
      'title'       => __( 'Environment', 'woocommerce' ),
      'type'        => 'text',
      'description' => __( 'Sandbox par défaut.', 'woocommerce' ),  
      'default'     => __( 'sandbox', 'woocommerce'),   
      'description' => __( 'Environment(Sandbox/Live) .', 'woocommerce' ), 
      'desc_tip'    => false, 
    ),
    
    
    'currency' => array( 
      'title'       => __( 'Devise', 'woocommerce' ),
      'type'        => 'text',
      'description' => __( 'Devise par défaut.', 'woocommerce' ), 
      'default'     => __( 'CFA', 'woocommerce'),
      'desc_tip'    => false, 
    ),
    
      ///End in modification
    
    'credentials_endpoint' => array(
      'title'       =>  __( 'Credentials Endpoint(Sandbox/Production)', 'woocommerce' ),
      'default'     => __( 'https://sandbox.momodeveloper.mtn.com/collection/token/', 'woocommerce'),
      
      'description' => __( 'Endpoint de Sandbox ou de Production', 'woocommerce' ),
      'type'        => 'text',
      
    ),        
    'payments_endpoint' => array(
      'title'       =>  __( 'Payments Endpoint(Sandbox/Production)', 'woocommerce' ),
      'default'     => __( 'https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay', 'woocommerce'),
      
      'description' => __( 'Endpoint de Sandbox ou de Production', 'woocommerce' ),
      'type'        => 'text',
    ),
    'passkey_momo' => array(
      'title'       =>  __( 'Ocp Apim Subscription Key', 'woocommerce' ),
      'default'     => __( '', 'woocommerce'),
      'type'        => 'password',
    ),
    
    'api_user' => array(
      'title'       =>  __( 'API User', 'woocommerce' ),
      'default'     => __( '', 'woocommerce'),
      'type'        => 'password',
    ),
    'api_key' => array(
      'title'       =>  __( 'API Key', 'woocommerce' ),
      'default'     => __( '', 'woocommerce'),
      'type'        => 'password',
    )
  );
}
/**
 * Generates the HTML for admin settings page
 */
public function admin_options(){
    /*
     *The heading and paragraph below are the ones that appear on the backend MoMo settings page
     */
    echo '<h3>' . 'SAMM MTN MoMo réglage' . '</h3>';
    
    //echo '<p>' . 'Simple et accessible à tous' . '</p>';
    
    echo '<table class="form-table">';
    
    $this->generate_settings_html( );
    
    echo '</table>';
  }
/**
 * Receipt Page
 **/
public function receipt_page( $order_id ) {
  echo $this->woomomo_generate_iframe( $order_id );
}
/**
 * mets les params
 */
public function woomomo_generate_iframe( $order_id ) {
  global $woocommerce;
  $order = new WC_Order ( $order_id );
  $_SESSION['total'] = (int)$order->order_total;
  $tel = $order->billing_phone;
    //netoie le num phone
  $tel = str_replace("-", "", $tel);
  $tel = str_replace( array(' ', '<', '>', '&', '{', '}', '*', "+", '!', '@', '#', "$", '%', '^', '&'), "", $tel );
  
  $_SESSION['tel'] = substr($tel, -11);
  
  

  if ($_GET['transactionType']=='checkout') {
   
    ?>
    
    <input type="hidden" value="" id="txid"/>	
    <?php echo $_SESSION['response_status']; ?>
    <div id="commonname"></div>
    <button onClick="pay()" id="pay_btn">Payer</button>
    <?php	
    echo "<br/>";
  }
}
/**
* 
*
*
*
*/
public function process_payment( $order_id ) {
  $order = new WC_Order( $order_id );		
  $_SESSION['orderID'] = $order->id;      		
       // Redirect to checkout/pay page
  $checkout_url = $order->get_checkout_payment_url(true);
  $checkout_edited_url = $checkout_url."&transactionType=checkout";
  return array(
    'result' => 'success',
    'redirect' => add_query_arg('order', $order->id,
      add_query_arg('key', $order->order_key, $checkout_edited_url))
  ); 
}
}
}
/**
 * Déclarer MTN Momo comme moyen de paiement
 **/
function woomomo_add_gateway_class( $methods ) {
  $methods[] = 'WC_Gateway_Momo';
  return $methods;
}
if(!add_filter( 'woocommerce_payment_gateways', 'woomomo_add_gateway_class' )){
  die;
}

//demarrer le paiement
function woomomo_request_payment(){
  if(!isset($_SESSION)){
   session_start();
 }
 global $wpdb; 
 
 $total = $_SESSION['total'];
 $url = $_SESSION['credentials_endpoint_momo'];
 $YOUR_APP_CONSUMER_KEY =  $_SESSION['ck_momo'];
 $YOUR_APP_CONSUMER_SECRET = $_SESSION['cs_momo'];
 $credentials = base64_encode($YOUR_APP_CONSUMER_KEY . ':' . $YOUR_APP_CONSUMER_SECRET);
	//Request for access token
 
 $token_response = wp_remote_post( $url, array('headers' => 
   array('Content-Type' => 'application/json',
     'Authorization' => 'Basic ' . $credentials,
     'Ocp-Apim-Subscription-Key' => $_SESSION['passkey_momo'])));	
 
 $token_array = json_decode('{"token_results":[' . $token_response['body'] . ']}');
 
 if (array_key_exists("access_token", $token_array->token_results[0])) {
  $access_token = $token_array->token_results[0]->access_token;
  $_SESSION['access_token'] = $access_token;
} 
else {		
  echo json_encode(array("rescode" => "1", "resmsg" => "Error, unable to send payment request"));
  exit();
}		

    ///If the access token is available, start lipa na momo process
if (array_key_exists("access_token", $token_array->token_results[0])) {
        ////Starting momo payment process
  
		///Generate UUID using WP function///
  $_SESSION["myUUID"] = wp_generate_uuid4();
  
		//Fill in the request parameters with valid values
  $curl_post_data = array(            
    'amount' => $total,
    'currency' => $_SESSION['currency'],
    'externalId' => $_SESSION["myUUID"],
    'payer' => array('partyIdType' => 'MSISDN','partyId' => $_SESSION['tel'] ), 
    'payerMessage' => 'Online Payment for order number '.$_SESSION['orderID'],
    'payeeNote' => 'Online Payment for order number '.$_SESSION['orderID']
  );
  
  $data_string = json_encode($curl_post_data);		
  $response = wp_remote_post($_SESSION['payments_endpoint_momo'],
    array('headers' => array(
      'Content-Type' => 'application/json',
      'Authorization' => 'Bearer ' . $access_token,
      'X-Reference-Id' => $_SESSION["myUUID"],
      'X-Target-Environment' => $_SESSION['environment_type'],
      'Ocp-Apim-Subscription-Key' => $_SESSION['passkey_momo'] 
    ),
    'body'    => $data_string));		
  
  $response_array = $response['response'];
  
  if($response_array['code'] == 202){
   
   woomomo_insert_transaction($_SESSION["myUUID"]);			
   
   echo json_encode(array("rescode" => "0", "resmsg" => "Request accepted for processing, please authorize the transaction"));	
   
 }
 else{
   echo json_encode(array("rescode" => $response_array['code'], "resmsg" => "Payment request failed, please try again"));	
   
 }
 exit();
 
}

}
//Payments end







function wellcome_samm()
{
  echo <<< 'EOD'

  <h2> </h2>

  EOD;

  include('element/wellcome_samm.php');
}

function table_affilies()
{
  echo <<< 'EOD'

  <h2> Liste des affiliés</h2>

  EOD;

  include('element/tableau_affilies.php');
}

function table_vendeurs()
{
  echo <<< 'EOD'

  <h2> Liste des vendeurs</h2>

  EOD;

  include('element/tableau_vendeurs.php');
}

function table_retraits()
{
  echo <<< 'EOD'

  <h2> Liste des retraits</h2>

  EOD;

  include('element/tableau_retraits.php');
}



function table_parametre()
{
  echo <<< 'EOD'

  <h2> Configuration / SAMM</h2>

  EOD;

  if( isset($_POST['publ'] ) ){

  } else { include('element/form_parametre_admin.php'); }

}


function table_rapports()
{
  echo <<< 'EOD'

  <h2> Statistiques détaillés</h2>

  EOD;

  echo "Indisponible! Veuillez passer à la version Pro.";
}