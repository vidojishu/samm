<?php $id_user=$_SESSION['af_user_id'];  ?>

    <div><h4>Liste des commandes</h4> </div>
 <table class="wp-list-table widefat fixed striped table-view-list">
  <tr>
    <th>Date</th>
    <th>N° Commande</th>
    <th>Produit</th>
    <th>Quantité</th>
    <th>Adresse de livraison</th>
    <th>Gérer</th>

    
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
		

$sql = new affiliation();
$req=$sql->find_achat_vendeur_valide($id_user);

while($marchant = $req->fetch()){
?>

  <tr>
    <td><?php echo $marchant['date'];?></td>
    <td><?php echo $marchant['wc_order_id'];?></td>
 
    <td> <a href="<?php echo get_permalink($marchant['wc_prod_id']);?>" target="_blank" ><?php echo get_the_title($marchant['wc_prod_id']);?> </a></td>
    <td><?php echo $marchant['quantite'];?></td> 
    <td>
        <?php echo $marchant['client_info'];?>
    </td>
    <td>
        
    </td>
  </tr>
<?php
}
?>  
</table>

<?php																		                                             

?>  

