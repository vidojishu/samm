<?php

function create_page($title_of_the_page,$content,$parent_id = NULL ) 
{
    $objPage = get_page_by_title($title_of_the_page, 'OBJECT', 'page');
    if( ! empty( $objPage ) )
    {
        //echo "Page already exists:" . $title_of_the_page . "<br/>";
        return $objPage->ID;
    }
    
    $page_id = wp_insert_post(
            array(
            'comment_status' => 'close',
            'ping_status'    => 'close',
            'post_author'    => 1,
            'post_title'     => ucwords($title_of_the_page),
            'post_name'      => strtolower(str_replace(' ', '-', trim($title_of_the_page))),
            'post_status'    => 'publish',
            'post_content'   => $content,
            'post_type'      => 'page',
            'post_parent'    =>  $parent_id //'id_of_the_parent_page_if_it_available'
            )
        );
    //echo "Created page_id=". $page_id." for page '".$title_of_the_page. "'<br/>";
    return $page_id;
}


// Fonction^pour couper les nombre à virgule
function Reduire_Decimale($nombre,$chiffre_apres_LaVirgule)
{

    $tot= substr_count($nombre,'.');


    if($tot >0 ){


        if($nombre == 0)
        {
            $nouveau_nombre = 0;
        }
        elseif($nombre == is_int($nombre))
        {
            $nouveau_nombre = $nombre;
        }
        else 
        {
            $decimale = explode('.',$nombre);
            $reduction = substr($decimale[1], 0, $chiffre_apres_LaVirgule);
            
            if($chiffre_apres_LaVirgule == 0)
            {
                $nouveau_nombre = $decimale[0];
            }
            else
            {
                $nouveau_nombre = $decimale[0].','.$reduction;
            }
        }
        

    } else { $nouveau_nombre=$nombre; }


    return $nouveau_nombre;


}


function create_affiliate_prod_link_table(){
    global $wpdb;

    $sql = "CREATE TABLE `samm_affiliate_prod_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` text NOT NULL,
  `id_produit` text NOT NULL,
  `lien` text NOT NULL,
  `nbr_click` int(11) NOT NULL,
  `temps` text NOT NULL,
  `nbr_vente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
        
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
 
}



function create_demande_compte_marchant_table(){
    global $wpdb;

    $sql = "CREATE TABLE `samm_demande_compte_marchant` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` text NOT NULL,
  `nom` text NOT NULL,
  `nom_boutique` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `adresse` text NOT NULL,
  `description` text NOT NULL,
  `type_abonnement` text NOT NULL,
  `valide` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
        
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
 
}



function create_gain_affiliate_salle_table(){
    global $wpdb;

    $sql = "CREATE TABLE `samm_gain_affiliate_salle` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_cmd` text NOT NULL,
  `refby` text NOT NULL,
  `montant` text NOT NULL,
  `gain_affiliate` text NOT NULL,
  `valide` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
        
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
 
}


function create_produits_table(){
    global $wpdb;

    $sql = "CREATE TABLE `samm_produits` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` text NOT NULL,
  `id_produit` text NOT NULL,
  `nom` text NOT NULL,
  `prix` text NOT NULL,
  `description` text NOT NULL,
  `date_ajout` text NOT NULL,
  `heure_ajout` text NOT NULL,
  `temps` text NOT NULL,
  `valide` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
 
}


function create_retrait_table(){
    global $wpdb;

    $sql = "CREATE TABLE `samm_retrait` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `montant_retrait` text NOT NULL,
  `telephone` text NOT NULL,
  `details_retrait` text NOT NULL,
  `date_demande` text NOT NULL,
  `heure_demande` text NOT NULL,
  `temps` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `type_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
 
}




function create_samm_utilisateurs_table(){
    global $wpdb;

    $sql = "CREATE TABLE `samm_utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nom` text NOT NULL,
  `email` text NOT NULL,
  `telephone` text NOT NULL,
  `pass` text NOT NULL,
  `type` text NOT NULL,
  `nom_boutique` text NOT NULL,
  `email_boutique` text NOT NULL,
  `telephone_boutique` text NOT NULL,
  `adresse_boutique` text NOT NULL,
  `description_boutique` text NOT NULL,
  `statut_boutique` int(11) NOT NULL,
  `adresse` text NOT NULL,
  `date_inscription` text NOT NULL,
  `temps` int(11) NOT NULL,
  `gain_tempo` text NOT NULL,
  `gain_affiliation` text NOT NULL,
  `total_vente` int(11) NOT NULL,
  `valide` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
 
}


function create_utilisateurs_tempo_table(){
    global $wpdb;

    $sql = "CREATE TABLE `samm_utilisateurs_tempo` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nom` text NOT NULL,
  `email` text NOT NULL,
  `telephone` text NOT NULL,
  `pass` text NOT NULL,
  `adresse` text NOT NULL,
  `date_inscription` text NOT NULL,
  `temps` int(11) NOT NULL,
  `gain_tempo` text NOT NULL,
  `gain_affiliation` text NOT NULL,
  `valide` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
 
}


function create_samm_admin_details_table(){
    global $wpdb;

    $sql = "CREATE TABLE `samm_samm_admin_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `commission_affilie` int(11) NOT NULL,
  `commission_vendeur` int(11) NOT NULL,
  `licence_key` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
        
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
 
}


function create_samm_cmd_details_table(){
    global $wpdb;

    $sql = "CREATE TABLE `samm_cmd_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` text NOT NULL,
  `wc_prod_id` text NOT NULL,
  `wc_order_id` text NOT NULL,
  `samm_prod_ref` text NOT NULL,
  `quantite` text NOT NULL,
  `commission` text NOT NULL,
  `nom_produit` text NOT NULL,
  `client_info` text NOT NULL,
  `date` text NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
        
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
 
}



function add_samm_admin_details_table(){
    global $wpdb;

    $sql = "INSERT INTO `samm_admin_details` 
    (`id`, 
    `commission_affilie`, 
    `commission_vendeur`, 
    `licence_key`
    ) VALUES (1, 10, 85, '');";
        
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
 
}



