<?php 
$cryptinstall="./cryptographp.fct.php";
include $cryptinstall; 
include("inscriptionBD.php");
include("Connection.class.php");

/* si tous les champs sont remplis */
if (($_POST["prenom"] <> "") && ($_POST["nom"] <> "")&& ($_POST["pseudo"] <> "")&& ($_POST["mdp"] <> "")&& ($_POST["adresse"] <> "")&& ($_POST["tel"] <> "")&& ($_POST["email"] <> "")) {
	/* TODO vérifier l'adresse email */
	
	/* on vérifie le captcha */
	if (chk_crypt($_POST['code'])) {
	/* tout est correct -> inscription BD */
	inscriptionBDD();
	} else {
		echo("Code incorrect, redirection dans 3 secondes");
		//redirect("index.php?page=inscription",3);
		echo'
			<script language="javascript" type="text/javascript">
				setTimeout("window.location=\'index.php?page=accueil\'", 3000);
			</script>';
	}
	
} else {
	echo("Tous les champs ne sont pas renseignés, redirection dans 3 secondes");
	//redirect("index.php?page=inscription",3);
	echo'
			<script language="javascript" type="text/javascript">
				setTimeout("window.location=\'index.php?page=inscription\'", 3000);
			</script>';
}

?>
