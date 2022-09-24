<?php
  date_default_timezone_set('Africa/Porto-Novo');
  require('wp-content/plugins/samm/model/model.php');




 if(isset($_GET['ret'])) { ?> <script type="text/javascript">window.location.href = "<?php echo 'dashboard-affiliate/'; ?>";</script> <?php }  else { }


//Se deconnecter
  if(isset($_GET['dec'])) { session_destroy(); ?> <script type="text/javascript">window.location.href = "<?php echo 'dashboard-affiliate/'; ?>";</script> <?php }  else { }


include'wp-content/plugins/samm/css/dashboard_style.html';
?>  





<div class="sidebar">
  <a href="#"  style=" text-align: center !important;" ><img src="../wp-content/plugins/samm/images/avatar.jpg" style="width: 35px;border-radius: 100%; margin-left: 35%;" ><span  > <?php echo$_SESSION['af_user_name']; ?></span></a>
  <a <?php if((isset($_GET['sec'] ) && ($_GET['sec']=='dashboard_aff' )) OR !isset($_GET['sec'] ) ){ echo'class="active"'; } ?> href="?sec=dashboard_aff"><span class="fa-stack fa-lg pull-left"><i class="fa fa-dashboard fa-stack-1x "></i></span> Dashboard</a>
  <a <?php if((isset($_GET['sec'] ) && ($_GET['sec']=='tools_aff' )) ){ echo'class="active"'; } ?> href="?sec=tools_aff"> <span class="fa-stack fa-lg pull-left"><i class="fa fa-bars fa-stack-1x "></i></span>Outils marketing</a>
  <a <?php if((isset($_GET['sec'] ) && ($_GET['sec']=='retrait_aff' )) ){ echo'class="active"'; } ?> href="?sec=retrait_aff"><span class="fa-stack fa-lg pull-left"><i class="fa fa-money fa-stack-1x "></i></span>Retrait</a>
  <a <?php if((isset($_GET['sec'] ) && ($_GET['sec']=='setting_aff' )) ){ echo'class="active"'; } ?> href="?sec=setting_aff"><span class="fa-stack fa-lg pull-left"><i class="fa fa-wrench fa-stack-1x "></i></span>Paramètre</a>
  <a  href="?dec=01" style="color: red !important;" ><span class="fa-stack fa-lg pull-left"><i class="fa fa-logout fa-stack-1x "></i></span>Se déconnecter</a>
</div>

<div class="content"  >

                <?php  
                $id_user= $_SESSION['af_user_id'];

                  $gain_valide=0;
                  $sql20 = new affiliation();
                  $req20=$sql20->verif_achat_aff("AFF".$id_user);
                  
                  while($aff_achat = $req20->fetch()){

                    $sql21 = new affiliation();
                    $req21=$sql21->verif_statut_achat_aff($aff_achat['id_cmd']);
                    $sta = $req21->fetch();
                    $statut=$sta['post_status'];

                      if($statut=="wc-completed" ) {
                        $gain_valide=$gain_valide+$aff_achat['gain_affiliate'];

                        $sql23 = new affiliation();
                        $req23=$sql23->valide_achat_aff($aff_achat['id']);                        
                      }

                  }

                  if($gain_valide>0) {
                    //Actualiser les comptes de l'utilisateur (nouveaux gains tempo et affiliation)
                      $sql22 = new affiliation();
                      $req22=$sql22->info_account($id_user);
                      $ifo2 = $req22->fetch();
                      $new_gain_tempo=$ifo2['gain_tempo']-$gain_valide;
                      $new_gain_affiliation=$ifo2['gain_affiliation']+$gain_valide;

                      $sql23 = new affiliation();
                      $req23=$sql23->update_user_account($new_gain_tempo,$new_gain_affiliation,$id_user); 

                  }
                  







                 if(isset($_GET['sec'] ) && ($_GET['sec']=='dashboard_aff' ) ) { 

                  ?>


                  <?php $id_user=$_SESSION['af_user_id']; 

                  $sql2 = new affiliation();
                  $req2=$sql2->info_account($id_user);
                  $ifo = $req2->fetch();
                  



                   ?>



                   <h3>Dashboard</h3>
                  <div class="row" >
                    <div class="col-md-4" >
                      

                      <div class="box-column " >
                        <div class="box-content">
                          <h4 class="box-column-heading be57373">Total vente</h4>          
                          <div class="box-content-desc">
                            <div class="box-content-icon"><img src="../wp-content/plugins/samm/images/total_commission.png" alt="">
                            </div>
                            <div class="box-content-right">
                                <span class="box-content-value"><?php echo$ifo['total_vente'] ?></span>                  
                                <p>Vente réalisée sur la plateforme.</p>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="col-md-4" >
                      
                      <div class="box-column " id="">
                        <div class="box-content">
                          <h4 class="box-column-heading b4FC3F7">Gain en attente</h4>          
                          <div class="box-content-desc">
                            <div class="box-content-icon"><img src="../wp-content/plugins/samm/images/pending_commission.png" alt="">
                            </div>
                            <div class="box-content-right">
                                <span class="box-content-value"><?php echo$ifo['gain_tempo'] ?> CFA</span>                  
                                <p>Gain en attente de validation</p>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="col-md-4" >
                      
                      <div class="box-column " id="">
                        <div class="box-content">
                          <h4 class="box-column-heading b90A4AE">Gain d'affiliation</h4>          
                          <div class="box-content-desc">
                            <div class="box-content-icon"><img src="../wp-content/plugins/samm/images/approved_commission.png" alt="">
                            </div>
                            <div class="box-content-right">
                                <span class="box-content-value"><?php echo$ifo['gain_affiliation'] ?> CFA</span>                  
                                <p>Commission validée et retirable.</p>
                            </div>
                          </div>
                        </div>
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
                  <div class="row" >
                    <h3>Statistiques</h3>
                  </div>
                  <div class="row" >
                                 <div class="table-responsive">
                                 <table class="table">
                                  <tr>
                                    <th>ID</th>
                                    <th>Lien</th>
                                    <th>Clicks</th>
                                    <th>Vente</th>
                                    <th>Gérer</th>
                                    
                                    
                                  </tr>

                                <?php                                                                                                   
                                $click=0;
                                $vente=0;
                                if(isset($_GET['q'])) {$q=addslashes($_GET['q']); } else { $q=""; }

                                //pagination
                                if(isset($_GET['pg'] ) ) {$pg=$_GET['pg'];} else {$pg=1;}
                                $nbr_result_par_pg=6;
                                $lim_sup=$pg*$nbr_result_par_pg;
                                $lim_inf=$lim_sup-$nbr_result_par_pg;
                                //pagination--

                                //chercher les produits
                                $sql = new affiliation();
                                $req=$sql->list_link($_SESSION['af_user_id'],$lim_inf,$nbr_result_par_pg);
                                
                                while($link_info = $req->fetch()){

                                  ?>
                                        <tr>
                                          <td><?php echo $link_info['id'];?></td>
                                          <td><span id="tocopy<?php echo $link_info['id'];?>"><?php echo"https://".$_SERVER['HTTP_HOST']."/pr/?o=".$link_info['lien'];?> </span></td>
                                          <td><?php echo $link_info['nbr_click'];?> </td>
                                          <td><?php echo $link_info['nbr_vente'];?> </td>
                                          <td><a href="#" class="js-copy" data-target="#tocopy<?php echo $link_info['id'];?>"> <button>Copier</button> </a></td>
                                           
                                        </tr>
                                <?php 
       
                                $click=$click+$link_info['nbr_click'];
                                $vente=$vente+$link_info['nbr_vente'];


                                }
                                ?>  
                                </table>
                                </div> 
                          </div>
                          <div class="row" >
                                <div class="custom-pagination">
                                    <ul class="pagination">
            
                                        <?php 
                                        $sql = new pagination_affiliation();
                                        $pager=$sql->compter_statistique_affiliation_user();
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
                        </div>
                        <div class="row" >
                                <table>
                                        <tr>
                                          <td>Total:</td>
                                          
                                          <td>Clicks: <?php echo $click;?> </td>
                                          <td>Ventes: <?php echo $vente;?> </td>
                                          
                                           
                                        </tr>

                                </table>
                                </div>

                  </div>



                  <?php
                 } 
                        elseif(isset($_GET['sec'] ) && ($_GET['sec']=='tools_aff' ) ) {
                          if(isset($_GET['prod'] ) ) { require ABSPATH . 'wp-content/plugins/samm/traitement/01.php'; }

 ?>



                                  <h3>Produits</h3>
                                  <p> <a href=""></a> </p>

                                 <div class="table-responsive">
                                 <table class="table">
                                  <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Mon lien</th>
                                    <th>Gérer</th>
                                    
                                    
                                  </tr>

                                <?php                                                                                                   
                                if(isset($_GET['q'])) {$q=addslashes($_GET['q']); } else { $q=""; }

                                //pagination
                                if(isset($_GET['pg'] ) ) {$pg=$_GET['pg'];} else {$pg=1;}
                                $nbr_result_par_pg=12;
                                $lim_sup=$pg*$nbr_result_par_pg;
                                $lim_inf=$lim_sup-$nbr_result_par_pg;
                                //pagination--

                                //chercher les produits
                                $sql = new affiliation();
                                $req=$sql->list_produits($lim_inf,$nbr_result_par_pg);
                                
                                while($produit = $req->fetch()){

                                  //Vérifier si c'est des produits publiques
                                  $sql1 = new affiliation(); 
                                  $req1=$sql1->info_produit($produit['product_id']); 
                                  $info = $req1->fetch();
                                  if($info['post_status']=="publish") { 


                                  ?>
                                        <tr>
                                          <td><?php echo $produit['product_id'];?></td>
                                          <td> <a href="../product/<?php echo $info['post_name'];?>" target="_blank" ><?php echo $info['post_title'];?> </a></td>
                                          <td> <span id="tocopy<?php echo $produit['product_id'];?>"> <?php $sql2 = new affiliation(); $req2=$sql2->verif_link($produit['product_id'],$_SESSION['af_user_id']); $link = $req2->fetch(); if (isset($link['lien']) ) { echo"https://".$_SERVER['HTTP_HOST']."/pr/?o=".$link['lien'];} else { echo"Lien null"; } ?></span> </td>
                                          <td> 
                                            <?php if (isset($link['lien']) ) { ?>
                                              <a href="#" class="js-copy" data-target="#tocopy<?php echo $produit['product_id'];?>"> <button>Copier</button> </a>

                                          <?php } else { ?>

                                              <a href="?sec=tools_aff&prod=<?php echo $produit['product_id'];?>&user=<?php echo$_SESSION['af_user_id'];?>"> <button>Générer un lien</button> </a>
                                            <?php } ?>
                                            

                                          </td>
                                           
                                        </tr>
                                <?php 


                                    } else {}
                                }
                                ?>  
                                </table>
                                </div>

                                <div class="custom-pagination">
                                    <ul class="pagination">
            
                                        <?php 
                                        $sql = new pagination_affiliation();
                                        $pager=$sql->compter_produit_affiliation_user();
                                        $count_result_pagination = $pager->rowCount();


                                        $nbr_pg_total=$count_result_pagination/$nbr_result_par_pg;

                                        $nbr_pg_total = explode(".", $nbr_pg_total);

                                        if( isset($nbr_pg_total[1]) && ($nbr_pg_total[1]>0)){$nbr_pg_total = $nbr_pg_total[0]+1; } else { $nbr_pg_total = $nbr_pg_total[0]; }
                                        


                                        if ($pg>5) {
                                            $num_pg_gauche=$pg-5;
                                            $num_pg_precedent=$num_pg_gauche-1;

                                            if($pg>6) { ?> <li class="page-item"><a class="page-link" href="<?php echo $url;?>?sec=tools_aff&pg=<?php echo$num_pg_precedent; ?>&q=<?php echo$q;?>">Previous</a></li> <?php } else { } //affiche bouton précédent quand on est sur un page supérieur à 5

                                            while ( ($num_pg_gauche>0) && ($num_pg_gauche<$pg) ) { ?> <li class="page-item"><a class="page-link" href="<?php echo $url;?>?sec=tools_aff&pg=<?php echo$num_pg_gauche;?>&q=<?php echo$q;?>"><?php echo$num_pg_gauche; ?></a></li> <?php $num_pg_gauche++; } //affiche les pages entre precedent et la page actuelle

                                        } else {
                                            $num_pg_gauche=1;

                                            while ( ($num_pg_gauche>0) && ($num_pg_gauche<$pg) ) { ?> <li class="page-item"><a class="page-link" href="<?php echo $url;?>?sec=tools_aff&pg=<?php echo$num_pg_gauche;?>&q=<?php echo$q;?>"><?php echo$num_pg_gauche; ?></a></li> <?php $num_pg_gauche++; } //affiche les pages avant la page actuelle quand on est à une page inferieur ou égale à 5

                                        } 

                                        ?>

                                        <li class="page-item"><span><?php echo$pg; ?></span></li> <!--page actuelle -->

                                        <?php  
                                        if($nbr_pg_total>11) {
                                            $num_pg_suivant=$pg+5;
                                            $num_pg_droite=$pg+1;
                                            while ( ($num_pg_droite<$num_pg_suivant) && ($num_pg_droite<=$nbr_pg_total) ) { ?> <li><a href="<?php echo $url;?>?sec=tools_aff&pg=<?php echo$num_pg_droite; ?>&q=<?php echo$q;?>"><?php echo$num_pg_droite; ?></a></li> <?php $num_pg_droite++; } //Afficher les pages suivantes quand il y a plus de 11 pages au total

                                        }else{
                                            $num_pg_droite=$pg+1;
                                            while ($num_pg_droite<=$nbr_pg_total){ ?> <li class="page-item"><a class="page-link" href="<?php echo $url;?>?sec=tools_aff&pg=<?php echo$num_pg_droite; ?>&q=<?php echo$q;?>"><?php echo$num_pg_droite; ?></a></li> <?php $num_pg_droite++; }//Afficher les pages suivantes quand il y a moins de 11 pages au total
                                        }

                                        $num_avant_derniere_pg=$num_pg_droite-1;

                                        if($nbr_pg_total>$num_avant_derniere_pg) { //Metre le bouton suivant au besoin
                                        ?>
                                        <li class="page-item"><a >...</a></li>
                                        <li class="page-item"><a class="page-link" href="<?php echo $url;?>?sec=tools_aff&pg=<?php echo$pg+1; ?>&q=<?php echo$q; ?>">Next</a></li>
                                        <?php		                	
                                        } else { }

                                        ?>

                                    </ul>
                                </div>


                <?php



                         }

                         elseif(isset($_GET['sec'] ) && ($_GET['sec']=='retrait_aff' ) ) {


                          include 'form_retrait_affiliation.php';

                         }
                        
                        elseif(isset($_GET['sec'] ) && ($_GET['sec']=='setting_aff' ) ) {


                          include 'paramettre_aff.php';

                         }
                        else {

?>



                  <?php $id_user=$_SESSION['af_user_id']; 

                  $sql2 = new affiliation();
                  $req2=$sql2->info_account($id_user);
                  $ifo = $req2->fetch();
                  



                   ?>



                   <h3>Dashboard</h3>
                  <div class="row" >
                    <div class="col-md-4" >
                      

                      <div class="box-column " >
                        <div class="box-content">
                          <h4 class="box-column-heading be57373">Total vente</h4>          
                          <div class="box-content-desc">
                            <div class="box-content-icon"><img src="../wp-content/plugins/Samm/images/total_commission.png" alt="">
                            </div>
                            <div class="box-content-right">
                                <span class="box-content-value"><?php echo$ifo['total_vente'] ?></span>                  
                                <p>Vente réalisée sur la plateforme.</p>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  
                    <div class="col-md-4" >
                      

                      <div class="box-column " id="">
                        <div class="box-content">
                          <h4 class="box-column-heading b4FC3F7">Gain en attente</h4>          
                          <div class="box-content-desc">
                            <div class="box-content-icon"><img src="../wp-content/plugins/Samm/images/pending_commission.png" alt="">
                            </div>
                            <div class="box-content-right">
                                <span class="box-content-value"><?php echo$ifo['gain_tempo'] ?> CFA</span>                  
                                <p>Gain en attente de validation</p>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="col-md-4" >
                      
                      <div class="box-column " id="">
                        <div class="box-content">
                          <h4 class="box-column-heading b90A4AE">Gain d'affiliation</h4>          
                          <div class="box-content-desc">
                            <div class="box-content-icon"><img src="../wp-content/plugins/Samm/images/approved_commission.png" alt="">
                            </div>
                            <div class="box-content-right">
                                <span class="box-content-value"><?php echo$ifo['gain_affiliation'] ?> CFA</span>                  
                                <p>Commission validée et retirable.</p>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                    
                  </div>



                  <div class="row" >
                    <h3>Statistiques</h3>
                  </div>
                  <div class="row" >
                                 <div class="table-responsive">
                                 <table class="table">
                                  <tr>
                                    <th>ID</th>
                                    <th>Lien</th>
                                    <th>Clicks</th>
                                    <th>Vente</th>
                                    <th>Gérer</th>
                                    
                                    
                                  </tr>

                                <?php                                                                                                   
                                $click=0;
                                $vente=0;

                                if(isset($_GET['q'])) {$q=addslashes($_GET['q']); } else { $q=""; }

                                //pagination
                                if(isset($_GET['pg'] ) ) {$pg=$_GET['pg'];} else {$pg=1;}
                                $nbr_result_par_pg=6;
                                $lim_sup=$pg*$nbr_result_par_pg;
                                $lim_inf=$lim_sup-$nbr_result_par_pg;
                                //pagination--

                                //chercher les produits
                                $sql = new affiliation();
                                $req=$sql->list_link($_SESSION['af_user_id'],$lim_inf,$nbr_result_par_pg);
                                
                                while($link_info = $req->fetch()){

                                  ?>
                                        <tr>
                                          <td><?php echo $link_info['id'];?></td>
                                          <td><span id="tocopy<?php echo $link_info['id'];?>"><?php echo"https://".$_SERVER['HTTP_HOST']."/pr/?o=".$link_info['lien'];?> </span></td>
                                          <td><?php echo $link_info['nbr_click'];?> </td>
                                          <td><?php echo $link_info['nbr_vente'];?> </td>
                                          <td><a href="#" class="js-copy" data-target="#tocopy<?php echo $link_info['id'];?>"> <button>Copier</button> </a></td>
                                           
                                        </tr>
                                <?php 
       
                                $click=$click+$link_info['nbr_click'];
                                $vente=$vente+$link_info['nbr_vente'];


                                }
                                ?>  
                                </table>
                                </div>
                          </div>
                          <div class="row" >
                                <div class="custom-pagination">
                                    <ul class="pagination">
            
                                        <?php 
                                        $sql = new pagination_affiliation();
                                        $pager=$sql->compter_statistique_affiliation_user();
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
                              </div>
                              <div class="row" >
                                <table>
                                        <tr>
                                          <td>Total:</td>
                                          
                                          <td>Clicks: <?php echo $click;?> </td>
                                          <td>Ventes: <?php echo $vente;?> </td>
                                          
                                           
                                        </tr>

                                </table>
                                </div>

                  </div>





                <?php 


                         }
                ?>


</div>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
    <script>
    var btncopy = document.querySelector('.js-copy');
    if(btncopy) {
        btncopy.addEventListener('click', docopy);
    }

    function docopy() {
        var range = document.createRange();
        var target = this.dataset.target;
        var fromElement = document.querySelector(target);
        var selection = window.getSelection();

        range.selectNode(fromElement);
        selection.removeAllRanges();
        selection.addRange(range);

        try {
            var result = document.execCommand('copy');
            if (result) {
                // La copie a réussi
                alert('Copié !');
            }
        }
        catch(err) {
            // Une erreur est surevnue lors de la tentative de copie
            alert(err);
        }

        selection = window.getSelection();

        if (typeof selection.removeRange === 'function') {
            selection.removeRange(range);
        } else if (typeof selection.removeAllRanges === 'function') {
            selection.removeAllRanges();
        }
    }
    </script>









