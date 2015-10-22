<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accéder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </CENTER>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {
	//récupération des données du formulaire
	$psd = $_POST["psd"];
	$mdp = sha1($_POST["mdp"]);
	$email = $_POST["email"];
	$tel = $_POST["tel"];
	$nom = $_POST["nom"];
	$prenom = $_POST["prenom"];
	$adresse = $_POST["adresse"];

	
	//regarde si l'user existe deja
	$rqt_user = "SELECT pseudo FROM user WHERE pseudo=\"".$psd."\"";
	//$les_user = mysql_query($rqt_user);
	$les_user = $bdd->select($rqt_user);

	 
	$rqt_insert ="INSERT INTO user 
                            VALUES ('".$psd."','".$mdp."','administrateur','".$email."',1,'".$tel."','".$nom."','".$prenom."','".$adresse."',0)";
	//mysql_query($rqt_insert);
	$rep_insert = $bdd->select($rqt_insert);
		
	
    echo "<CENTER><h3>ajout effectué</h3><BR/><BR/><BR/><BR/><A class='btn btn-link' HREF='index.php?page=change_admin'>retour</A></CENTER>";
}	
?>