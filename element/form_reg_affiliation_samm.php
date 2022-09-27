
<?php
require __DIR__ . '/style_form.html'; 
?>

<body>
    <div class="login">
        <div class="form">
            <form action="../wp-content/plugins/samm/controller/reg_affiliation.php" method="post" id="">
                <span class="material-icons"  style="color: #FFFFFF;">Inscription</span><br><br>
                <p style="color: #FFFFFF;">Créez un compte maintenant et commencez par vendre ou recommander nos produits pour gagner de l'argent.</p><br>
                
                
                <div class="">

                  <div class="form-group">
                     <div class="col-sm-12">
                        <label for="">Nom complet</label>
                        <input type="text" class="form-control" id="nom" placeholder="Nom complet" required name="nom">
                    </div>
                </div>
                <div class="form-group">
                 <div class="col-sm-12">
                    <label for="">Adresse email</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" required name="email">
                </div>
            </div>
            <div class="form-group">
             <div class="col-sm-12">
                <label for="">Numéro de téléphone</label>
                <input type="number" class="form-control" id="telephone" placeholder="Téléphone" required name="telephone">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label for="">Adresse</label>
                <input type="text" class="form-control" id="adresse" placeholder="Adresse" required name="adresse">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label for="">Type de compte</label>
                <select name="type" id="" class="form-control" required>
                    <option value="0">Veuillez sélectionner le type de compte</option>
                    <option value="1">Compte Affilié</option>
                    <option value="2">Compte Vendeur</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label for="">Entrer un mot de passe</label>
                <input type="password" name="mp1" minlength ="6" class="form-control" placeholder="Mot de passe">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label for="">Confirmer le mot de passe</label>
                <input type="password" name="mp2"  minlength ="6" class="form-control" placeholder="Confirmer le mot de passe">
            </div>
        </div>
        <div class="" style="text-align: left;" >
            <p>
                <label for="check" style=" color:#FFFFFF;  " >En vous inscrivant, vous acceptez sans réserve les conditions générales d'utilisation et la politique de confidentialité.</label> 
            </p>
        </div>

		<!-- <div class="form-group">
			<div class=" col-sm-12">
				<button type="submit" class="btn theme-bg text-light rounded">Créer un compte</button>
			</div>
		</div> -->
        <button>Créer un compte</button>
    </div>	

</form>
</div>
</div>
</body>