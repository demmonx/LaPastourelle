<?php
@session_start ();
require_once 'traitement.inc.php';
if (! isset ( $_SESSION ['pseudo'] ) or ! isset ( $_SESSION ['pass'] ) or ! verifLo ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect ( "index.php?page=accueil", 3 );
	exit ( 0 );
} else {
	
	$prenom = filter_input ( INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS );
	$nom = filter_input ( INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS );
	$mdp = filter_input ( INPUT_POST, 'Nmdp', FILTER_SANITIZE_SPECIAL_CHARS );
	$mdp2 = filter_input ( INPUT_POST, 'mdp2', FILTER_SANITIZE_SPECIAL_CHARS );
	$adresse = filter_input ( INPUT_POST, 'adresse', FILTER_SANITIZE_SPECIAL_CHARS );
	$tel = filter_input ( INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS );
	$mail = filter_input ( INPUT_POST, 'email', FILTER_VALIDATE_EMAIL );
	
	/* si une erreur sur les champs */
	if (! $prenom || ! $nom || ! $mdp || ! $adresse || ! $tel || ! $mail) {
		// génération du tableau des erreurs
		$erreur = array (
				array () 
		);
		$erreur [0] [0] = $prenom;
		$erreur [0] [1] = "Le prénom est invalide";
		$erreur [1] [0] = $nom;
		$erreur [1] [1] = "Le nom est invalide";
		$erreur [2] [0] = ! isset ( $mdp ) || $mdp == "" || $mdp && $mdp2 ;
		$erreur [2] [1] = "Le mot de passe est invalide";
		$erreur [3] [0] = ! isset ( $mdp ) || $mdp == "" || $mdp == $mdp2;
		$erreur [3] [1] = "Les deux mots de passe sont différents";
		$erreur [4] [0] = $adresse;
		$erreur [4] [1] = "L'adresse est invalide";
		$erreur [5] [0] = $tel && is_numeric ( $tel ) && strlen ( $tel ) == 10;
		$erreur [5] [1] = "Le téléphone est invalide";
		$erreur [6] [0] = $mail;
		$erreur [6] [1] = "L'adresse mail est invalide";
		
		// Affichage de la première erreur trouvée
		for($i = 0; $i < count ( $erreur ); $i ++)
			if (! $erreur [$i] [0])
				exit ( $erreur [$i] [1] );
	}
	
	$etat_annuaire = 0;
	if (isset ( $_POST ["etat_annuaire"] ) && $_POST ["etat_annuaire"] == "true") {
		$etat_annuaire = 1;
	}
	$bdd = new Connection();
	$stmt = null;
	if ($mdp) {
		$mdp = sha1 ( $mdp );
		$sql = "UPDATE tuser SET motdepasse=:pass, email=:mail, telephone=:tel, nom=:nom, prenom=:prenom, adresse=:adresse, etat_annuaire=:annuaire WHERE id_membre=:id";
		$stmt = $bdd->prepare ( $sql );
		$stmt->bindValue ( ':pass', $mdp, PDO::PARAM_STR );
	} else {
		$sql = "UPDATE tuser SET email=:mail, telephone=:tel, nom=:nom, prenom=:prenom, adresse=:adresse, etat_annuaire=:annuaire WHERE id_membre=:id";
		$stmt = $bdd->prepare ( $sql );
	}
	
	$stmt->bindValue ( ':mail', $mail, PDO::PARAM_STR );
	$stmt->bindValue ( ':tel', $tel, PDO::PARAM_INT );
	$stmt->bindValue ( ':nom', $nom, PDO::PARAM_STR );
	$stmt->bindValue ( ':prenom', $prenom, PDO::PARAM_STR );
	$stmt->bindValue ( ':adresse', $adresse, PDO::PARAM_STR );
	$stmt->bindValue ( ':annuaire', $etat_annuaire, PDO::PARAM_INT );
	$stmt->bindValue ( ':id', $_SESSION ["id"], PDO::PARAM_INT );
	$stmt->execute ();
	echo "Votre compte a bien été modifié";
	// session_destroy();
}


