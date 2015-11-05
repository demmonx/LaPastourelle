<?php
$adminOK = false;
if(isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	$adminOK = true;
}
if ( isset($_FILES['fichier_chang'])and isset($_POST["repertoire_chang"])) {
	$extensions = array('.pdf');
	$extension = strrchr($_FILES['fichier_chang']['name'], '.');
	if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
	{
		echo '<center>Ajout NON effectué car vous devez ajouter des fichiers de type pdf<br />
			  <a href="index.php?page=boutique">Retour à la page précédente</a></center>';
		exit();
	} else {
		$dossier = $_POST["repertoire_chang"];
		$fichier = "bondecommande-".$_SESSION['lang'].".pdf";
		//Si il ya le fichier	
		if(file_exists($dossier . $fichier)) {
			unlink($dossier . $fichier);
		}
		if(move_uploaded_file($_FILES['fichier_chang']['tmp_name'], $dossier . $fichier )){
			//AFFICHAGE
			echo '<center>Modification effectuée</br></center>';
		} else {
			echo '<center>Modification non effectuée</center>';
		}
		echo '<center><a href="index.php?page=boutique">Retour à la page précédente</a></center>';
		exit();
	}
}

//Récupération des textes annexes de traduction pour cette zone
	$req_recupBout = $bdd->prepare("SELECT valeurTrad FROM tradannexe WHERE lang = ? AND nomTrad LIKE 'boutique%' ");
	$req_recupBout->execute(array($_SESSION['lang']));
	$recupBout = $req_recupBout->fetchAll();
//récupération des liens dans la BD et traitement
$tab_infoPd = recup_infoPd();
$cpt = 0;
$taille_tab = count($tab_infoPd);
//récupération du titre de la page
$titre = recup_titre("boutique");
echo "<DIV id=\"liens\"> <CENTER><H1>".$titre."</H1>
	  ".$recupBout[0]['valeurTrad']." : ";
if (file_exists("document/bondecommande-".$_SESSION['lang'].".pdf")) {
	echo "<A class='btn btn-link' HREF=\"document/bondecommande-".$_SESSION['lang'].".pdf\" target=_blank>".$recupBout[1]['valeurTrad']."</A><BR>";
} else {
	echo "--------------";
}
echo "<BR><BR><TABLE class='table table-bordered' width=100% RULES=\"rows\" FRAME=\"void\" BORDER=\"3px\" CELLSPACING=\"10px\" BORDERCOLORLIGHT=\"white\">";

while ($cpt < $taille_tab )
{
	//affichage des différentes informations
	echo "<TR>";
	$l_img = recup_img($tab_infoPd[$cpt], "boutique");
	$cpt++;
	$le_nom = $tab_infoPd[$cpt];
	$cpt++;
	$la_desc = recup_texte($tab_infoPd[$cpt], "boutique");
	$cpt++;
	$le_prix = $tab_infoPd[$cpt];
	$cpt++;
	$le_num = $tab_infoPd[$cpt];
	$cpt++;
	if ($l_img != false){
		echo "<TD><A HREF=\"".$l_img."\" target=_blank><img class='ssBordure' SRC=\"".$l_img."\" HEIGHT=\"75\" WIDTH=\"98\" BORDER=\"5px\"/></A> </TD>";
	}
	else
	{
		echo "<TD> </TD>";
	}
	echo "<TD>".$le_nom."</A></TD>";
	echo "<TD>".$la_desc."</TD>";
	echo "<TD>".$le_prix."</TD>";
	if ($adminOK) {
		echo '<TD><A class="btn btn-link" HREF=index.php?page=modif_boutique&num='.$le_num.'>Modifier</A></TD>';
		echo '<TD><A class="btn btn-link" HREF=index.php?page=supprboutique&num='.$le_num.'>Supprimer</A></TD>';
	}
	echo "</TR><TR></TR>"; 
}
echo "</TABLE></DIV>";
if ($adminOK) {?>
	<CENTER><A class="btn btn-link" HREF="index.php?page=ajout_boutique">Ajouter un produit</A><br><br><hr>
	<h1>Modifier le bon de commande</h1></CENTER>
	<form name="formS" METHOD ="POST" action="index.php?page=boutique" enctype="multipart/form-data">
		<input type="hidden" name="repertoire_chang" value="document/" />
		<label for="fichier">Bon de commande</label>
			<input type="file" name="fichier_chang" size="20" />(fichier.pdf uniquement)<br /><br />
		<center><input class="btn btn-info" type="submit" name="envoyer" value="Enregistrer"><br /></center>
	</form>
	<?php
}
?>