<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass'])OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {
	include ("upload.php");
	if ( isset($_FILES['fichier_choisi'])and isset($_POST["repertoire"]) and isset($_POST["nom"]) and isset($_POST["page_lang"])) {
		transfert();
		$_POST["photo"] = "";
	}
	?> 
	<br><br><br>
	<CENTER>
		<form name="formulaire" method="POST" enctype="multipart/form-data" action="index.php?page=change_img_act">
			<label for='page_lang'>Choisissez la langue : </label><?php
				//Affichage du drapeau correspondant
				for ($i=0; $i < count($allLang); $i++) {
					if ($allLang[$i]['lang'] == $_SESSION['lang'] ) {
						echo '<input type="radio" name="page_lang" value="'.$allLang[$i]['lang'].'" checked="checked"/>';
					} else {
						echo '<input type="radio" name="page_lang" value="'.$allLang[$i]['lang'].'" />';
					}
					if(!file_exists('image/lang/'.$allLang[$i]['lang'].'.png')) {
						echo "<label for=page_lang><img src='image/lang/inc.png' width='19' height='12' /></label>&nbsp&nbsp";
					} else {
						echo "<label for=page_lang><img src='image/lang/".$allLang[$i]['lang'].".png' width='19' height='12' /></label>&nbsp&nbsp";
					}
				}?>
				<br /><br />
			<label for='photo'>Choisissez une photo : </label>
			<select name="photo">
				<option>danse</option>
				<option>theatre</option>
			</select>
			<INPUT type="submit" value="Sélectionner"><br><?php
			if (isset($_POST["photo"]) and !empty($_POST["photo"]) and isset($_POST["page_lang"])) {
				echo '<br>Photo choisie : <b>'.$_POST["photo"].'</b><br><br>
			<input type="hidden" name="repertoire" value="actualite">
			<input type="hidden" name="nom" value="'.$_POST["photo"].'">
			Fichier : <input type="file" name="fichier_choisi" size="90">
			<br><i>**L\'image doit être de type jpg (ex : image.jpg)**</i>
			<br><br>
			<input type="submit" name="envoyer" value="Enregistrer ce fichier">
			';
			}
			?>
		</form>
		<br><br>
		<A class="btn btn-link" HREF="index.php?page=adminActualite">Retour à la page précédente</A>
	</CENTER><?php
}?>