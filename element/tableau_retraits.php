<?php ?>


 <table class="wp-list-table widefat fixed striped table-view-list">
  <tr>
    <th>Date</th>
    <th>Nom</th>
    <th>Contact</th>
    <th>Montant</th>
    <th>Compte</th>
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
require('../wp-content/plugins/Samm/model/model.php');			
if(isset($_GET['q'])) {$q=addslashes($_GET['q']); } else { $q=""; }

//pagination
if(isset($_GET['pg'] ) ) {$pg=$_GET['pg'];} else {$pg=1;}
$nbr_result_par_pg=6;
$lim_sup=$pg*$nbr_result_par_pg;
$lim_inf=$lim_sup-$nbr_result_par_pg;
//pagination--

$sql = new admin_affiliation();
$req=$sql->afficher_demande_retrait($lim_inf, $nbr_result_par_pg);

while($retrait = $req->fetch()){
    $sql1 = new admin_affiliation();
    $req1=$sql1->afficher_infos_demande_retrait($retrait['id_user']);
    $infos_retrait = $req1->fetch()
?>

  <tr>
    <td><?php echo $retrait['date_demande'];?></td>
    <td><?php echo $infos_retrait['nom'];?></td>
    <td><?php echo $infos_retrait['email'];?> </br> <?php echo $retrait['telephone'];?></td>
    <td><?php echo $retrait['montant_retrait'];?></td>
    <td>
        <?php 
        if ($infos_retrait['type'] == 1) {
        ?>
        Affilié
        <?php   
        }
        elseif ($infos_retrait['type'] == 2) {
        ?>
        Vendeur
        <?php
        }
        else {
        ?>
        <?php
        }?>
    </td>
    <td>
        <?php 
        if ($retrait['status'] == 0) {
        ?>
        En attente
        <?php
        }
        else {
        ?>
        Payé
        <?php
        }?>
    </td>
    <td><?php if($retrait['status'] == 0 ) { ?><button> <a href="../wp-content/plugins/gestion_affiliation/traitement/01.php?retrait_affiliation=<?php echo$retrait['id']; ?>"  style="color: black;" >Valider comme Payé</a></button> </br> <button> <a href="#"  onclick="alert('Indisponible! Veuillez passer à la version Pro.');"  style="color: black;"  >Payer par Momo</a></button> <?php } else { } ?> </td>
  </tr>
<?php
}
?>  
</table>

<div class="custom-pagination">
                                    <ul class="pagination">
            
                                        <?php 
                                        $sql = new pagination_affiliation();
                                        $pager=$sql->compter_demande_retrait_affiliation();
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

