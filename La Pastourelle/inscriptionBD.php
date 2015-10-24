<?php

//inclusion des fichiers de fonction
include ("traitement.inc.php");
header("Content-Type: text/html; charset=utf-8");	
function inscriptionBDD() {	
	$bdd = connect_BD_PDO();
	//connexion à la base de donnée
	//connect_BD();
						

	//récupération des données du formulaire
	$pseudo = $_POST["pseudo"];
	$mdp = sha1($_POST["mdp"]);
	$email = $_POST["email"];
	$tel = $_POST["tel"];
	$nom = strtoupper($_POST["nom"]);
	$prenom = ucfirst($_POST["prenom"]);
	$adresse = $_POST["adresse"];
	$etat_annuaire = 0;
	if(isset($_POST["etat_annuaire"]) && $_POST["etat_annuaire"] == "true"){
		$etat_annuaire=1;
	}
	
	//regarde si l'user existe deja
	$rqt_user = "SELECT pseudo FROM user WHERE pseudo=?";
	$les_user = $bdd->prepare($rqt_user);
	$les_user->bindValue(1, $pseudo, PDO::PARAM_STR);
	$les_user->execute();
	
	if ($les_user->rowCount() == 0){
		//insertion dans la base de données du nouvel user
		//$rqt_insert = "INSERT INTO user (pseudo, motdepasse, email, etat_validation, telephone, nom, prenom, adresse, etat_annuaire)
		//				VALUES ('".$pseudo."', '".$mdp."', '".$email."', 0, '".$tel."', '".$nom."', '".$prenom."', '".$adresse."', '".$etat_annuaire."' )";
	  //$req = $bdd->select($rqt_insert);
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