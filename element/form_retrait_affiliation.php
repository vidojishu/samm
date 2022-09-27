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

if (isset($_POST['demande_retrait'])) {


	$montant_retrait = htmlspecialchars($_POST['montant_retrait']);
	$telephone_user = htmlspecialchars($_POST['telephone_user']);
	$details_retrait = htmlspecialchars($_POST['details_retrait']);
    $date_demande=date("d-m-Y");
    $heure_demande=date("h:i");
    $temps=time();

    if ($montant_retrait <= $gain_affiliation) {
        # code...
        $sql = new affiliation();
        $req = $sql->demande_retrait($type_user,$id_user,$montant_retrait,$telephone_user,$details_retrait,$date_demande,$heure_demande,$temps);
        $enregistre = $req->fetch();


        ?>
        <script type="text/javascript">
            alert('Demande effectuée avec succès! Vous recevrez votre paiement dans un bref délais !');
        </script>
        <?php
    }
    else {
        ?>
        <script type="text/javascript">
            alert('Demande échouée ! Vous n\'avez pas assez de gains disponibles !');
        </script>
        <?php
    }
}
?>


<?php
$sql1 = new affiliation();
$req1 = $sql1->info_retrait($_SESSION['af_user_id']);
$info = $req1->fetch();
$resultat = $req1->rowCount();

$id_user=$info['id_user'];
$status=$info['status'];

if ($resultat < 1) {
    ?>

    <div class="card-body">
       <h3>Demande de retrait</h3>
       <div class="row">
          <div class="col-md-6">
            <form action="" method="post">
                <div class="form-group">
                    <div class="col-md-12">
                        <p style="color:blue">Effectuer votre demande de retrait maintenant!</p>
                        <label for="">Montant du retrait</label>
                        <input type="number" class="form-control" required name="montant_retrait" id="">
                        <label for="">Numéro de téléphone de reception</label>
                        <input type="number" class="form-control" required name="telephone_user" id="" placeholder="229XXXXXXXX" >            
                        
                        <input type="hidden" name="details_retrait" value="momo" required/>
                        <p>Veuillez saisor un numéro de téléphone MTM Momo valide sous le format 229XXXXXXXX (prefixe inclu).</p>
                    </div>
                </div><br>
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="submit" class="form-control btn btn-primary" value="Demander" name="demande_retrait">
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<?php
}  
else {
    ?>
    <!-- <script>alert('Vous avez déjà une demande de retrait en attente!');</script>       --> 
    <h2>Vous avez déjà une demande de retrait en attente!</h2>
    <?php
    
}   
?>

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


<h3>Historique</h3>
<p> </p>

<table class="">
  <tr>
    <th>Date</th>
    <th>Montant</th>
    <th>Statut</th>
    
    
</tr>

<?php  
if(isset($_GET['q'])) {$q=addslashes($_GET['q']); } else { $q=""; }

                                //pagination
if(isset($_GET['pg'] ) ) {$pg=$_GET['pg'];} else {$pg=1;}
$nbr_result_par_pg=12;
$lim_sup=$pg*$nbr_result_par_pg;
$lim_inf=$lim_sup-$nbr_result_par_pg;
                                //pagination--

$sql = new affiliation();
$req=$sql->historique_retrait($_SESSION['af_user_id'],$lim_inf,$nbr_result_par_pg);

while($retrait = $req->fetch()){
    ?>

    <tr>
        <td><?php echo $retrait['date_demande'].' à '.$retrait['heure_demande'];?></td>
        <td><?php echo $retrait['montant_retrait'];?>F CFA</td>
        <td>Validé</td>
        
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

                                


