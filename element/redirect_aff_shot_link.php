<?php session_start();
      require('wp-content/plugins/samm/model/model.php');

    if(isset($_GET['o'] ) ) { 

        $sql1 = new affiliation(); 
        $req1=$sql1->info_link($_GET['o']); 
        $info = $req1->fetch();

        $ref_aff=$info['id_user'];

         if(isset($info['id_produit']) )
            {
            $sql2 = new affiliation(); 
            $req2=$sql2->info_produit($info['id_produit']); 
            $produit = $req2->fetch();

            $pg_title=$produit['post_title'];
            $pg_description=strip_tags($produit['post_content']);

            $sql4 = new affiliation(); 
            $req4=$sql4->img_produit($info['id_produit']); 
            $image = $req4->fetch();


            $pg_image=$image['guid'];
?>

         <script type="text/javascript"> let date = new Date(Date.now() + 8640000000); //86400000ms = 1 jour
                date = date.toUTCString();

                //Crée ou met à jour un cookie 
                document.cookie = 'refby=<?php echo$ref_aff; ?>; path=/; expires=' + date; </script> <?php
         

         $new_nbr_click=$info['nbr_click']+1;
         $sql3 = new affiliation(); 
         $req3=$sql3->update_click($new_nbr_click,$info['id']);          

         if(isset($info['id_produit']) )
            {

            ?>  

            <script type="text/javascript">window.location.href = "../product/<?php echo $produit['post_name'];?>";</script> 
            <?php }else { ?> <script type="text/javascript">window.location.href = "../";</script> <?php } 

            ?>




          <?php  }

        
    } else { ?> <script type="text/javascript">window.location.href = "../";</script> <?php }
 

 ?>