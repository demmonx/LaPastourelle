<?php 
header('Content-Type: text/html; charset=utf-8');
$cryptinstall="./cryptographp.fct.php";
require_once $cryptinstall; 
require_once("Connection.class.php");
require_once("traitement.inc.php");
$bdd = new Connection();
/* si tous les champs sont remplis */
if (($_POST["nom"] <> "") && ($_POST["message"] <> "")) {

	/* on vérifie le captcha */
	if (chk_crypt($_POST['code'])) {
	/* tout est correct -> ajout à la BDD */

		$addMess = $bdd->prepare("INSERT INTO livreor (date, nom, message, validation) 
				VALUES(?, ?, ?, 0)");
		$addMess->bindValue(1, date('Y-m-j'));
		$addMess->bindValue(2, $_POST['nom']);
		$addMess->bindValue(3, $_POST['message']);
		$addMess->execute();
		echo("Ajout effectué, redirection dans 3 secondes");
		//redirect("index.php?page=accueil",3);
		echo'
			<script language="javascript" type="text/javascript">
				setTimeout("window.location=\'index.php?page=accueil\'", 3000);
			</script>';
	
	} else {
		echo("Code incorrect, redirection dans 3 secondes");
		//redirect("index.php?page=livreOR",3);
		echo'
			<script language="javascript" type="text/javascript">
				setTimeout("window.location=\'index.php?page=accueil\'", 3000);
			</script>';
	}
	
 } else {
	echo("Tous les champs ne sont pas renseignés, redirection dans 3 secondes");
	//redirect("index.php?page=livreOR",3);
	echo'
			<script language="javascript" type="text/javascript">
				setTimeout("window.location=\'index.php?page=accueil\'", 3000);
			</script>';
}
?>
