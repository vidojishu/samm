<?php

include('../wp-content/plugins/samm/model/model.php');
if (isset($_POST['com_aff'])) {


	$com_aff = htmlspecialchars($_POST['com_aff']);
	$com_vend = htmlspecialchars($_POST['com_vend']);

        # code...
    $sql = new affiliation();
    $req = $sql->update_admin_reglage($com_aff,$com_vend);
    $enregistre = $req->fetch();


    ?>

    <script type="text/javascript">
        alert('Enregistré!');
    </script>
    <?php
    
}
else { }

        # code...
    $sql = new affiliation();
$req = $sql->get_samm_admin_details();
$admin_details = $req->fetch();




?>

<div class="card-body">
	<h3>Réglage générale</h3>
	<div class="row">
		<div class="col-md-6">
            <form action="" method="post">
                <div class="form-group">
                    <div class="col-md-12">
                        <p style="color:blue">Déffinissez les commissions</p>
                        <label for="">Commission Affilié(%) </label>
                        <input type="number" class="form-control" required name="com_aff" max="100"> value="<?=$admin_details['commission_affilie']; ?>"> </br>
                        <label for="">Commission Vendeur(%) </label>
                        <input type="number" class="form-control" required name="com_vend" max="100" value="<?=$admin_details['commission_vendeur']; ?>" >            
                        
                        
                    </div>
                </div><br>
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="submit" class="form-control btn btn-primary" value="Enregistrer" name="Enregistrer">
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>






