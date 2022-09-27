<?php

?> 


<div>
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
  th{font-weight: bold !important;  }
</style>


<form id="regForm" >



  <!-- One "tab" for each step in the form: -->
  <div class="tab" >

    <img src="../wp-content/plugins/samm/images/wellcome-1.png"  width="100%" >
    <h2 style="text-align: center;" >Bienvenue sur SAMM.</h2>
    <p style="text-align: center;" >Solution Africaine pour Marchés Multi-vendeurs.</p>
    <p style="text-align: center;" >SAMM associe MTN mobile money, woocommerce et le marketing d’affiliation pour faire de votre boutique une puissante plateforme abordable, inclusive et complète pour l'Afrique.</p>

    <h2>PREREQUIS:</h2>
    <table class="wp-list-table widefat fixed striped table-view-list">
      <tr>
        <th>Désignation</th>
        <th>Version</th>
        
        
      </tr>
      <tr>
        <td>Worpress</td>
        <td>6.0.2 et plus</td>
        
      </tr>
      <tr>
        <td>Woocommerce</td>
        <td>6.9.2 et plus</td>
        
      </tr>

    </table>

    <h2>Réglage 1:</h2>
    <p>Dans <b>Réglages/Permaliens</b>  choisissez l'option <b>Titre de la publication</b> comme réglages courant.</p>
    <img src="../wp-content/plugins/samm/images/reglage_permalien.jpg" width="100%" >
    <p>Dans la section <b>Permaliens de produit</b>  cochez <b>Base personnalisée</b> et saississez dans ce champ <b>/product/</b>.</p>
    <img src="../wp-content/plugins/samm/images/reglage_produit.jpg" width="100%" >


    <h2>Réglage 2:</h2>
    <p> Vérifiez que les pages suivantes existent et contiennent les shotcodes convenables. </p>

    <table class="wp-list-table widefat fixed striped table-view-list">
      <tr>
        <th>Titre de Page</th>
        <th>Slug</th>
        <th>Shotcodes</th>
        <th>Role</th>
        
        
      </tr>
      <tr>
        <td>Affiliate</td>
        <td>affiliate</td>
        <td>[reg_affiliation_samm]</td>
        <td>Page d'inscription des vendeurs et affiliés de votre boutique.</td>    
      </tr>
      <tr>
        <td>Dashboard Affiliate</td>
        <td>dashboard-affiliate</td>
        <td>[dashboard_affiliation_samm]</td>
        <td>Page de connexion des vendeurs et affiliés de votre boutique.</td> 
        
      </tr>
      <tr>
        <td>Checkout</td>
        <td>checkout</td>
        <td>[woocommerce_checkout] [samm_distribution] </td>
        <td>Page de paiement woocommerce.</td> 
        
      </tr>

      <tr>
        <td>Pr</td>
        <td>pr</td>
        <td>[samm_shot_link] </td>
        <td>Page de redirection des liens courts pour les affiliés.</td> 
        
      </tr>
    </table>
    <p><b>NB:</b> Si vous utilisez la version gratuite de SAMM, le préfixe de votre base de données doit être "<b>WP_</b>". </p>


    <h2>Réglage 3:</h2>
    <p>Dans <b>SAMM/Paramètre</b> définissez les <b>commisions</b> de vos vendeurs et affiliés.</p>
    <img src="../wp-content/plugins/samm/images/reglage_commission.jpg" width="100%" >

    <h2>Réglage 4:</h2>
    <p>Dans <b>Woocommerce/Réglages/Paiements</b>, activez la méthodes <b>MTN Momo</b> puis cliquez sur gérer.</p>
    <img src="../wp-content/plugins/samm/images/reglage_paiement.jpg" width="100%" >

    <p>Remplissez convenablement le formulaire de <b>SAMM MTN MoMo réglage</b> avec les informations reçus de MTN Momo de votre pays.</p>


    <p style="text-align: right;" >Merci</p>

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











