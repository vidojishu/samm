
<?php
require __DIR__ . '/style_form.html'; 
if(isset($_POST['email'] ) ) { require ABSPATH . 'wp-content/plugins/samm/controller/cnx_affiliation.php'; }
?>

<body>
	<div class="login">
		<div class="form">
			<form action="" method="post" id="">
				<div class=" centre">

					<div  class="" >
						<span class="material-icons" style=" color:#FFFFFF;" >Connexion</span><br>
						<p style="text-align: center; color:#FFFFFF;" ></p>
						<div class="form-group">
							<div class="col-sm-12">
								<input type="email" class="form-control" id="email" placeholder="Veuillez saisir votre email" required name="email">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
          <!--<select name="type" id="" class="form-control" required>
              <option value="0">Type de compte</option>
              <option value="1">Compte Affilié</option>
              <option value="2">Compte Vendeur</option>
          </select>-->
      </div>
  </div>

  <div class="form-group">
  	<div class="col-sm-12">
  		<input type="password" class="form-control" name="mp1" placeholder="Mot de passe"  >
  	</div>
  </div>

  <div class="form-group"> <!-- http://localhost/wordpress/mot-de-passe-oublie-affiliation/ -->
  	<a href="#" target="_blank" style="width: 85%; color:#FFFFFF;" >Mot de pass oublié</a> </br>
  	
  </div>

		<!-- <div class="form-group">
			<div class=" col-sm-12">
				<button type="submit" class="btn theme-bg text-light rounded">Se connecter</button>
			</div>
		</div> -->
		<button>Se connecter</button>

	</div>
</div>	

</form>
</div>
</div>
</body>