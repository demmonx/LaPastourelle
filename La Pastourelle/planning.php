<?php
/* Suppression de la page adminPlanning.php
 * Les actions administrateurs sont présents sur la page planning.php ici présente avec une restriction d'accès bien sur
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 */
if (false) {
	echo "<center>Suite à une erreur de conception, cette page est en construction. <br />Elle sera mise en ligne le  mardi 12 avril au soir.<br />Merci de votre compréhension</center>";
	exit();
}
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	exit(0);
} else {
	if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
		//Suppression dans la base de données
		if (isset($_GET['date']) AND isset($_GET['lieu'])) {
			//$bdd = connect_BD_PDO();
			//récupération du membre a supprimer
			$date = $_GET["date"];
			$lieu = $_GET["lieu"];
			
			//traitement de la date pour l'inserer de la forme aaaa/mm/jj pour pouvoir les classer par date
			$morceau_date = explode ("/", $date);
			$jour = $morceau_date[0];
			$mois = $morceau_date[1];
			$annee = $morceau_date[2];
			$date = $annee."/".$mois."/".$jour;
			//Suppression dans la BD
			$req_suppr = $bdd->select("DELETE FROM planning WHERE pl_date ='" .$date ."' AND pl_lieu ='".$lieu."'");
			//$req_suppr->execute(array($date, $lieu));
		
		//Ajout dans la base de données
		} else if (isset($_POST['date']) AND isset($_POST['lieu']) AND isset($_POST['jour']) AND isset($_POST['musiciens'])){
			//$bdd = connect_BD_PDO();
			//récupération du membre a ajouter
			$nom_jour = $_POST["jour"];
			$date = $_POST["date"];
			$lieu = $_POST["lieu"];
			$musiciens = $_POST["musiciens"];
			
			//traitement de la date pour l'inserer de la forme aaaa/mm/jj pour pouvoir les classer par date
			$morceau_date = explode ("/", $date);
			$jour = $morceau_date[0];
			$mois = $morceau_date[1];
			$annee = $morceau_date[2];
			$date = $annee."/".$mois."/".$jour;
			$req_ajout = $bdd->select("INSERT INTO planning VALUES ('".$nom_jour."','".$date."','".$lieu."','".$musiciens."')");
			//$req_ajout->execute(array($nom_jour, $date, $lieu, $musiciens));
			 echo "<BR><BR><CENTER>Date ajoutée au planning<br /><br />";
			 echo "<a class='btn btn-link' href='index.php?page=planning'>Revenir à la page précédente</a></CENTER>";
			 exit(0);
		}?>
		<SCRIPT LANGUAGE="JavaScript">
		/* On crée une fonction de verification */
		function verifForm(formulaire)
		{
		temps = formulaire.date.value;
		var place = temps.indexOf("/",1);
		var point = temps.indexOf("/",place+1);
		if(formulaire.date.value == "" || formulaire.lieu.value == "" || formulaire.musiciens.value == "") /* on detecte si saisie33 est vide */
			alert('Remplissez correctement tous les champs'); /* dans ce cas on lance un message d'alerte */
		else
			if ((place == 2)&&(temps.length == 10)&&(point == 5))
				formulaire.submit(); /* sinon on envoi le formulaire */
			else
				alert('Entrez une date valide!!');
		}
		</SCRIPT><?php
		/* Titre admin*/
		echo "<DIV id=\"accueil\"><CENTER><H2>ADMINISTRATION DU PLANNING</H2>";
		echo "<BR><BR>";
		/* Formulaire d'ajout d'un évenement*/
		echo "
		<div class='identification'>
			<FORM class='form-horizontal' METHOD=POST ACTION=\"index.php?page=planning\">
				<div class='control-group'>
					<label class='control-label'>Jour</label>
					<div class='controls'>
						<INPUT type=text name=\"jour\">
					</div>
				</div>
				<div class='control-group'>
					<label class='control-label'>Date (jj/mm/aaaa)</label>
					<div class='controls'>
						<INPUT type=text name='date'>
					</div>
				</div>
				<div class='control-group'>
					<label class='control-label'>Lieu</label>
					<div class='controls'>
						<INPUT type=text name='lieu'>
					</div>
				</div>
				<div class='control-group'>
					<label class='control-label'>Musiciens</label>
					<div class='controls'>
						<INPUT type=text name='musiciens'>
					</div>
				</div>
				<BUTTON class='btn' NAME='btn_val' type='button' value='' onClick='verifForm(this.form)'>Ajouter</BUTTON><BR><BR>
			</FORM>
		</div>";
	} else {
		/* Titre membre*/
		echo "<DIV id=\"accueil\"><CENTER><H2>PLANNING DES SORTIES ET REPETITIONS A VENIR</H2>";
		echo "<BR><BR>";
	}
	
	//récupération des info dans la BD et traitement
	$tab_planning = recup_planning();
	$cpt = 0;
	$taille_tab = count($tab_planning);
	
	/** tableau du planning */
	echo "
		<TABLE class='table table-bordered table-striped'>
			<TR>
				<TH>JOUR</TH>
				<TH>DATE</TH>
				<TH>LIEU</TH>
				<TH>MUSICIENS</TH>";
			if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
				echo "<TH colspan='3'>Actions</TH>";
			} //Ajout des colones de suppression
			echo "</TR>";
	$adminOK = false;
	if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
		$adminOK = true;
	}
	while ($cpt < $taille_tab){
		$un_jour = $tab_planning[$cpt];
		$cpt++;
		$une_date = $tab_planning[$cpt];
		$cpt++;
		$un_lieu = $tab_planning[$cpt];
		$cpt++;
		$un_musiciens = $tab_planning[$cpt];
		$cpt++;
		
		//traitement de la date pour l'afficher de la forme jj/mm/aaaa
		$morceau_date = explode ("/", $une_date);
		$jour = $morceau_date[2];
		$mois = $morceau_date[1];
		$annee = $morceau_date[0];
		$une_date = $jour."/".$mois."/".$annee;
		
		echo "<TR><TD>".$un_jour."</TD><TD>".$une_date."</TD><TD>".$un_lieu."</TD><TD>".$un_musiciens."</TD> ";
		if ($adminOK) {
			echo "<TD><A class='btn btn-link' HREF=\"index.php?page=planning&date=".$une_date."&lieu=".$un_lieu."\">Supprimer </A> </TD>
			      <TD><A class='btn btn-link' HREF=\"index.php?page=modifDatePlanning&date=".$une_date."&lieu=".$un_lieu."\"> Modifier</A></TD>";
		}
	}
	
	echo "</CENTER></TABLE></DIV>";
}
?>