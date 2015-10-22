<?php

//inclusion des fichiers de fonction
include ("traitement.inc.php");
	
function inscriptionBDD() {	
	$bdd = new Connection();
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
	if(isset($_POST["etat_annuaire"])){
		$etat_annuaire=1;
	}else{
		$etat_annuaire=0;
	}
	
	//regarde si l'user existe deja
	$rqt_user = "SELECT pseudo FROM user WHERE pseudo='".$pseudo."'";
	$les_user = $bdd->select($rqt_user);
	//echo count($les_user);
	if (($nb_row = count($les_user)) == 1){
		//insertion dans la base de données du nouvel user
		$rqt_insert = "INSERT INTO user (pseudo, motdepasse, email, etat_validation, telephone, nom, prenom, adresse, etat_annuaire)
						VALUES ('".$pseudo."', '".$mdp."', '".$email."', 0, '".$tel."', '".$nom."', '".$prenom."', '".$adresse."', '".$etat_annuaire."' )";
		$req = $bdd->select($rqt_insert);
		
		//message de confirmation d'inscription et retour à l'accueil
		echo "<BR><BR><BR><BR><BR><BR><CENTER>Votre inscription a été prise en compte<BR>
				Vous allez être redirigé<CENTER>";
		echo'
			<script language="javascript" type="text/javascript">
				setTimeout("window.location=\'index.php?page=accueil\'", 3000);
			</script>';

	}else{
		//message de NON confirmation d'inscription et retour à l'accueil
		echo "<BR><BR><BR><BR><BR><BR><CENTER>Le membre existe dejà<BR>
				Vous allez être redirigé<CENTER><CENTER>";
		echo'
			<script language="javascript" type="text/javascript">
				setTimeout("window.location=\'index.php?page=inscription\'", 3000);
			</script>';
	}
}
?>