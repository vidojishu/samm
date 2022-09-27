<?php


/**
 * [reg_affiliation_samm] Affiche formulaire d'inscription affiliation 
*/

add_shortcode( 'reg_affiliation_samm', 'afficher_form_affiliation_samm' );
function afficher_form_affiliation_samm_init(){
   function afficher_form_affiliation_samm() {


      include('element/form_reg_affiliation_samm.php');

  }
}
add_action('init', 'afficher_form_affiliation_samm_init');

/**
 * [dashboard_affiliation_samm] Affiche formulaire connexion affiliation ou le dashboard affiliation 
*/

add_shortcode( 'dashboard_affiliation_samm', 'afficher_dashboard_affiliation_samm' );
function afficher_dashboard_affiliation_samm_init(){
   function afficher_dashboard_affiliation_samm() {

      session_start();
      include('element/inc_ver.php');
      

  }
}
add_action('init', 'afficher_dashboard_affiliation_samm_init');


/**
 * [samm_distribution] Distribution des marchands 
*/

add_shortcode( 'samm_distribution', 'distribution_marchand_samm' );
function distribution_marchand_samm_init(){
   function distribution_marchand_samm() {

    if(isset($_GET['transactionType'] ) ) {
        ?> <button onClick="payer()" style="margin-top: 300px; margin-left: 30%;" >Payer</button> <?php
    }

    require __DIR__ . '/model/model.php'; 

    if( isset($_GET['key'] ) ) {

        
                //Chercher d'abord les info admin
        $sql111 = new affiliation(); 
        $req111=$sql111->get_samm_admin_details(); 
        $admin_details = $req111->fetch();
        $commission_affilie= $admin_details['commission_affilie'];
        $commission_vendeur= $admin_details['commission_vendeur'];

        $key=$_GET['key'];

        $sql2 = new affiliation(); 
        $req2=$sql2->info_cmd($key); 
        $cmd = $req2->fetch();

        $sql1 = new affiliation(); 
        $req1=$sql1->details_cmd($cmd['ID'] ); 
        $details_cmd = $req1->fetch();
        $montant= $details_cmd['meta_value'];
        $post_id= $details_cmd['post_id'];
        
            //Trouver l'id du produit, l'id du machand et l'enregistrer dans samm
        $order = new WC_Order($post_id);
        $items = $order->get_items();
        
        foreach ( $items as $item ) {
            
            $product_id = $item['product_id'];
            $product_prix = $item['subtotal'];
            $quantite = $item['quantity'];
            $nom_produit = $item['name'];


            $sql11 = new affiliation(); 
            $req11=$sql11->find_marchand_by_prod_id($product_id); 
            $details_prod = $req11->fetch();
            $id_user= $details_prod['id_user'];
            $samm_prod_ref= $details_prod['id'];

                if(isset($details_prod)){ //Si c'est le produit d'un marchand
                
                $commission=($commission_vendeur*$product_prix)/100;


                    // Get the user ID from an Order ID
                $user_id = get_post_meta( $post_id, '_customer_user', true );

                    // Get an instance of the WC_Customer Object from the user ID
                $customer = new WC_Customer( $user_id );

                    $username     = $customer->get_username(); // Get username
                    $user_email   = $customer->get_email(); // Get account email
                    $first_name   = $customer->get_first_name();
                    $last_name    = $customer->get_last_name();
                    $display_name = $customer->get_display_name();


                    // Customer shipping information details (from account)
                    $shipping_first_name = $customer->get_shipping_first_name();
                    $shipping_last_name  = $customer->get_shipping_last_name();
                    $shipping_company    = $customer->get_shipping_company();
                    $shipping_address_1  = $customer->get_shipping_address_1();
                    $shipping_address_2  = $customer->get_shipping_address_2();
                    $shipping_city       = $customer->get_shipping_city();
                    $shipping_state      = $customer->get_shipping_state();
                    $shipping_postcode   = $customer->get_shipping_postcode();
                    $shipping_country    = $customer->get_shipping_country();

                    $adresse="<b>Nom:</b> ".$shipping_first_name." ".$shipping_last_name."(".$username .")"."</br> <b>Adresse 1:</b> ".$shipping_address_1."</br> <b>Adresse 2:</b> ".$shipping_address_2."</br> <b>Ville:</b> ".$shipping_city."</br> <b>Pays:</b> ".$shipping_country."</br> <b>Email:</b> ".$user_email;
                    $adresse=addslashes($adresse);

                    //var_dump($adresse);

                    $sql1 = new affiliation(); 
                    $req1=$sql1->reg_cmd_par_marchand($id_user,$product_id,$post_id,$samm_prod_ref,$quantite,$commission,$nom_produit,$adresse); 
                    
                //Actualiser le nbr de vente pour chaque produit
                    $new_nbr_vente = $details_prod['nbr_vente'] + $quantite;

                    $sql1o = new affiliation(); 
                    $req1o=$sql1o->update_nbr_vente_par_produit($new_nbr_vente,$product_id); 

                }                
            }

            //enregistrer commission de l'affilié qui a partager le lien
            if(isset($_COOKIE['refby'])){

                $refby=$_COOKIE['refby'];

                $sql3 = new affiliation(); 
                $req3=$sql3->add_cmd_aff($refby,$cmd['ID'],$montant,$commission_affilie); 
                $emailto = $req3;

                    // message
                $body = "
                <html>
                <head>
                <title></title>
                </head>
                <body>
                <p> Bonjour cher partenaire </p>
                
                <p>
                Vous avez une nouvelle commission. 
                
                </p>

                
                <p> Merci d'être sur ".$_SERVER['HTTP_HOST']."!</p>
                <p></p>
                </body>
                </html>
                ";
                // Pour envoyer un mail HTML, l'en-t?te Content-type doit ?tre d?fini
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: '.$_SERVER['HTTP_HOST'].' <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
                
                @mail($emailto,'Nouvelle comission', $body, $headers,'-noreply@'.$_SERVER['HTTP_HOST']);




            }



        }

    }
}
add_action('init', 'distribution_marchand_samm_init');


/**
 * [samm_shot_link] Page de redirection des liens courts pour les affiliés. 
*/

add_shortcode( 'samm_shot_link', 'afficher_samm_shot_link' );
function afficher_samm_shot_link_init(){
   function afficher_samm_shot_link() {

    session_start();
    include('element/redirect_aff_shot_link.php');
    

}
}
add_action('init', 'afficher_samm_shot_link_init');