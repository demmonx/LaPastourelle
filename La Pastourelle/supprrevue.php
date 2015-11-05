<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	echo'
			<script language="javascript" type="text/javascript">
				setTimeout("window.location=\'index.php?page=accueil\'", 3000);
			</script>';
	
	exit(0);
} else {
	$rqt = "SELECT * FROM revue_presse WHERE num_presse = ".$_GET["num"];
	//$result = mysql_query($rqt);
	//$ligne = mysql_fetch_object($result);
	
	$result = $bdd->select($rqt);
	foreach($result as $ligne) {
	
		//Recupération du nom et Suppression du fichier
		$req_recupNom = $bdd->select("SELECT img_adr FROM image WHERE img_num ='" .$ligne['presse_img'] ."' AND img_page = 'revue_presse'");
		//$req_recupNom->execute(array($ligne->presse_img));
		$recupNom = $req_recupNom->fetchAll();
		unlink($recupNom[0]['img_adr']);
		
		//Suppression base de données
		$rqt_prod="DELETE FROM revue_presse WHERE num_presse = ".$ligne['num_presse'];
		$rqt_txt="DELETE FROM texte WHERE txt_num =".$ligne['presse_txt']." AND txt_page=\"revue_presse\"";
		$rqt_img="DELETE FROM image WHERE img_num=".$ligne['presse_img']." AND img_page=\"revue_presse\"";
		
		//mysql_query($rqt_prod);
		//mysql_query($rqt_txt);
		//mysql_query($rqt_img);
		
		$rep_prod = $bdd->select($rqt_prod);
		$rep_txt = $bdd->select($rqt_txt);
		$rep_img = $bdd->select($rqt_img);
		
		echo '<h3><center>Suppression effectuée</center></h3>';
		redirect("index.php?page=revuedepresse", 3);
	}
} ?>