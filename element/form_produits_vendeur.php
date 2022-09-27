<?php

$id_user=$_SESSION['af_user_id'];
$type_user=$_SESSION['af_user_type'];
$sql2 = new affiliation();
$req2=$sql2->info_account($id_user);
$infos_user = $req2->fetch();

$gain_affiliation=$infos_user['gain_affiliation'];
$nom=$infos_user['nom'];
$email=$infos_user['email'];
$telephone=$infos_user['telephone'];

if (isset($_POST['add_produit'])) {


	$nom_produit = htmlspecialchars($_POST['nom_produit']);
	$prix_produit = htmlspecialchars($_POST['prix_produit']);
	$description_produit = htmlspecialchars($_POST['description_produit']);
    $date_ajout=date("d-m-Y");
    $heure_ajout=date("h:i");
    $temps=time();

    $caracteres_remplacesx = array("'",",","(",")","`","\"","*","^","š",",","§","~","°", "<", ">", "&", "à", "é", "è", "û", "ù", "î", "ï", "â");
    $caracteres_rempla = array(" ");

    $slug = str_replace($caracteres_remplacesx, "",$nom_produit);
    $slug = str_replace($caracteres_rempla, "_",$slug); 
    $slug= substr($slug,0,50);
    $slug= $slug.$id_user.$temps;






    // WordPress environmet
    require( dirname(__FILE__) . '/../../../../wp-load.php' );

    // it allows us to use wp_handle_upload() function
    require_once( ABSPATH . 'wp-admin/includes/file.php' );

    // you can add some kind of validation here
    if( empty( $_FILES[ 'profile_picture' ] ) ) {
        wp_die( 'No files selected.' );
    }

    $upload = wp_handle_upload( 
        $_FILES[ 'profile_picture' ], 
        array( 'test_form' => false ) 
    );

    if( ! empty( $upload[ 'error' ] ) ) {
        wp_die( $upload[ 'error' ] );
    }

    // it is time to add our uploaded image into WordPress media library
    $attachment_id = wp_insert_attachment(
        array(
            'guid'           => $upload[ 'url' ],
            'post_mime_type' => $upload[ 'type' ],
            'post_title'     => basename( $upload[ 'file' ] ),
            'post_content'   => '',
            'post_status'    => 'inherit',
        ),
        $upload[ 'file' ]
    );

    if( is_wp_error( $attachment_id ) || ! $attachment_id ) {
        wp_die( 'Upload error.' );
    }

    // update medatata, regenerate image sizes
    require_once( ABSPATH . 'wp-admin/includes/image.php' );

    wp_update_attachment_metadata(
        $attachment_id,
        wp_generate_attachment_metadata( $attachment_id, $upload[ 'file' ] )
    );



    // Enregistrement du produit
    $product = new WC_Product_Simple();

    $product->set_name( $nom_produit ); // product title

    $product->set_status( 'draft' ); 
    $product->set_catalog_visibility( 'visible' );

    $product->set_slug( $slug );

    $product->set_regular_price( $prix_produit ); // in current shop currency

    //$product->set_short_description( $description_produit );
    // you can also add a full product description
    $product->set_description( $description_produit );

    $product->set_sold_individually( true );
    $product->set_image_id( $attachment_id );

    // let's suppose that our 'Accessories' category has ID = 19 
    //$product->set_category_ids( array( 19 ) );
    // you can also use $product->set_tag_ids() for tags, brands etc

    $product->save();

    $sql1 = new affiliation();
    $req1 = $sql1->find_id_slug($slug);
    $req1 = $req1->fetch();
    $id_produit= $req1['ID'];


    //echo($id_produit);


    $sql = new affiliation();
    $req = $sql->add_produits($id_user,$id_produit,$temps);
    $enregistre = $req->fetch();




    ?>
    <script type="text/javascript">
        alert('Produit publié avec succès!');
    </script>
    <?php
}
?>


<?php
$sql1 = new affiliation();
$req1 = $sql1->info_retrait($_SESSION['af_user_id']);
$info = $req1->fetch();
$resultat = $req1->rowCount();

$id_user=$info['id_user'];
$status=$info['status'];

?>

<div class="card-body">
	<h4>Produits</h4>
	<div class="row">
		<div class="col-md-6">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-12">
                        <p style="color:blue">Ajouter un nouveau produit !</p>
                        <label for="">Nom du produit</label>
                        <input type="text" class="form-control" required name="nom_produit" id="">
                        <label for="">Prix du produit(CFA) </label>
                        <input type="number" class="form-control" required name="prix_produit" id="">            
                        <!--<label for="">Catégorie</label>
                        <select name="categorie"  class="form-control" required >
                            <option value="1" >Electronique</option>
                        </select>-->
                        <label for="">Image</label>
                        <input type="file" name="profile_picture" />
                        <!--<input type="file" class="form-control" required name="telephone_user" id="">  -->          
                        <label for="">Description du produit</label>
                        <textarea class="form-control" placeholder="Veuillez décrire le produit." name="description_produit" required></textarea>
                    </div>
                </div><br>
                <div class="form-group">
                    <div class="col-md-6" style="padding-top: 25px;" >
                        <input type="submit" class="form-control btn btn-primary" value="Enregistrer" name="add_produit">
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<?php 
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
{
    $url = "https";
}
else
{
    $url = "http"; 
}  
$url .= "://"; 
$url .= $_SERVER['HTTP_HOST']; 
$url .= $_SERVER['REQUEST_URI']; 
?> 


<h1>Mes produits</h1>
<p> </p>

<table class="">
  <tr>
    <th>Image</th>
    <th>Nom</th>
    <th>Montant</th>
    <th>Statut</th>
    <th>Gérer</th>
    
    
</tr>

<?php  
if(isset($_GET['q'])) {$q=addslashes($_GET['q']); } else { $q=""; }

                                //pagination
if(isset($_GET['pg'] ) ) {$pg=$_GET['pg'];} else {$pg=1;}
$nbr_result_par_pg=1;
$lim_sup=$pg*$nbr_result_par_pg;
$lim_inf=$lim_sup-$nbr_result_par_pg;
                                //pagination--

$sql = new affiliation();
$req=$sql->find_my_all_prod($_SESSION['af_user_id']);

while($all_prod = $req->fetch()){
    $product_info = wc_get_product( $all_prod['id_produit'] );
    $sql1 = new affiliation(); 
    $req1=$sql1->info_produit($all_prod['id_produit']); 
    $info = $req1->fetch();


    ?>

    <tr>
        <td> <img src="<?php echo wp_get_attachment_url( $product_info->get_image_id() ); ?>" width="80px" /></td>
        <td><a href="../product/<?php echo $info['post_name'];?>" target="_blank" ><?php echo $info['post_title'];?> </a></td>
        <td><?php echo $product_info->get_regular_price(); ?> CFA</td>
        <td><?php $vstatut = $product_info->get_status(); if($vstatut =='publish') { echo'Publié'; } else { echo'En attente'; }  ?></td>
        <td><a href=""> <button>Modifier</button> </a> </br><a href=""> <button>Suprimer</button> </a> </td>
        
    </tr>
    <?php
}
?>  
</table> 

<div class="custom-pagination">
    <ul class="pagination">
        
        <?php 
        $sql = new pagination_affiliation();
        $pager=$sql->compter_historique_retrait($_SESSION['af_user_id']);
        $count_result_pagination = $pager->rowCount();


        $nbr_pg_total=$count_result_pagination/$nbr_result_par_pg;

        $nbr_pg_total = explode(".", $nbr_pg_total);

        if( isset($nbr_pg_total[1]) && ($nbr_pg_total[1]>0)){$nbr_pg_total = $nbr_pg_total[0]+1; } else { $nbr_pg_total = $nbr_pg_total[0]; }
        


        if ($pg>5) {
            $num_pg_gauche=$pg-5;
            $num_pg_precedent=$num_pg_gauche-1;

                                            if($pg>6) { ?> <li class="page-item"><a class="page-link" href="<?php echo $url;?>&pg=<?php echo$num_pg_precedent; ?>&q=<?php echo$q;?>">Previous</a></li> <?php } else { } //affiche bouton précédent quand on est sur un page supérieur à 5

                                            while ( ($num_pg_gauche>0) && ($num_pg_gauche<$pg) ) { ?> <li class="page-item"><a class="page-link" href="<?php echo $url;?>&pg=<?php echo$num_pg_gauche;?>&q=<?php echo$q;?>"><?php echo$num_pg_gauche; ?></a></li> <?php $num_pg_gauche++; } //affiche les pages entre precedent et la page actuelle

                                        } else {
                                            $num_pg_gauche=1;

                                            while ( ($num_pg_gauche>0) && ($num_pg_gauche<$pg) ) { ?> <li class="page-item"><a class="page-link" href="<?php echo $url;?>&pg=<?php echo$num_pg_gauche;?>&q=<?php echo$q;?>"><?php echo$num_pg_gauche; ?></a></li> <?php $num_pg_gauche++; } //affiche les pages avant la page actuelle quand on est à une page inferieur ou égale à 5

                                        } 

                                        ?>

                                        <li class="page-item"><span><?php echo$pg; ?></span></li> <!--page actuelle -->

                                        <?php  
                                        if($nbr_pg_total>11) {
                                            $num_pg_suivant=$pg+5;
                                            $num_pg_droite=$pg+1;
                                            while ( ($num_pg_droite<$num_pg_suivant) && ($num_pg_droite<=$nbr_pg_total) ) { ?> <li><a href="<?php echo $url;?>&pg=<?php echo$num_pg_droite; ?>&q=<?php echo$q;?>"><?php echo$num_pg_droite; ?></a></li> <?php $num_pg_droite++; } //Afficher les pages suivantes quand il y a plus de 11 pages au total

                                        }else{
                                            $num_pg_droite=$pg+1;
                                            while ($num_pg_droite<=$nbr_pg_total){ ?> <li class="page-item"><a class="page-link" href="<?php echo $url;?>&pg=<?php echo$num_pg_droite; ?>&q=<?php echo$q;?>"><?php echo$num_pg_droite; ?></a></li> <?php $num_pg_droite++; }//Afficher les pages suivantes quand il y a moins de 11 pages au total
                                        }

                                        $num_avant_derniere_pg=$num_pg_droite-1;

                                        if($nbr_pg_total>$num_avant_derniere_pg) { //Metre le bouton suivant au besoin
                                            ?>
                                            <li class="page-item"><a >...</a></li>
                                            <li class="page-item"><a class="page-link" href="<?php echo $url;?>&pg=<?php echo$num_pg_droite; ?>&q=<?php echo$q; ?>">Next</a></li>
                                            <?php		                	
                                        } else { }

                                        ?>

                                    </ul>
                                </div>

                                


