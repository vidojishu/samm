<?php
session_start();

if (isset($_SESSION['af_user_id']) and $_SESSION['af_user_type'] == 1) {
	include('dashboard_affiliation.php');
} elseif (isset($_SESSION['af_user_id']) and $_SESSION['af_user_type'] == 2 and $_SESSION['af_user_statut_boutique'] == '2') {
	# code...
	include('dashboard_vendeur.php');
} elseif (isset($_SESSION['af_user_id']) and $_SESSION['af_user_type'] == 2 and $_SESSION['af_user_statut_boutique'] !== '2') {
	# code...
	include('form_boutique_vendeur.php');
} else {
	include('form_cnx_affiliation.php');
}
