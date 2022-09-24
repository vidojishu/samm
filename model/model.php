<?php

 if(!isset($_SESSION)){session_start();}



	class admin_affiliation{
			 


		private function dbConnect(){
			require_once ABSPATH . '/wp-load.php';

			global $wpdb;
			$bds=json_decode(json_encode($wpdb->dbname));
			$bdp=json_decode(json_encode($wpdb->dbpassword));
			$bdu=json_decode(json_encode($wpdb->dbuser));

			$option = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
			);
			try{
				$db=new PDO("mysql:host=localhost;dbname=".$bds,$bdu,$bdp, $option);
				return $db;
			}  
			catch(PDOException $e){
				die('erreur:'. $e->getMessage());
			}
		}

        public function afficher_user_affiliation1($lim_inf, $nbr_result_par_pg){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM samm_utilisateurs WHERE type=1 ORDER BY id DESC LIMIT $lim_inf, $nbr_result_par_pg");
			$req->execute();
			return $req;
		}

		public function afficher_user_affiliation2($lim_inf, $nbr_result_par_pg){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM samm_utilisateurs WHERE type=2 ORDER BY id DESC LIMIT $lim_inf, $nbr_result_par_pg");
			$req->execute();
			return $req;
		}

		public function activer_compte_user($id){
			$db=$this->dbConnect();
			$req=$db->prepare('UPDATE samm_utilisateurs SET valide=1 WHERE id=?');
			$req->execute(array($id));
			return $req;
		}

		public function activer_compte_vendeur($id){
			$db=$this->dbConnect();
			$req=$db->prepare('UPDATE samm_utilisateurs SET statut_boutique=2 WHERE id=?');
			$req->execute(array($id));
			return $req;
		}

		public function desactiver_compte_user($id){
			$db=$this->dbConnect();
			$req=$db->prepare('UPDATE samm_utilisateurs SET valide=0 WHERE id=?');
			$req->execute(array($id));
			return $req;
		}
		public function desactiver_compte_vendeur($id){
			$db=$this->dbConnect();
			$req=$db->prepare('UPDATE samm_utilisateurs SET statut_boutique=1 WHERE id=?');
			$req->execute(array($id));
			return $req;
		}

		public function suprimer_afficher_user_affiliation($id){
			$db=$this->dbConnect();
			$req=$db->prepare('DELETE FROM samm_utilisateurs WHERE id=? ');
			$req->execute(array($id));
			return $req;
		}

		public function afficher_demande_retraitx($lim_inf, $nbr_result_par_pg){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT samm_utilisateurs.id, samm_utilisateurs.nom, samm_utilisateurs.email, samm_utilisateurs.telephone,
			samm_retrait.id, samm_retrait.id_user, samm_retrait.montant_retrait,
			samm_retrait.moyen_paiement, samm_retrait.details_retrait,
			samm_retrait.date_demande, samm_retrait.heure_demande
			,samm_retrait.status
			FROM samm_utilisateurs, samm_retrait
			WHERE samm_utilisateurs.id = samm_retrait.id_user ORDER BY samm_retrait.id DESC LIMIT $lim_inf, $nbr_result_par_pg");
			$req->execute();
			return $req;
		}

		public function afficher_demande_retrait($lim_inf, $nbr_result_par_pg){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM samm_retrait ORDER BY id DESC LIMIT $lim_inf, $nbr_result_par_pg");
			$req->execute();
			return $req;
		}

		public function afficher_infos_demande_retrait($id_user){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM samm_utilisateurs WHERE id = ?");
			$req->execute(array($id_user));
			return $req;
		}

		public function rechercher_demande_retrait_affiliation($id_retrait_affiliation){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM retrait_affiliation WHERE id = ? ");
			$req->execute(array($id_retrait_affiliation));
			return $req;
		}

		public function update_gain_affiliation($gain_restant,$id_user){
			$db=$this->dbConnect();
			$req=$db->prepare("UPDATE utilisateur SET gain_affiliation=? WHERE id=?");
			$req->execute(array($gain_restant,$id_user));
			return $req;
		}

		public function update_status_retrait($id_retrait_affiliation){
			$db=$this->dbConnect();
			$req=$db->prepare("UPDATE retrait_affiliation SET status=1 WHERE id=?");
			$req->execute(array($id_retrait_affiliation));
			return $req;
		}

		public function traiter_demande_marchant($id){
			$db=$this->dbConnect();
			$req=$db->prepare('UPDATE demande_compte_marchant SET valide=2 WHERE id=?');
			$req->execute(array($id));
			return $req;
		}

		public function afficher_abonne_list(){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM wp_users ORDER BY ID DESC');
			$req->execute();
			return $req;
		}
		public function actualiser_abonnement($id_marchant,$abonnement,$date_fin){
			$db=$this->dbConnect();
			$req=$db->prepare('UPDATE wp_users SET abonnement_marchant=?, date_fin_abonnement=? WHERE id= ?');
			$req->execute(array($abonnement, $date_fin, $id_marchant));		
			return $req;
		}
		public function list_carte(){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM carte_tontine ORDER BY id DESC');
			$req->execute();	
			return $req;
		}





	} 




	class user_affiliation{	
		 

		private function dbConnect(){
			require_once ABSPATH . '/wp-load.php';

			global $wpdb;
			$bds=json_decode(json_encode($wpdb->dbname));
			$bdp=json_decode(json_encode($wpdb->dbpassword));
			$bdu=json_decode(json_encode($wpdb->dbuser));

			$option = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
			);
			try{
				$db=new PDO("mysql:host=localhost;dbname=".$bds,$bdu,$bdp, $option);
				return $db;
			}  
			catch(PDOException $e){
				die('erreur:'. $e->getMessage());
			}
		}

		public function info_account($id_user){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_utilisateur WHERE id=? ');
			$req->execute(array($id_user));	
			return $req;
		}

		

	}

	class affiliation{	
		 

		private function dbConnect(){
			require_once ABSPATH . '/wp-load.php';

			global $wpdb;
			$bds=json_decode(json_encode($wpdb->dbname));
			$bdp=json_decode(json_encode($wpdb->dbpassword));
			$bdu=json_decode(json_encode($wpdb->dbuser));

			
			$option = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
			);
			try{
				$db=new PDO("mysql:host=localhost;dbname=".$bds,$bdu,$bdp, $option);
				return $db;
			}  
			catch(PDOException $e){
				die('erreur:'. $e->getMessage());
			}
		}

		public function status_account($email,$type){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_utilisateurs WHERE email=? AND type=? AND valide=1 ');
			$req->execute(array($email,$type));	
			$count = $req->rowCount();
			return $count;
		}

		public function connect_account($email,$mp1){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_utilisateurs WHERE email=? AND pass=? ');
			$req->execute(array($email,$mp1));	
			return $req;
		}

		public function verif_account($email,$mp1,$type){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_utilisateurs WHERE email=? AND pass=? AND type=? ');
			$req->execute(array($email,$mp1,$type));
			$count = $req->rowCount();
			return $count;
		}

		public function verif_forget_pass($email){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM utilisateur WHERE email=? ');
			$req->execute(array($email));
			$count = $req->rowCount();
			return $count;
		}

		public function forget_pass_account($email){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM utilisateur WHERE email=? ');
			$req->execute(array($email));	
			return $req;
		}

		public function update_forget_pass($nouveau_pass,$user){
			$db=$this->dbConnect();
			$req=$db->prepare('UPDATE utilisateur SET pass= ? WHERE id=?');
			$req->execute(array($nouveau_pass,$user));

			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM utilisateur WHERE id=? ');
			$req->execute(array($user));

			$accont = $req->fetch();
			$mail= $accont['email'];

			$db=$this->dbConnect();
			$req=$db->prepare('UPDATE samm_utilisateurs_tempo SET pass= ? WHERE email=?');
			$req->execute(array($nouveau_pass,$mail));


			return $req;
		}

		public function reg_affiliation1($type,$temps,$nom,$email,$telephone,$adresse,$date_inscription,$mp1){
			setlocale (LC_TIME, 'fr_FR.UTF8');
			setlocale (LC_TIME, 'fr_FR');
			setlocale (LC_TIME, 'fr');
			$temps=time();
			$date_inscription=htmlspecialchars(date('d-M-Y/H:i'));

			$db=$this->dbConnect();
			$req=$db->prepare('INSERT INTO `samm_utilisateurs`(`type`,`temps`,`nom`, `email`, `telephone`, `adresse`, `date_inscription`, `pass`, `valide`, `gain_tempo`, `gain_affiliation`) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
			$req->execute(array($type,$temps,$nom,$email,$telephone,$adresse,$date_inscription,$mp1,1,0,0));
			return $req;
		}

		public function reg_affiliation2($type,$temps,$nom,$email,$telephone,$adresse,$date_inscription,$mp1){
			setlocale (LC_TIME, 'fr_FR.UTF8');
			setlocale (LC_TIME, 'fr_FR');
			setlocale (LC_TIME, 'fr');
			$temps=time();
			$date_inscription=htmlspecialchars(date('d-M-Y/H:i'));

			$db=$this->dbConnect();
			$req=$db->prepare('INSERT INTO `samm_utilisateurs`(`type`,`temps`,`nom`, `email`, `telephone`, `adresse`, `date_inscription`, `pass`, `valide`, `gain_tempo`, `gain_affiliation`) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
			$req->execute(array($type,$temps,$nom,$email,$telephone,$adresse,$date_inscription,$mp1,1,0,0));
			return $req;
		}

		

		public function infos_reg_affiliation($id_client){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_utilisateurs_tempo WHERE id=? ');
			$req->execute(array($id_client));	
			return $req;
		}

		public function reg_affiliation11($id){
			$db=$this->dbConnect();
			$req=$db->prepare("UPDATE samm_utilisateurs_tempo SET valide=1 WHERE id=?");
			$req->execute(array($id));
			return $req;
		}

		public function reg_affiliation22($gain_tempo,$gain_affiliation,$total_retrait,$total_clic,$total_vente,$a1,$a2,$a3,$nbre_a1,$nbre_a2,$nbre_a3,$v1,$v2,$v3,$nbre_v1,$nbre_v2,$nbre_v3,$p1,$p2,$p3,$nbre_p1,$nbre_p2,$nbre_p3,$lien_affiliation,$lien_mlm,$temps,$parrain,$parrain2,$parrain3,$parrain4,$parrain5,$parrain6,$parrain7,$parrain8,$parrain9,$nom,$email,$telephone,$adresse,$date_inscription,$mp1){

			$db=$this->dbConnect();
			$req=$db->prepare('INSERT INTO `utilisateur`(`gain_tempo`,`gain_affiliation`,`total_retrait`,`total_clic`,`total_vente`,`a1`,`a2`,`a3`,`nbre_a1`,`nbre_a2`,`nbre_a3`,`v1`,`v2`,`v3`,`nbre_v1`,`nbre_v2`,`nbre_v3`,`p1`,`p2`,`p3`,`nbre_p1`,`nbre_p2`,`nbre_p3`,`ref_affiliation`,`ref_mlm`,`temps`,`parrain1`,`parrain2`,`parrain3`,`parrain4`,`parrain5`,`parrain6`,`parrain7`,`parrain8`,`parrain9`,`nom`, `email`, `telephone`, `adresse`, `date_inscription`, `pass`, `valide`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
			$req->execute(array($gain_tempo,$gain_affiliation,$total_retrait,$total_clic,$total_vente,$a1,$a2,$a3,$nbre_a1,$nbre_a2,$nbre_a3,$v1,$v2,$v3,$nbre_v1,$nbre_v2,$nbre_v3,$p1,$p2,$p3,$nbre_p1,$nbre_p2,$nbre_p3,$lien_affiliation,$lien_mlm,$temps,$parrain,$parrain2,$parrain3,$parrain4,$parrain5,$parrain6,$parrain7,$parrain8,$parrain9,$nom,$email,$telephone,$adresse,$date_inscription,$mp1,1));
			return $req;
		}

		public function search_reg_affiliation($email,$temps){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_utilisateurs WHERE email=? AND temps=? ');
			$req->execute(array($email,$temps));
			return $req;
		}

		public function update_reg_affiliation($lien_affiliation,$lien_mlm,$id){
			$db=$this->dbConnect();
			$req=$db->prepare("UPDATE utilisateur SET ref_affiliation=?, ref_mlm=?, valide=1 WHERE id=?");
			$req->execute(array($lien_affiliation,$lien_mlm,$id));
			return $req;
		}

		public function search_account($email){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_utilisateurs WHERE email=? ');
			$req->execute(array($email));
			$count = $req->rowCount();
			return $count;
		}



		

		

		

		public function info_account($id_user){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_utilisateurs WHERE id=? ');
			$req->execute(array($id_user));	
			return $req;
		}

		public function info_retrait($id_user){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_retrait WHERE id_user=? AND status=0 ');
			$req->execute(array($id_user));	
			return $req;
		}

		public function historique_retrait($id_user,$lim_inf,$nbr_result_par_pg){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM retrait_affiliation WHERE id_user=? AND status=1  ORDER BY id DESC LIMIT $lim_inf, $nbr_result_par_pg");
			$req->execute(array($id_user));	
			return $req;
		}

		/* public function list_produits(){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM wp_wc_product_meta_lookup  ORDER BY product_id DESC');
			$req->execute();	
			return $req;
		} */

        public function list_produits($lim_inf,$nbr_result_par_pg){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM wp_wc_product_meta_lookup ORDER BY product_id DESC LIMIT $lim_inf, $nbr_result_par_pg");
			$req->execute();	
			return $req;
		}

		public function info_produit($id){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM wp_posts WHERE ID=? ');
			$req->execute(array($id));	
			return $req;
		}
		public function create_prod_link($id_user,$id_prod){
			$lien="c".$id_user."p".$id_prod."l";
			$temps=time();
			$db=$this->dbConnect();
			$req=$db->prepare('INSERT INTO `samm_affiliate_prod_link`(`id_user`, `id_produit`, `lien`, `temps`) VALUES (?,?,?,?)');
			$req->execute(array($id_user,$id_prod,$lien,$temps));
			return $req;
		}		
		public function verif_link($id_produit,$id_user){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM  samm_affiliate_prod_link WHERE id_produit=? AND id_user=? ');
			$req->execute(array($id_produit,$id_user));
			return $req;
		}

		/* public function list_link($id_user){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM  samm_affiliate_prod_link WHERE id_user=? ');
			$req->execute(array($id_user));
			return $req;
		} */

        public function list_link($id_user,$lim_inf,$nbr_result_par_pg){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM  samm_affiliate_prod_link WHERE id_user=? ORDER BY id DESC LIMIT $lim_inf, $nbr_result_par_pg");
			$req->execute(array($id_user));
			return $req;
		}

        public function list_produit_par_vendeur($id_vendeur,$lim_inf,$nbr_result_par_pg){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM samm_produits WHERE id_user=? ORDER BY id DESC LIMIT $lim_inf, $nbr_result_par_pg");
			$req->execute(array($id_vendeur));
			return $req;
		}

		public function info_link($lien){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM  samm_affiliate_prod_link WHERE lien=? ');
			$req->execute(array($lien));
			return $req;
		}
		public function update_click($nbr_click,$id){
			$db=$this->dbConnect();
			$req=$db->prepare("UPDATE samm_affiliate_prod_link SET nbr_click=? WHERE id=?");
			$req->execute(array($nbr_click,$id));
			return $req;
		}
		public function img_produit($id){
			$type="image";
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM wp_posts WHERE post_mime_type LIKE '%$type%' AND 	post_parent=? ");
			$req->execute(array($id));	
			return $req;
		}	
		public function info_cmd($key){
			$type="image";
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM wp_posts WHERE post_password=? ");
			$req->execute(array($key));	
			return $req;
		}

		public function details_cmd($id){
			$type="image";
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM wp_postmeta WHERE post_id=? AND meta_key='_order_total' ");
			$req->execute(array($id));	
			return $req;
		}
		public function add_cmd_aff($refby,$id_cmd,$montant,$commission_affilie){

			$db=$this->dbConnect();
			$req=$db->prepare('INSERT INTO `samm_gain_affiliate_salle`(`refby`, `id_cmd`, `montant`, `gain_affiliate`) VALUES (?,?,?,?)');
			$req->execute(array($refby,$id_cmd,$montant,$gain));

			$db1=$this->dbConnect();
			$req1=$db1->prepare('SELECT * FROM samm_utilisateurs WHERE id=? ');
			$req1->execute(array($refby));	
			$user = $req1->fetch();
			$new_gain_tempo=$user['gain_tempo']+$gain;
			$nbre_vente=$user['total_vente']+1;


			$db2=$this->dbConnect();
			$req2=$db2->prepare("UPDATE samm_utilisateurs SET gain_tempo='$new_gain_tempo', total_vente='$nbre_vente' WHERE id=?");
			$req2->execute(array($refby));

			$send_mail=$user['email'];
			return $send_mail;

		}
		public function verif_achat_aff($ref_aff){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM samm_gain_affiliate_salle WHERE refby=? AND valide=0 ");
			$req->execute(array($ref_aff));	
			return $req;
		}

		public function verif_achat_vendeur($id_vendeur){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM samm_cmd_details WHERE id_user=? AND statut=0 ");
			$req->execute(array($id_vendeur));	
			return $req;
		}
		public function find_achat_vendeur_valide($id_vendeur){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM samm_cmd_details WHERE id_user=? AND statut=0 ");
			$req->execute(array($id_vendeur));	
			return $req;
		}

		public function verif_statut_achat_aff($id_cmd){
			$type="image";
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM wp_posts WHERE ID=? ");
			$req->execute(array($id_cmd));	
			return $req;
		}
		public function valide_achat_aff($id){
			$db=$this->dbConnect();
			$req=$db->prepare("UPDATE samm_gain_affiliate_salle SET valide=1 WHERE id=?");
			$req->execute(array($id));
			return $req;
		}

		public function valide_achat_vendeur($id){
			$db=$this->dbConnect();
			$req=$db->prepare("UPDATE samm_cmd_details SET statut=1 WHERE id=?");
			$req->execute(array($id));
			return $req;
		}


		public function update_user_account($new_gain_tempo,$new_gain_affiliation,$id_user){
			$db=$this->dbConnect();
			$req=$db->prepare("UPDATE samm_utilisateurs SET gain_tempo=?, gain_affiliation=? WHERE id=?");
			$req->execute(array($new_gain_tempo,$new_gain_affiliation,$id_user));
			return $req;
		}	

		public function update_infos_user($nom,$email,$telephone,$adresse,$id_client){
			$db=$this->dbConnect();
			$req=$db->prepare('UPDATE samm_utilisateurs SET nom= ?, email= ?, telephone= ?, adresse= ? WHERE id=?');
			$req->execute(array($nom,$email,$telephone,$adresse,$id_client));
			return $req;
		}

		public function update_pass_user($nouveau_pass,$id_client){
			$db=$this->dbConnect();
			$req=$db->prepare('UPDATE samm_utilisateurs SET pass= ? WHERE id=?');
			$req->execute(array($nouveau_pass,$id_client));
			return $req;
		}

		public function demande_retrait($type_user,$id_user,$montant_retrait,$telephone,$details_retrait,$date_demande,$heure_demande,$temps){
			$db=$this->dbConnect();
			$req=$db->prepare('INSERT INTO `samm_retrait`(`type_user`,`id_user`, `montant_retrait`, `telephone`, `details_retrait`, `date_demande`, `heure_demande`, `temps`) VALUES (?,?,?,?,?,?,?,?)');
			$req->execute(array($type_user,$id_user,$montant_retrait,$telephone,$details_retrait,$date_demande,$heure_demande,$temps));
			return $req;
		}

		public function add_produits($id_user,$id_produit,$temps){
			$db=$this->dbConnect();
			$req=$db->prepare('INSERT INTO `samm_produits`(`id_user`, `id_produit`, `temps`) VALUES (?,?,?)');
			$req->execute(array($id_user,$id_produit,$temps));
			return $req;
		}

		public function search_account_tempo($email){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_utilisateurs_tempo WHERE email=? ');
			$req->execute(array($email));
			$count = $req->rowCount();
			return $count;
		}

		public function info_account_tempo($email){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_utilisateurs_tempo WHERE email=? ');
			$req->execute(array($email));
			return $req; 
		}

		public function search_ref_parrain($ref_parrain){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_utilisateurs_tempo WHERE ref_affiliation=? ');
			$req->execute(array($ref_parrain));
			$count = $req->rowCount();
			return $count;
		}


		public function reg_affiliation_tempo($temps,$nom,$email,$telephone,$adresse,$date_inscription,$mp1){

			$db=$this->dbConnect();
			$req=$db->prepare('INSERT INTO `samm_utilisateurs_tempo`(`temps`,`nom`, `email`, `telephone`, `adresse`, `date_inscription`, `pass`) VALUES (?,?,?,?,?,?,?)');
			$req->execute(array($temps,$nom,$email,$telephone,$adresse,$date_inscription,$mp1));
			return $req;
		}

		public function info_account_tempo_id($id){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_utilisateurs_tempo WHERE id=? ');
			$req->execute(array($id));
			return $req;
		}

		public function valide_reg_affiliation_tempo($id){
			$db=$this->dbConnect();
			$req=$db->prepare('UPDATE samm_utilisateurs_tempo SET valide= 1 WHERE id=?');
			$req->execute(array($id));
			return $req;
		}

		public function info_account_tempo_noval($email,$mp1){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_utilisateurs_tempo WHERE email=? AND pass=? AND valide=0');
			$req->execute(array($email,$mp1));
			return $req;
		}
		public function add_shop_details($nom_commercial,$email,$telephone,$adresse,$description,$id_user){
			$db=$this->dbConnect();
			$req=$db->prepare('UPDATE samm_utilisateurs SET nom_boutique = ?, email_boutique=?, telephone_boutique=?, adresse_boutique=?, description_boutique=?, statut_boutique=? WHERE id=?');
			$req->execute(array($nom_commercial,$email,$telephone,$adresse,$description,'1',$id_user));
			return $req;
		}
		public function find_id_slug($slug){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM wp_posts WHERE post_name=? ');
			$req->execute(array($slug));	
			return $req;
		}		
		public function find_my_all_prod($id_user){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_produits WHERE id_user=? ');
			$req->execute(array($id_user));	
			return $req;
		}

		public function find_marchand_by_prod_id($product_id){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_produits WHERE id_produit=? ');
			$req->execute(array($product_id));	
			return $req;
		}

		public function reg_cmd_par_marchand($id_user,$product_id,$order_id,$samm_prod_ref,$quantite,$commission,$nom_produit,$adresse){
			setlocale (LC_TIME, 'fr_FR.UTF8');
			setlocale (LC_TIME, 'fr_FR');
			setlocale (LC_TIME, 'fr');
			$temps=time();
			$date=htmlspecialchars(date('d-M-Y/H:i'));

			$db=$this->dbConnect();
			$req=$db->prepare('INSERT INTO `samm_cmd_details`(`id_user`,`wc_prod_id`,`wc_order_id`, `samm_prod_ref`,`quantite`,`commission`,`nom_produit`, `client_info`, `date`) VALUES (?,?,?,?,?,?,?,?,?)');
			$req->execute(array($id_user,$product_id,$order_id,$samm_prod_ref,$quantite,$commission,$nom_produit,$adresse,$date));
			return $req;
		}

		public function update_nbr_vente_par_produit($new_nbr_vente,$product_id){
			$db=$this->dbConnect();
			$req=$db->prepare('UPDATE samm_produits SET nbr_vente = ? WHERE id=?');
			$req->execute(array($new_nbr_vente,$product_id));
			return $req;
		}

		public function update_admin_reglage($com_aff,$com_vend){
			$db=$this->dbConnect();
			$req=$db->prepare('UPDATE samm_admin_details SET commission_affilie = ?, commission_vendeur=? WHERE id=1');
			$req->execute(array($com_aff,$com_vend));
			return $req;
		}
		public function get_samm_admin_details(){
			$db=$this->dbConnect();
			$req=$db->prepare('SELECT * FROM samm_admin_details WHERE id=1 ');
			$req->execute();	
			return $req;
		}

	}

    class pagination_affiliation{	
    	 
                  
		private function dbConnect(){
			require_once ABSPATH . '/wp-load.php';

			global $wpdb;
			$bds=json_decode(json_encode($wpdb->dbname));
			$bdp=json_decode(json_encode($wpdb->dbpassword));
			$bdu=json_decode(json_encode($wpdb->dbuser));

			$option = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
			);
			try{
				$db=new PDO("mysql:host=localhost;dbname=".$bds,$bdu,$bdp, $option);
				return $db;
			}  
			catch(PDOException $e){
				die('erreur:'. $e->getMessage());
			}
		}

        public function compter_produit_affiliation_user(){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM wp_wc_product_meta_lookup ORDER BY product_id DESC");
			$req->execute();	
			return $req;
		}

        public function compter_statistique_affiliation_user(){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM samm_affiliate_prod_link ORDER BY id DESC");
			$req->execute();	
			return $req;
		}

        public function compter_user_affiliation1(){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM samm_utilisateurs WHERE type=1 ORDER BY id DESC");
			$req->execute();
			return $req;
		}

		public function compter_user_affiliation2(){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM samm_utilisateurs WHERE type=2 ORDER BY id DESC");
			$req->execute();
			return $req;
		}

		public function compter_user_affiliation_tempo(){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM samm_utilisateurs_tempo ORDER BY id DESC");
			$req->execute();
			return $req;
		}

		public function compter_demande_retrait_affiliation(){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM retrait_affiliation ORDER BY id DESC");
			$req->execute();
			return $req;
		}

		public function compter_historique_retrait($id_user){
			$db=$this->dbConnect();
			$req=$db->prepare("SELECT * FROM retrait_affiliation WHERE id_user=? AND status =1  ORDER BY id DESC ");
			$req->execute(array($id_user));	
			return $req;
		}

        

	}


 

?>