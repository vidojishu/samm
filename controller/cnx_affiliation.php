<?php
session_start();
require ABSPATH . 'wp-content/plugins/samm/model/model.php';
//require('../model/model.php');

if (isset($_POST['email']) and isset($_POST['mp1'])) {

	$email = htmlspecialchars($_POST['email']);
	//$type = htmlspecialchars($_POST['type']);
	$mp1 = htmlspecialchars($_POST['mp1']);
	
	/* $sql0 = new affiliation();
	$req0 = $sql0->status_account($email, $type);
	$rps0 = $req0;

	if ($rps0 == 1){ */

	/* $sql = new affiliation();
	$req = $sql->verif_account($email, $mp1, $type);
	$rps = $req; */

	$sql1 = new affiliation();
	$req1 = $sql1->connect_account($email, $mp1);
	$account = $req1->fetch();
    $rps = $req1->rowCount();

	if ($rps == 1) {

		if ($account['valide']==1) {
			$_SESSION['af_user_id'] = $account['id'];
			$_SESSION['af_user_name'] = $account['nom'];
			$_SESSION['af_user_email'] = $account['email'];
			$_SESSION['af_user_type'] = $account['type'];
			$_SESSION['af_user_nom_boutique'] = $account['nom_boutique'];
			$_SESSION['af_user_statut_boutique'] = $account['statut_boutique'];
		}
		else {
			# code...
			?>
				<script type="text/javascript">
					alert('Compte désactivé. Veuillez contacter l\'administrateur du site !');
					window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
				</script>
			<?php
		}
?>
		<script type="text/javascript">
			window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
		</script>
	<?php
	} else {
	?>
		<script type="text/javascript">
			alert('Email ou Mot de passe erronné pour ce type de compte. Veuillez vérifier les informations saisies !');
			window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
		</script>
	<?php
	}
} else { ?> <script type="text/javascript">
		window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
	</script> <?php }
