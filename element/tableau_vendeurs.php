<?php 

if(isset($_GET['active_vendeur_affiliation'] ) ) { require_once ABSPATH . 'wp-content/plugins/samm/model/model.php';  require ABSPATH . 'wp-content/plugins/samm/traitement/01.php'; }
if(isset($_GET['desactive_vendeur_affiliation'] ) ) {  require_once ABSPATH . 'wp-content/plugins/samm/model/model.php';  require ABSPATH . 'wp-content/plugins/samm/traitement/01.php'; }

?>


<table class="wp-list-table widefat fixed striped table-view-list">
  <tr>
    <th>Date</th>
    <th>Utilisateurs</th>
    <th>Comission</th>
    <th>Boutique</th>
    <th>Status</th>
    <th>Opération</th>

    
</tr>
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
<?php	
require('../wp-content/plugins/samm/model/model.php');			
if(isset($_GET['q'])) {$q=addslashes($_GET['q']); } else { $q=""; }

//pagination
if(isset($_GET['pg'] ) ) {$pg=$_GET['pg'];} else {$pg=1;}
$nbr_result_par_pg=12;
$lim_sup=$pg*$nbr_result_par_pg;
$lim_inf=$lim_sup-$nbr_result_par_pg;
//pagination--

$sql = new admin_affiliation();
$req=$sql->afficher_user_affiliation2($lim_inf, $nbr_result_par_pg);

while($marchant = $req->fetch()){
    ?>

    <tr>
        <td><?php echo $marchant['date_inscription'];?></td>
        <td><b>Nom: </b><?php echo $marchant['nom'];?> </br><b>Email: </b><?php echo $marchant['email'];?> </br><b>Téléphone: </b> <?php echo $marchant['telephone'];?> </br><b>Adresse: </b><?php echo $marchant['adresse'];?></td>
        
        <td> <b> En attente: </b> <?php echo $marchant['gain_tempo'];?> CFA</br><b>Disponible: </b> <?php echo $marchant['gain_affiliation'];?> CFA</td>
        <td><b>Nom Commercial:</b> <?php echo $marchant['nom_boutique'];?></br><b>Contact:</b> <?php echo $marchant['email_boutique']."/ </br> <b>Téléphone:</b> ".$marchant['telephone_boutique'] ;?></br> <b>Adresse:</b> <?php echo $marchant['adresse_boutique'];?></br><b>Description:</b> <?php echo $marchant['description_boutique'] ;?> </td> 
        <td>
            <?php 
            if ($marchant['statut_boutique'] == 2) {
                ?>
                <span style="color:green;" >Validé</span>
                <?php
            }
            else {
                ?>
                <span style="color:orange;" >En attente</span>
                <?php
            }?>
        </td>
        <td>
            <?php if($marchant['statut_boutique'] != 2 ) { ?><button> <a href="?page=vendeurs&active_vendeur_affiliation=<?php echo$marchant['id']; ?>"  style="color: black;"  >Activer</a></button> <?php } else { ?><button> <a href="?page=vendeurs&desactive_vendeur_affiliation=<?php echo$marchant['id']; ?>"  style="color: black;"  >Désactiver</a></button> <?php } ?>
            <button> <a href="#"  onclick="alert('Indisponible! Veuillez passer à la version Pro.');" style="color: red;"  >delete</a></button>
        </td>
    </tr>
    <?php
}
?>  
</table>

<div class="custom-pagination">
    <ul class="pagination">
        
        <?php 
        $sql = new pagination_affiliation();
        $pager=$sql->compter_user_affiliation2();
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

                                <?php																		                                             

                                ?>  

