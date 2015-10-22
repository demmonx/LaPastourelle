<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else { 
	$bdd = connect_BD_PDO();
    if (isset($_POST["adresse"]) and isset($_POST["nom"]) and isset($_POST["texte"]) AND isset($_FILES['fichier_choisi'])){
		//Modification d'un lien -> On le supprimer puis on le réajoute
		if (isset($_POST["modif"]) AND $_POST["modif"] == 1 AND $_POST["lien"]) {
			$req_recupInfoslien = $bdd->prepare('SELECT * FROM lien_ext WHERE lien = ? AND lang = ?');
			$req_recupInfoslien->execute(array($_POST["lien"], $_SESSION['lang']));
			$infosLien=$req_recupInfoslien->fetchAll();
			if (!empty($_FILES['fichier_choisi']['name'])) { //Il veut modifier l'image
				//Récupération du nom de l'image puis suppression dans le dossier
				$req_recupImg = $bdd->prepare('SELECT img_adr FROM image WHERE img_num = ?'); $req_recupImg->execute(array($infosLien[0]['lien_img']));
				$recupImg = $req_recupImg->fetchAll();
				unlink($recupImg[0]['img_adr']);
				$req_delLien3 = $bdd->prepare('DELETE FROM image WHERE img_num = ? AND img_page = "lien"'); $req_delLien3->execute(array($infosLien[0]['lien_img']));
			}
			//Suppression base de donnée
			$req_delLien1 = $bdd->prepare('DELETE FROM lien_ext WHERE lien = ? AND lang = ? '); $req_delLien1->execute(array($infosLien[0]['lien'], $_SESSION['lang']));
			$req_delLien2 = $bdd->prepare('DELETE FROM texte WHERE txt_num = ? AND txt_page = "lien" AND lang = ?'); $req_delLien2->execute(array($infosLien[0]['lien_txt'], $_SESSION['lang']));
		}
		//Ajout d'un nouveau lien (ou re ajout si supprimé dans le if au dessus)
		$chemin = "0";
		if (!empty($_FILES['fichier_choisi']['name'])) { //On rajoute l'image si supprimé au dessus
			include("upload.php");
			$chemin = new_lien();
		}
		if ($chemin != "-1"){
			//Récupération de toutes les langues disponibles
			$bdd=connect_BD_PDO();
			$req_allLang = $bdd->query("SELECT DISTINCT lang FROM texte");
			$allLang = $req_allLang->fetchAll();
			//Recherche du maximum de lien_img
			$req_max = $bdd->query('SELECT MAX(lien_img) FROM lien_ext');
			$max = $req_max->fetchAll();
			if (!isset($_POST["modif"]) OR $_POST["modif"] != 1) { $index=$max[0]['MAX(lien_img)']+1; } else { $index=$max[0]['MAX(lien_img)']; }
			//Recherche du maximum de id
			$req_max2 = $bdd->query('SELECT MAX(id) FROM lien_ext');
			$max2 = $req_max2->fetchAll();
			if (!isset($_POST["modif"]) OR $_POST["modif"] != 1) { $index2=$max2[0]['MAX(id)']+1; } else { $index2=$max2[0]['MAX(id)']; }
			//Ajout de l'image dans la table image
			$req_imgadd = $bdd->prepare('INSERT INTO image VALUES (?,"lien",?)');
			$req_imgadd->execute(array($index, $chemin));
			//Ajout du lien dans la table lien_ext
			for ($i = 0; $i < count($allLang); $i++) {
				if ($allLang[$i]['lang'] == $_SESSION['lang']) {
					$req_extadd = $bdd->prepare('INSERT INTO lien_ext VALUES (?,?,?,?,?,?)');
					$req_extadd->execute(array($index2, $allLang[$i]['lang'], $_POST["adresse"], $index, $index, $_POST["nom"]));
				} else {
					if (!isset($_POST["modif"]) OR $_POST["modif"] != 1) { //Si c'est un ajout donc on ajoute les traductions
						$req_extadd = $bdd->prepare('INSERT INTO lien_ext VALUES (?,?,?,?,?,"Traduction non faite")');
						$req_extadd->execute(array($index2, $allLang[$i]['lang'],$_POST["adresse"], $index, $index));
					}
				}
			}
			//Ajout du texte dans la table texte
			for ($i = 0; $i < count($allLang); $i++) {
				if ($allLang[$i]['lang'] == $_SESSION['lang']) {
					$req_txtadd = $bdd->prepare('INSERT INTO texte VALUES (?, "lien", ?, ?)');
					$req_txtadd->execute(array($index, $allLang[$i]['lang'], $_POST["texte"]));
				} else {
					$req_txtadd = $bdd->prepare('INSERT INTO texte VALUES (?, "lien", ?, "Traduction non faite")');
					$req_txtadd->execute(array($index, $allLang[$i]['lang']));
				}
			}
			$req_txtadd = $bdd->prepare('INSERT INTO texte VALUES (?, "lien", ?)');
			$req_txtadd->execute(array($index, $_POST["texte"]));
			echo '<center><h3>Ajout/Modification effectué(e)</h3></center>';
		} else {
			echo '<center><h3>Ajout/Modification non effectué(e)</h3></center>';
		}
		
	} else {
			$txt1[0]['lien'] = "";
			$txt1[0]['lien_nom'] = "";
			$txt2[0]['texte'] = "";
			if (isset($_GET['modif']) AND $_GET['modif'] = 1 AND isset($_GET['lien'])) { 
				$modif=1; $lien = $_GET['lien'];
				$req_lienModif = $bdd->prepare('SELECT * FROM lien_ext WHERE lien = ? AND lang = ?');
				$req_lienModif->execute(array($_GET["lien"], $_SESSION['lang']));
				$lienModif = $req_lienModif->fetchAll();
				$req_lienTxtModif = $bdd->prepare('SELECT texte FROM texte WHERE txt_num = ? AND txt_page="lien" AND lang = ?');
				$req_lienTxtModif->execute(array($lienModif[0]["lien_txt"], $_SESSION['lang']));
				$lienTxtModif = $req_lienTxtModif->fetchAll();
				$txt1 = $lienModif;
				$txt2 = $lienTxtModif;
			} else { $modif=0; $lien="";}
			if (isset($_POST["modif"]) AND $_POST["modif"] == 1) {
				echo '<CENTER><h1>Attention, vous modifiez un lien dans la langue suivante : <img src="image/lang/'.$_SESSION["lang"].'.png" width="19" height="12" /></h1>';
			} else {
				echo '<CENTER><h1>Attention, vous ajoutez un lien dans la langue suivante : <img src="image/lang/'.$_SESSION["lang"].'.png" width="19" height="12" /></h1>
				<br />Alors les autres langues auront le texte : "Traduction non faite"';
			}
	        echo '<BR><BR>
			<form name="formulaire" method="POST" enctype="multipart/form-data" action="index.php?page=ajout_lien">
                <TABLE>
					<TR>			
						<TD>Lien vers leur site : </TD>
						<TD>   <TEXTAREA name="adresse" rows=1 cols=50 wrap=hard>'.$txt1[0]['lien'].'</TEXTAREA></TD>
					</TR>
					<TR>
						<TD>Nom du lien : </TD>
						<TD>        <TEXTAREA name="nom"     rows=1 cols=50 wrap=hard>'.$txt1[0]['lien_nom'].'</TEXTAREA></TD>
					</TR>
					<TR>
						<TD>Description du lien : </TD>
						<TD><TEXTAREA name="texte"   rows=4 cols=50 wrap=hard>'.$txt2[0]['texte'].'</TEXTAREA></TD>
					</TR>';
				if (!isset($_POST["modif"]) OR $_POST["modif"] != 1) {
					echo '
						<TR>
							<TD>Fichier : </TD>
							<TD><input type="file" name="fichier_choisi" size="66"></TD>
						</TR>
						<TR>
							<TD/>
							<TD><i>**Ne pas oublier de mettre la photo**</i></TD>
						</TR> ';
				}
				echo '
					</TABLE>
						<input type="hidden" name="modif" value="'.$modif.'" />
						<input type="hidden" name="lien" value="'.$lien.'" />
						<INPUT TYPE=SUBMIT VALUE="Valider">
	        </FORM>
			</CENTER>';
			
	}
    echo "
		<BR><BR>
		<CENTER>
			<A class='btn btn-link' HREF='index.php?page=lien'>Retour à la page précédente</A>
		</CENTER>";
}?>