<?php 
$cryptinstall="./cryptographp.fct.php";
include $cryptinstall; 
include("Connection.class.php");
include("traitement.inc.php");
$bdd = new Connection();
/* si tous les champs sont remplis */
if (($_POST["nom"] <> "") && ($_POST["message"] <> "")) {

	/* on vérifie le captcha */
	if (chk_crypt($_POST['code'])) {
	/* tout est correct -> ajout à la BDD */

		$addMess = $bdd->select('INSERT INTO livreor VALUES("","' . date('Y-m-j') . '", "' .$_POST['nom']. '","' .$_POST['message'].'", "")');
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
