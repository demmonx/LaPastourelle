<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {

	//récupération des données du formulaire
	$psd = $_POST["psd"];
	$Nmdp = $_POST["Nmdp"];
	$email = $_POST["email"];
	$tel = $_POST["tel"];
	$nom = $_POST["nom"];
	$prenom = $_POST["prenom"];
	$adresse = $_POST["adresse"];
	if(isset($_POST["etat_annuaire"])){
		$etat_annuaire=1;
	}else{
		$etat_annuaire=0;
	}

	//regarde si le mot de passe et correct
	if ($Nmdp!=""){
		if($_SESSION['pseudo'] != $psd){
			$rqt_upd_annuaire = "UPDATE annuaire SET pseudo=\"".$psd."\" WHERE pseudo=\"".$_SESSION['pseudo']."\"";
			//mysql_query($rqt_upd_annuaire);
			$rep_upd_annuaire = $bdd->select($rqt_upd_annuaire);
		}
	
		//insertion dans la base de données du nouvel user
		$rqt_update = "UPDATE user SET pseudo=\"".$psd."\", motdepasse=\"".sha1($Nmdp)."\", email=\"".$email."\", 
							           telephone=\"".$tel."\", nom=\"".$nom."\", prenom=\"".$prenom."\", adresse=\"".$adresse."\", etat_annuaire=\"".$etat_annuaire."\"
									WHERE pseudo=\"".$_SESSION['pseudo']."\"";
		//mysql_query($rqt_update);
		$rep_update = $bdd->select($rqt_update);

	}else if($Nmdp==""){
		if($_SESSION['pseudo'] != $psd){
			$rqt_upd_annuaire = "UPDATE annuaire SET pseudo=\"".$psd."\" WHERE pseudo=\"".$_SESSION['pseudo']."\"";
			//mysql_query($rqt_upd_annuaire);
			$rep_upd_annuaire = $bdd->select($rqt_upd_annuaire);
		}
	
		//insertion dans la base de données du nouvel user
		$rqt_update = "UPDATE user SET pseudo=\"".$psd."\", email=\"".$email."\", 
							           telephone=\"".$tel."\", nom=\"".$nom."\", prenom=\"".$prenom."\", adresse=\"".$adresse."\", etat_annuaire=\"".$etat_annuaire."\"
									WHERE pseudo=\"".$_SESSION['pseudo']."\"";

		//mysql_query($rqt_update);
		$rep_update = $bdd->select($rqt_update);
	}		
	
	//message de confirmation d'inscription et retour à l'accueil
	echo "<BR><BR><BR><BR><BR><BR><CENTER>Votre modification a été prise en compte<BR>
			<B>Veuillez vous reconnecter</B><BR>
			Vous allez être rediriger<CENTER>";?>
	<script language="javascript" type="text/javascript">
		setTimeout("window.location='index.php?page=deconnexion'", 3000);
	</script><?php
}
?>


