<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {
	$rqt = "SELECT * FROM boutique WHERE pd_num = ".$_GET["num"];
	//$result = mysql_query($rqt);
	$result = $bdd->select($rqt);
	//$ligne = mysql_fetch_object($result);
	
	foreach ($result as $ligne) {
	
		//Recupération du nom et Suppression du fichier
		$req_recupNom = $bdd->select("SELECT img_adr FROM image WHERE img_num ='" .$ligne['pd_img'] ."' AND img_page = 'boutique'");
		//$req_recupNom->execute(array($ligne->pd_img));
		$recupNom = $req_recupNom->fetchAll();
		unlink($recupNom[0]["img_adr"]);
		
		//Suppression de la base de donnée
		$rqt_prod="DELETE FROM boutique WHERE pd_num ='".$ligne['pd_num']."'";
		$rqt_txt="DELETE FROM texte WHERE txt_num ='".$ligne['pd_txt']."' AND txt_page='boutique'";
		$rqt_img="DELETE FROM image WHERE img_num='".$ligne['pd_img']."' AND img_page='boutique'";
		
		//mysql_query($rqt_prod);
		//mysql_query($rqt_txt);
		//mysql_query($rqt_img);
		
		$rep_prod = $bdd->select($rqt_prod);
		$rep_txt = $bdd->select($rqt_txt);
		$rep_img = $bdd->select($rqt_img);
		
		echo '<center><h3>Suppression effectuée.<br /> Attention la suppression est effective dans toutes les langues</h3><br />';
		echo "<a class='btn btn-link' href='index.php?page=boutique'>Revenir à la page précédente</a></center>";
		exit();
	}
}?>