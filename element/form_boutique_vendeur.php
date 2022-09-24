<?php
  date_default_timezone_set('Africa/Porto-Novo');
  require('wp-content/plugins/samm/model/model.php');



 if(isset($_GET['ret'])) { ?> <script type="text/javascript">window.location.href = "<?php echo 'dashboard-affiliate/'; ?>";</script> <?php }  else { }


//Se deconnecter
  if(isset($_GET['dec'])) { session_destroy(); ?> <script type="text/javascript">window.location.href = "<?php echo 'dashboard-affiliate/'; ?>";</script> <?php }  else { }


//Apres remplissage du premier formulaire

  if(isset($_POST['nom_commercial'] ) ){ 

  $nom_commercial = htmlspecialchars ($_POST['nom_commercial']);
  $email = htmlspecialchars ($_POST['email']);
  $telephone = htmlspecialchars ($_POST['phone']); 
  $adresse = htmlspecialchars ($_POST['adresse']);
  $description = htmlspecialchars ($_POST['description']);
  $id_user= $_SESSION['af_user_id'];

  $sql = new affiliation();
  $req=$sql->add_shop_details($nom_commercial,$email,$telephone,$adresse,$description,$id_user);
  $rps = $req;
  
        ?>
            <script type="text/javascript">
                alert('Demande effectuée avec succès! Nous allons valider votre compte après vérification! Merci!');
                window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>?dec=01";
            </script>
        <?php

   } else { }








if($_SESSION['af_user_statut_boutique']==1) {

        ?>
            <script type="text/javascript">
                alert('Vous avez une demande en cours! Merci de patienter!');
                
            </script>
        <?php

}


include'wp-content/plugins/samm/css/dashboard_style.html';
?> 



<div class="sidebar">
  <a <?php if((isset($_GET['sec'] ) && ($_GET['sec']=='dashboard_vendeur' )) OR !isset($_GET['sec'] ) ){ echo'class="active"'; } ?> href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-dashboard fa-stack-1x "></i></span> Dashboard</a>
  <a <?php if((isset($_GET['sec'] ) && ($_GET['sec']=='tools_vendeur' )) ){ echo'class="active"'; } ?> href="#"> <span class="fa-stack fa-lg pull-left"><i class="fa fa-bars fa-stack-1x "></i></span>Produits</a>
  <a <?php if((isset($_GET['sec'] ) && ($_GET['sec']=='tools_vendeur' )) ){ echo'class="active"'; } ?> href="#"> <span class="fa-stack fa-lg pull-left"><i class="fa fa-bars fa-stack-1x "></i></span>Commandes</a>
  <a <?php if((isset($_GET['sec'] ) && ($_GET['sec']=='retrait_vendeur' )) ){ echo'class="active"'; } ?> href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-money fa-stack-1x "></i></span>Retrait</a>
  <a <?php if((isset($_GET['sec'] ) && ($_GET['sec']=='setting_vendeur' )) ){ echo'class="active"'; } ?> href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-wrench fa-stack-1x "></i></span>Paramètre</a>
  <a  href="?dec=01" style="color: red !important;" ><span class="fa-stack fa-lg pull-left"><i class="fa fa-logout fa-stack-1x "></i></span>Se déconnecter</a>
</div>

<div class="content"  >

<style type="text/css">
   /* Style the form */
#regForm {
  background-color: #ffffff;
  margin: 100px auto;
  padding: 40px;
  width: 70%;
  min-width: 300px;
}

/* Style the input fields */
input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

/* Mark the active step: */
.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #04AA6D;
} 
</style>


 <form id="regForm" method="post" action="">



<!-- One "tab" for each step in the form: -->
<div class="tab">

<img src="../wp-content/plugins/samm/images/man-with-laptop-light.png">
<h4>Bienvenue dans votre compte vendeur.</h4>
<p>Avant de commencer, veuillez renseigner les informations relatives à votre boutique. </p>

</div>

<div class="tab">
  <h4>Informations Générales</h4>
  <p><input placeholder="Nom commercial" name="nom_commercial" oninput="this.className = ''"></p>
  <p><textarea style="border: solid black 1px; background: transparent; " name="description" placeholder="Que voulez-vous vendre?" oninput="this.className = ''"></textarea></p>
  
</div>

<div class="tab">Contacts et adresse:
    <p><input placeholder="Email" name="email" oninput="this.className = ''"></p>
  <p><input placeholder="Téléphone" name="phone" oninput="this.className = ''"></p>

  <p><input placeholder="Adresse" name="adresse" oninput="this.className = ''"></p>
  
</div>


<div style="overflow:auto;">
  <div style="float:right;">
    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Précédant</button>
    <button type="button" id="nextBtn" onclick="nextPrev(1)">Suivant</button>
  </div>
</div>

<!-- Circles which indicates the steps of the form: -->
<div style="text-align:center;margin-top:40px;">
  <span class="step"></span>
  <span class="step"></span>
  <span class="step"></span>
  
</div>

</form> 
<script type="text/javascript">
  var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Soumetre";
  } else {
    document.getElementById("nextBtn").innerHTML = "Suivant";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}
</script>

</div>

   









