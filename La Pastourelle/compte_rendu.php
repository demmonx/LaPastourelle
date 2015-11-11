<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass'])OR !verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {
	$compte_rendu =  getTexte('compte_rendu');
	if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
		if (isset($_POST['compteRendu'])) {
			//$req_up = $bdd->prepare('UPDATE texte SET texte= ? WHERE txt_page="compte_rendu"');
			$req_up = $bdd->select("UPDATE texte SET texte='" . $_POST['compteRendu'] . "' WHERE txt_page='compte_rendu'");
			//$req_up->execute(array($_POST['compteRendu']));
		
			//Affichage
			echo '<center>Modification effectuée</center>';
			echo "<center><a class='btn btn-link' href='index.php?page=compte_rendu'>Retour à la page précédente</a></center>";
			exit();
		}
		echo '<center><H2>ADMINISTRATION DU COMPTE RENDU</H2><BR><BR></center>';

		//recupération de l'actualite
		
		//nouvelle actualité
		
		echo "
				  <FORM METHOD=POST ACTION='index.php?page=compte_rendu' >
					Modifier le compte rendu : <BR>
					<textarea class='form-compteRendu' name='compteRendu' rows='15' cols='20'>".stripnl2br2((isset($compte_rendu[0]) ? $compte_rendu[0] : ""))."</textarea><br />
					<INPUT class='btn' type=\"submit\" value=\"Modifier\">
				  </FORM>";
	} else {
		echo '<DIV >';
		echo "<center><H2>COMPTE RENDU DE REUNION, D'ASSEMBLEE GENERALE, ...</H2></center>
			  </div>";

		//recupération des comptes rendu
		if ( isset($compte_rendu) != false){
			echo $compte_rendu[0];
		}
		
	}
}
?>