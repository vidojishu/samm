<?php
//require ABSPATH . 'wp-content/plugins/samm/model/model.php';	
//require('../model/model.php');																	                                             
if( isset($_GET['user'] ) ){
$id_user=$_GET['user'];
$id_prod=$_GET['prod'];

$sql = new affiliation();
$req=$sql->create_prod_link($id_user,$id_prod);
} else { }
/////////////////////////////////////////////////////////
if( isset($_GET['delete_user_affiliation'] ) ){
    $id_delete_user_affiliation=$_GET['delete_user_affiliation'];  
    $sql = new admin_affiliation();
    $req=$sql->suprimer_afficher_user_affiliation($id_delete_user_affiliation);

    ?>
        <script type="text/javascript">
            alert('Utilisateur supprimé avec succès !');
        </script>
    <?php
    } else { }

    if( isset($_GET['active_user_affiliation'] ) ){
        $id_active_user_affiliation=$_GET['active_user_affiliation'];  
        $sql = new admin_affiliation();
        $req=$sql->activer_compte_user($id_active_user_affiliation);
    
        ?>
            <script type="text/javascript">
                alert('Compte activé avec succès !');
            </script>
        <?php
        } else { }

        if( isset($_GET['desactive_user_affiliation'] ) ){
            $id_desactive_user_affiliation=$_GET['desactive_user_affiliation'];  
            $sql = new admin_affiliation();
            $req=$sql->desactiver_compte_user($id_desactive_user_affiliation);
        
            ?>
                <script type="text/javascript">
                    alert('Compte désactivé avec succès !');
                </script>
            <?php
            } else { }


    if( isset($_GET['active_vendeur_affiliation'] ) ){
        $id_active_user_affiliation=$_GET['active_vendeur_affiliation'];  
        $sql = new admin_affiliation();
        $req=$sql->activer_compte_vendeur($id_active_user_affiliation);
    
        ?>
            <script type="text/javascript">
                alert('Boutique activé avec succès !');
            </script>
        <?php
        } else { }

        if( isset($_GET['desactive_vendeur_affiliation'] ) ){
            $id_desactive_user_affiliation=$_GET['desactive_vendeur_affiliation'];  
            $sql = new admin_affiliation();
            $req=$sql->desactiver_compte_vendeur($id_desactive_user_affiliation);
        
            ?>
                <script type="text/javascript">
                    alert('Boutique désactivé avec succès !');
                </script>
            <?php
            } else { }


////////////////////////////////////////////////////
if( isset($_GET['retrait_affiliation'] ) ){
    $id_retrait_affiliation=$_GET['retrait_affiliation'];

    $sql = new admin_affiliation();
    $req=$sql->rechercher_demande_retrait_affiliation($id_retrait_affiliation);
    $infos_retrait = $req->fetch();

    $id_user = $infos_retrait['id_user'];
    $montant_retrait = $infos_retrait['montant_retrait'];

    $sql1 = new affiliation();
    $req1=$sql1->info_account($id_user);
    $infos_user = $req1->fetch();
    $nom=$infos_user['nom'];
    $email=$infos_user['email'];    

    $gain_affiliation = $infos_user['gain_affiliation'];

    $gain_restant = $gain_affiliation - $montant_retrait;

    $sql = new admin_affiliation();
    $req=$sql->update_status_retrait($id_retrait_affiliation);

    $sql = new admin_affiliation();
    $req=$sql->update_gain_affiliation($gain_restant,$id_user);
    $date_footer=date("Y");
    // message
    $body1 =  "
    <html>
        <head>
        <title></title>

           <style>
             .p9 {
               text-align: center;
               background-color: #C4C9C7;
             }
             .button {
               border: none;
               color: white;
               padding: 15px 32px;
               text-align: center;
               text-decoration: none;
               display: inline-block;
               font-size: 16px;
               margin: 4px 2px;
               cursor: pointer;
             }
            .button1 {background-color: #4CAF50;} /* Green */
             .button2 {background-color: #008CBA;} /* Blue */
           </style>
        </head>
        <body>
        <p></p>
        <p> Salut  !</p></br>
        <p>Vous venez de reçevoir $montant_retrait, après validation de votre demande de retrait de votre gain d'affilition.</p></br>
        <p>
                                                                    
        </p>
        
        <p> Merci d'être sur ".$_SERVER['HTTP_HOST']."!</p> 
        <p class='p9'>".$date_footer." &copy; Copyright, ".$_SERVER['HTTP_HOST'].".   </p>
        <p></p>
        </body>
    </html>
    "; $body1=utf8_decode($body1);

    // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
    $headers1  = 'MIME-Version: 1.0' . "\r\n";
    $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers1 .= 'From: '.$_SERVER['HTTP_HOST'].' <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";

    @mail($email, 'Nouveau paiement', $body1, $headers1, '-frebonds@havilamarket.com');
    
    ?>
    <script type="text/javascript">
        alert('Cette action confirme que la demande de retrait demandé par l\'utilisateur a été effectuée avec succès !');
    </script>
<?php
    

    } else { }



?>  

<script type="text/javascript">window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";</script> 