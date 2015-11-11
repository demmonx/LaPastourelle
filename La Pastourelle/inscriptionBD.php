<?php

//inclusion des fichiers de fonction
require_once ("traitement.inc.php");
header("Content-Type: text/html; charset=utf-8");	
function inscriptionBDD($var) {	
		$bdd = new Connection();
	//connexion à la base de donnée
					

	//récupération des données du formulaire
	$pseudo = $var["pseudo"];
	$mdp = sha1($var["mdp"]);
	$email = $var["email"];
	$tel = $var["tel"];
	$nom = strtoupper($var["nom"]);
	$prenom = ucfirst($var["prenom"]);
	$adresse = $var["adresse"];
	$etat_annuaire = 0;
	if(isset($var["etat_annuaire"]) && $var["etat_annuaire"] == "true"){
		$etat_annuaire=1;
	}
	
	//regarde si l'user existe deja
	$rqt_user = "SELECT pseudo FROM tuser WHERE pseudo=?";
	$les_user = $bdd->prepare($rqt_user);
	$les_user->bindValue(1, $pseudo, PDO::PARAM_STR);
	$les_user->execute();
	
	if ($les_user->rowCount() == 0){
		//insertion dans la base de données du nouvel user
	  $sql = "INSERT INTO user (pseudo, motdepasse, email, etat_validation, niveau, telephone, nom, prenom, adresse, etat_annuaire)
						VALUES (:pseudo, :pass, :mail, 0, 'membre', :tel, :nom, :prenom, :adresse, :annuaire)";
	  $stmt = $bdd->prepare($sql);
	  $stmt->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
	  $stmt->bindValue(':pass', $mdp, PDO::PARAM_STR);
	  $stmt->bindValue(':mail', $email, PDO::PARAM_STR);
	  $stmt->bindValue(':tel', $tel, PDO::PARAM_INT);
	  $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
	  $stmt->bindValue(':prenom', $prenom, PDO::PARAM_STR);
	  $stmt->bindValue(':adresse', $adresse, PDO::PARAM_STR);
	  $stmt->bindValue(':annuaire', $etat_annuaire, PDO::PARAM_INT);
	  $stmt->execute();
		
		//message de confirmation d'inscription et retour à l'accueil
		echo "Votre inscription a été prise en compte";
	}else{
		//message de NON confirmation d'inscription et retour à l'accueil
		echo "Le membre existe déjà";
	}
	$les_user->closeCursor();
}
?>