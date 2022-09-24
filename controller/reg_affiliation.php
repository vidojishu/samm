<?php 
    require('../model/model.php');

    

if(isset($_POST['nom']) AND isset ($_POST['email']) AND isset($_POST['telephone'])){
		

	$nom = htmlspecialchars ($_POST['nom']);
	$email = htmlspecialchars ($_POST['email']);
	$telephone = htmlspecialchars ($_POST['telephone']); 
	$mp1 = htmlspecialchars ($_POST['mp1']);
	$mp2 = htmlspecialchars ($_POST['mp2']);
	$adresse = htmlspecialchars ($_POST['adresse']);
	$type = htmlspecialchars ($_POST['type']);

	$date_inscription=htmlspecialchars(date('d-M-Y/H:i'));

	$sql = new affiliation();
	$req=$sql->search_account($email);
	$rps = $req;
	
	if($rps==1){
		?>
			<script type="text/javascript">alert('Vous avez déjà un compte! Veuillez vous connecter!'); window.location.href = "../../../../dashboard-affiliate/";</script>
		<?php
	}
	else{
		# code...
		if($mp1<>$mp2) {
			?>
				<script type="text/javascript">alert('Mot de passe pas identiques! Veuillez réssayer!'); window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";</script>
			<?php
		}
		else {
			# code...
			$temps=time();

			if ($type==1) {
				# code...

				$sql_reg = new affiliation();
				//enregistrement des données dans la bdd tempo
				$req_reg=$sql_reg->reg_affiliation1($type,$temps,$nom,$email,$telephone,$adresse,$date_inscription,$mp1);
				$enregistre = $req_reg->fetch();
				// message
			$date_footer=date("Y");
			$body = "
							<html>
								<head>
									<title></title>

								<style>
									.p9 {
									text-align: center;
									background-color: #C4C9C7;
									}
									.button {
									border: none;
									color: white;
									padding: 15px 32px;
									text-align: center;
									text-decoration: none;
									display: inline-block;
									font-size: 16px;
									margin: 4px 2px;
									cursor: pointer;
									}
									.button1 {background-color: #4CAF50;} /* Green */
									.button2 {background-color: #008CBA;} /* Blue */
								</style>                
								</head>
								<body>
									<p></p>
									<p> Bonjour </p>
									<p>Merci ".$nom." de votre inscription.</p>
									<p>Votre compte est prêt.</p>
									<p>
									Vous pouvez vous connecter à présent.
									</p>
									<p><a href='".$_SERVER['HTTP_HOST']."/dashboard-affiliate/'><button class='button button1'>Se connecter</button></a></p>
									<p> Merci d'être sur ".$_SERVER['HTTP_HOST']."</p>
									<p></p>
									<p class='p9'>".$date_footer." &copy; Copyright, ".$_SERVER['HTTP_HOST']." .   </p>
								</body>
							</html>
						"; $body=utf8_decode($body);
						// Pour envoyer un mail HTML, l'en-t?te Content-type doit ?tre d?fini
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .= 'From: '.$_SERVER['HTTP_HOST'].' <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
				
						@mail($email,'Votre compte affiliation est pret', $body, $headers,'-noreply@'.$_SERVER['HTTP_HOST']);


						// message admin
						$body2 = "
							<html>
								<head>
									<title></title>
								</head>
								<body>
									<p> Bonjour Admin. </p>
									<p> 
										Un nouveau compte vient d'etre cree sur l'espace affiliation.
									</p>
								</body>
							</html>
						";
			
						@mail('contact@'.$_SERVER['HTTP_HOST'],'Un nouveau compte affiliation', $body2, $headers,'-noreply@'.$_SERVER['HTTP_HOST']); 


			?> 
				<script type="text/javascript"> alert('Votre compte a été créé avec succès! Vous pouvez vous connecter!'); window.location.href = "../../../../dashboard-affiliate/";</script>
			<?php
			}
			elseif ($type==2) {
				# code...

				$sql_reg = new affiliation();
				//enregistrement des données dans la bdd tempo
				$req_reg=$sql_reg->reg_affiliation2($type,$temps,$nom,$email,$telephone,$adresse,$date_inscription,$mp1);
				$enregistre = $req_reg->fetch();
				// message
			$date_footer=date("Y");
			$body = "

							<html>
								<head>
									<title></title>

								<style>
									.p9 {
									text-align: center;
									background-color: #C4C9C7;
									}
									.button {
									border: none;
									color: white;
									padding: 15px 32px;
									text-align: center;
									text-decoration: none;
									display: inline-block;
									font-size: 16px;
									margin: 4px 2px;
									cursor: pointer;
									}
									.button1 {background-color: #4CAF50;} /* Green */
									.button2 {background-color: #008CBA;} /* Blue */
								</style>                
								</head>
								<body>
									<p></p>
									<p> Bonjour </p>
									<p>Merci ".$nom." de votre inscription.</p>
									<p>Votre compte est prêt.</p>
									<p>
									Vous pouvez vous connecter à présent.
									</p>
									<p><a href='".$_SERVER['HTTP_HOST']."/marchands/'><button class='button button1'>Se connecter</button></a></p>
									<p> Merci d'être sur ".$_SERVER['HTTP_HOST']."</p>
									<p></p>
									<p class='p9'>".$date_footer." &copy; Copyright, ".$_SERVER['HTTP_HOST']." .   </p>
								</body>
							</html>
						"; $body=utf8_decode($body);
						// Pour envoyer un mail HTML, l'en-t?te Content-type doit ?tre d?fini
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .= 'From: '.$_SERVER['HTTP_HOST'].' <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
				
						@mail($email,'Votre demande de compte marchand', $body, $headers,'-noreply@'.$_SERVER['HTTP_HOST']);


						// message admin
						$body2 = "
							<html>
								<head>
									<title></title>
								</head>
								<body>
									<p> Bonjour Admin. </p>
									<p> 
										Une nouvelle demande de compte marchand vient d'être émise.
									</p>
								</body>
							</html>
						";
			
						@mail('contact@'.$_SERVER['HTTP_HOST'],'Un nouveau compte marchand', $body2, $headers,'-noreply@'.$_SERVER['HTTP_HOST']); 


			?> 
				<script type="text/javascript"> alert('Votre compte a été créé avec succès! '); window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";</script>
			<?php
			}
			else {
				?>
					<script type="text/javascript">alert('Veuillez sélectionner le type de compte !'); window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";</script>
				<?php
			}			
		}
	}

}
else {  ?> <script type="text/javascript">window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";</script> <?php  }