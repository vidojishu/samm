<?php

if (isset($_POST['modif_infos'])) {


	$id_client = htmlspecialchars($_POST['id']);
	$nom = htmlspecialchars($_POST['nom']);
	$email = htmlspecialchars($_POST['email']);
	$telephone = htmlspecialchars($_POST['telephone']);
	$adresse = htmlspecialchars($_POST['adresse']);

	$sql = new affiliation();
	$req = $sql->update_infos_user($nom,$email,$telephone,$adresse,$id_client);
	?>
	<script type="text/javascript">
		alert('Modifiée avec succès!');
	</script>
	<?php
}

if (isset($_POST['modif_pass'])) {
	if (!empty($_POST['ancien_pass']) AND !empty($_POST['nouveau_pass']) AND !empty($_POST['confirmer_pass'])) {
		$pass=$_POST['pass'];
		$id_client=$_POST['id'];
		$ancien_pass=$_POST['ancien_pass'];
		$nouveau_pass=$_POST['nouveau_pass'];
		$confirmer_pass=$_POST['confirmer_pass'];

		if ($ancien_pass==$pass) {
			if ($nouveau_pass==$confirmer_pass) {
				$sql = new affiliation();
				$req = $sql->update_pass_user($nouveau_pass,$id_client);
				?> <script>alert('Mot de passe modifié avec succès!');</script> <?php
				# code...
			}
			# code...
		}
		# code...
	}
	# code...
}
?>
<?php
$sql1 = new affiliation();
$req1 = $sql1->info_account($_SESSION['af_user_id']);
$info = $req1->fetch();
?>
<!--<h3>Informations:</h3> -->
<style>
	table{
		border-collapse: collapse;		
	}

	td, th{
		border: 3px solid blue;
		padding: 3px;
		text-align: center;
	}
</style>

<table class="">
	<tr>
		<th>Nom et prénom</th>
		<th>Email</th>
		<th>Téléphone</th>
	</tr>

	
	<tr>
		<td><?php echo $info['nom']; ?></td>
		<td><?php echo $info['email']; ?></td>
		<td><?php echo $info['telephone']; ?></td>
	</tr>


</table>


<!-- 

<form action="" method="post" id="">
   <div class="">
   	<h3>Modifier Votre adresse de livraison.</h3>

		<div class="form-group">
		<label>Nouvelle adresse</label>
			<div class="col-sm-12">
				<input type="text" class="form-control" id="" placeholder="Veuillez saisir une adresse" required name="adresse" value="<?php echo $info['adresse']; ?>" >
			</div>
		</div>

		<input type="hidden" name="id"  id="id" value="<?php echo $_SESSION['aff_user_id']; ?>" >


		<div class="form-group">
			<div class=" col-sm-12">
				<p></p>
				<button type="submit" class="btn theme-bg text-light rounded">Modifier</button>
			</div>
		</div>
	</div>	

</form> -->

<div class="card-body">
	<h3>Modification</h3>
	<div class="row">
		<div class="col-md-6">
			<form action="" method="post">
				<div class="form-group">
					<div class="col-md-12">
						<p style="color:blue">Informations</p>
						<label for="">Nom</label>
						<input type="hidden" name="id" id="id" value="<?php echo $_SESSION['af_user_id']; ?>">
						<input type="text" class="form-control" required name="nom" id=""  value="<?php echo $info['nom']; ?> ">
						<label for="">Email</label>
						<input type="email" class="form-control" disabled required  id="" value="<?php echo $info['email']; ?>">
						<input type="hidden" required name="email" id="" value="<?php echo $info['email']; ?>">
						<label for="">Télephone</label>
						<input type="number" class="form-control" required name="telephone" id="" value="<?php echo $info['telephone']; ?>">
						<label for="">Adresse</label>
						<input type="text" class="form-control" required name="adresse" id="" value="<?php echo $info['adresse']; ?>">
					</div>
				</div> <p>.</p> 
				<div class="form-group">
					<div class="col-md-6">
						<input type="submit" class="form-control btn btn-primary" value="Modifier" name="modif_infos">
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-6">
			<form action="" method="post">
				<div class="form-group">
					<div class="col-md-12">
						<p style="color:green">Mot de passe</p>
						<label for="">Ancien mot de passe</label>
						<input type="hidden" name="pass" value="<?php echo $info['pass']; ?>">
						<input type="hidden" name="id" value="<?php echo $_SESSION['aff_user_id']; ?>">
						<input type="password" class="form-control" required name="ancien_pass" id="">
						<label for="">Nouveau mot de passe</label>
						<input type="password" class="form-control" required name="nouveau_pass" id="">
						<label for="">Confirmer mot de passe</label>
						<input type="password" class="form-control" required name="confirmer_pass" id="">
					</div>
				</div><p>.</p>
				<div class="form-group">
					<div class="col-md-6">
						<input type="submit" class="form-control btn btn-success" value="Modifier mot de passe" name="modif_pass">
					</div>
				</div>
			</form>
		</div>
	</div>

</div>

