<?php
// TODO recoder cette page
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "	<center>
				Vous ne pouvez pas accéder à ces pages sans être connecté en tant qu'administrateur<br />				Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
			</center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {
	//Récupération de toutes les langues disponibles
	$req_allLang = $bdd->select("SELECT DISTINCT lang FROM texte");	$allLang = $req_allLang->fetchAll();
	//Suppression d'une langue
	if (isset($_POST['page_lang']) AND isset($_POST['choix']) AND $_POST['choix'] == "1") {
		//Pour supprimer une faille de sécurité (si un personne met fr comme $_POST, alors qu'il n'y a pas le drapeau pour cette manipulation)		if ($_POST['page_lang'] == "fr") {
			echo "<center>Vous ne pouvez pas supprimer la langue française du site<br />";
			echo "<a class='btn btn-link' href='index.php?page=adminTrad'>Revenir à la page précédente</a></center>";
			exit();
		} else {
			//Suppression SQL de la langue
			supprLang($_POST['page_lang']);
			//Suppression du drapeau dans les fichiers
			unlink("image/lang/".$_POST['page_lang'].".png");
			echo "<center>Suppression effectuée<br />";
			echo "<a class='btn btn-link' href='index.php?page=adminTrad'>Revenir à la page précédente</a></center>";
			exit();
		}
	
	//Ajout d'une langue
	} else if ( isset($_FILES['fichier'])and isset($_POST["repertoire"]) and isset($_POST["nom"])) {
		//Transformation en un tableau normal
		for($i=0;$i<count($allLang);$i++){			$langs[] = $allLang[$i]['lang'];		}
		$extensions = array('.png');
		$extension = strrchr($_FILES['fichier']['name'], '.');
		if(!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau
			echo "<center>Ajout NON effectué car vous devez ajouter des fichiers de type png<br />
				  <a class='btn btn-link' href='index.php?page=adminTrad'>Retour à la page précédente</a></center>";
			exit();
		} else if (strlen($_POST["nom"]) != 2) { //Si les initiales ne comportent pas que 2 lettre
			echo "<center>Ajout NON effectué car l\'initial de la langue ne doit comporter que 2 lettre uniquement<br />
				  <a class='btn btn-link' href='index.php?page=adminTrad'>Retour à la page précédente</a></center>";
			exit();
		} else if (in_array($_POST["nom"], $langs)) {// Si l'initiale existe déjà
			echo "<center>Ajout NON effectué car l\'initial de la langue existe déjà dans la base de données<br />
				  <a class='btn btn-link' href='index.php?page=adminTrad'>Retour à la page précédente</a></center>";
			exit();
		} else {
			$dossier = $_POST["repertoire"];
			$fichier = $_POST["nom"].".png";
			if(move_uploaded_file($_FILES['fichier']['tmp_name'], $dossier . $fichier )){			
				//REDIMENSION APRES AJOUT PHP
				$image=$dossier . $fichier;
				$dimension=getimagesize($image);
				$coef_l=19;				$coef_h=12;
				$chemin = imagecreatefrompng($image);
				$nouvelle =imagecreatetruecolor ($coef_l, $coef_h);
				imagecopyresampled($nouvelle,$chemin,0,0,0,0,$coef_l,$coef_h,$dimension[0],$dimension[1]);
				imagejpeg($nouvelle,$image);
				imagedestroy ($chemin);				
				//Ajout SQL d'une nouvelle langue				ajoutLang($_POST["nom"]);
				//AFFICHAGE
				echo '<center>Ajout effectué</br>Maintenant il vous faut completer la traduction des textes, de la boutique, des liens , de la revue de presse ainsi que les traductions annexes (menus, boutons...).</center>';
			} else {
				echo '<center>Ajout non effectué</center>';
			}
			echo "<center><a class='btn btn-link' href='index.php?page=adminTrad'>Retour à la page précédente</a></center>";
			exit();
		}
	//Modification du drapeau de la langue
	} else if ( isset($_FILES['fichier_chang'])and isset($_POST["repertoire_chang"]) AND isset ($_POST['page_lang_chang'])) {
		$extensions = array('.png');
		$extension = strrchr($_FILES['fichier_chang']['name'], '.');
		if(!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau
			echo "<center>Ajout NON effectué car vous devez ajouter des fichiers de type png<br />
				  <a class='btn btn-link' href='index.php?page=adminTrad'>Retour à la page précédente</a></center>";
			exit();
		} else {			//Si il ya le fichier	
			if(file_exists('image/lang/'.$_POST['page_lang_chang'].'.png')) {
				unlink('image/lang/'.$_POST['page_lang_chang'].'.png');
			}
			$dossier = $_POST["repertoire_chang"];
			$fichier = $_POST['page_lang_chang'].".png";
			if(move_uploaded_file($_FILES['fichier_chang']['tmp_name'], $dossier . $fichier )){
				//REDIMENSION APRES AJOUT PHP
				$image=$dossier . $fichier;
				echo $image;
				$dimension=getimagesize($image);
				$coef_l=19;
				$coef_h=12;
				$chemin = imagecreatefrompng($image);
				$nouvelle =imagecreatetruecolor ($coef_l, $coef_h);
				imagecopyresampled($nouvelle,$chemin,0,0,0,0,$coef_l,$coef_h,$dimension[0],$dimension[1]);
				imagejpeg($nouvelle,$image);
				imagedestroy ($chemin);
				//AFFICHAGE
				echo '<center>Modification effectuée</br></center>';
			} else {
				echo '<center>Modification non effectuée</center>';
			}
			echo "<center><a class='btn btn-link' href='index.php?page=adminTrad'>Retour à la page précédente</a></center>";
			exit();
		}
	//Affichage et Modification de la traduction
	} else if (isset($_POST['page_lang']) AND isset($_POST['choix']) AND $_POST['choix'] == "0") {
		//Récupération de l'ensemble des traductions annexes
		$req_tradFR = $bdd->select("SELECT * FROM tradannexe WHERE lang= 'fr'" );
		$tradFR = $req_tradFR->fetchAll();
		$req_allTrad = $bdd->select("SELECT * FROM tradannexe WHERE lang='" . $_POST['page_lang'] . "'" );
		//$req_allTrad->execute(array($_POST['page_lang']));
		$allTrad = $req_allTrad->fetchAll();		
		//Enregistrement effectif de la modification
		if (isset($_POST['suppr']) AND $_POST['suppr']==1) {
			for ($i = 0; $i<count($tradFR); $i++) {
				$req_enreg = $bdd->select("UPDATE tradannexe										   SET valeurTrad ='" . $_POST[$tradFR[$i]['nomTrad']] ."'										   WHERE lang= '" .$_POST['page_lang']."' AND nomTrad = '".$tradFR[$i]['nomTrad']."'" );
				//$req_enreg->execute(array($_POST[$tradFR[$i]['nomTrad']], $_POST['page_lang'], $tradFR[$i]['nomTrad']));
			}
			echo "<center>Modification effectuée<br />
				  <a class='btn btn-link' href='index.php?page=adminTrad'>Retour à la page précédente</a></center>";
			exit(0);
		}
		//Affichage du formulaire de modification?>
		<center>			<h1>				Traduisez les mots ou expression dans la langue suivante : 
				<img class="ssBordure" src="image/lang/<?php echo $_POST['page_lang'];?>.png" width='19' height='12' />			</h1>
		<form action="index.php?page=adminTrad" method="POST">			<table>				<tr>					<th><img class="ssBordure" src="image/lang/fr.png" width='19' height='12' /></th>					<th><img class="ssBordure" src="image/lang/<?php echo $_POST['page_lang'];?>.png" width='19' height='12' /></th>				</tr>
				<tr>					<input type="hidden" name="page_lang" value="<?php echo $_POST['page_lang']; ?>" />				</tr>
				<tr>					<input type="hidden" name="choix" value="0" />				</tr>
				<tr>					<input type="hidden" name="suppr" value="1" />				</tr>				<?php
				for ($i =0; $i<count($allTrad); $i++) {?>
					<tr><?php //Affichage en plus
						//if ($i ==0) { echo "<br /><br /><hr />Accueil"; }
						?>
						<td width="400px">							<label for="<?php echo stripslashes($tradFR[$i]['nomTrad']);?>">								<?php echo stripslashes($tradFR[$i]['valeurTrad']); ?>							</label>						</td>
						<td>							<input size="50" type="type" name="<?php echo stripslashes($tradFR[$i]['nomTrad']);?>" value="<?php echo stripslashes($allTrad[$i]['valeurTrad']); ?>"/>						</td>
					</tr><?php
				}?>
			</table>
			<input class="btn" type="submit" value="Enregistrer" />
		</form><?php
		echo "<center><a class='btn btn-link' href='index.php?page=adminTrad'>Retour à la page précédente</a></center>";
	//Affichage par défaut, affichage des différentes catégories (modifier, ajouter, supprimer)
	} else {
		//Choix de la langue à modfier?>
		<center>			<h1>Modifier une traduction</h1>			<div class="identification">
			<form name="formS" METHOD ="POST" action="index.php?page=adminTrad">
				<label for="page_lang">Choisissez la langue à modifier : </label>
				<?php
				//Affichage du drapeau correspondant
				for ($i=0; $i < count($allLang); $i++) {
					echo '<input type="radio" name="page_lang" value="'.$allLang[$i]['lang'].'" />';
										if(!file_exists('image/lang/'.$allLang[$i]['lang'].'.png')) {
						echo "<img class='ssBordure' src='image/lang/inc.png' width='19' height='12' />&nbsp&nbsp";
					} else {
						echo "<img class='ssBordure' src='image/lang/".$allLang[$i]['lang'].".png' width='19' height='12' />&nbsp&nbsp";
					}
				}?>
				<INPUT type="hidden" name="choix" value="0">				<br /><br />				<INPUT class="btn" type="submit" value="Modifier"></center>
			</form>			</div><hr />						<?php
		//Formulaire d'ajout d'une langue?>
		<center>			<h1>Ajout d'une langue</h1>		</center>		<div class="identification">
			<form class="form-horizontal" action="index.php?page=adminTrad" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="repertoire" value="image/lang/" />				<div class="control-group">
					<label class="control-label" for="nom">Initiales de la langue</label>					<div class="controls">
						<input name="nom" type = "text" />(2 lettres)<br />					</div>				</div>				<div class="control-group">
					<label class="control-label" for="fichier">Drapeau</label>					<div class="controls">
						<input type="file" name="fichier" size="20" />(image.png)					</div>				</div>				<center><input class="btn" type="submit" name="envoyer" value="Enregistrer la nouvelle langue"></center>
			</form>		</div>		<hr />		<?php
		//Choix de la langue à supprimer
		echo "<center><h1>Suppression d'une langue</h1>";?>		<div class="identification">
			<form name="formS" METHOD ="POST" action="index.php?page=adminTrad">
				<label class="control-label" for="page_lang">Choisissez la langue à supprimer : </label>
				<?php
				//Affichage du drapeau correspondant
				if (count($allLang) != 1) {
					for ($i=0; $i < count($allLang); $i++) {
						if ($allLang[$i]['lang'] != "fr" ) {
							echo '<input type="radio" name="page_lang" value="'.$allLang[$i]['lang'].'" />';
							if(!file_exists('image/lang/'.$allLang[$i]['lang'].'.png')) {
								echo "<img class='ssBordure' src='image/lang/inc.png' width='19' height='12' />&nbsp&nbsp";
							} else {
								echo "<img class='ssBordure' src='image/lang/".$allLang[$i]['lang'].".png' width='19' height='12' />&nbsp&nbsp";
							}
						}
					}?>
					<INPUT type="hidden" name="choix" value="1">					<br /><br />					<INPUT class="btn" type="submit" value="Supprimer">				<?php
				} else {
					echo "<br /><br /><b>Aucune langue à supprimer</b>";
				}?>
			</form>		</div>		<hr />		<?php
		//Formulaire de changement du drapeau?>
		<center><h1>Modifier le drapeau d'une langue</h1></center>		<div class="identification">
			<form class="form-horizontal" METHOD ="POST" action="index.php?page=adminTrad" enctype="multipart/form-data">
				<input type="hidden" name="repertoire_chang" value="image/lang/" />				<div class="control-group">
					<label class="control-label" for="page_lang_chang">Choisissez la langue : </label>						<?php
						if (count($allLang) != 1) {
							for ($i=0; $i < count($allLang); $i++) {
								echo '<input type="radio" name="page_lang_chang" value="'.$allLang[$i]['lang'].'" />';
								if(!file_exists('image/lang/'.$allLang[$i]['lang'].'.png')) {
									echo "<img class='ssBordure' src='image/lang/inc.png' width='19' height='12' />&nbsp&nbsp";
								} else {
									echo "<img class='ssBordure' src='image/lang/".$allLang[$i]['lang'].".png' width='19' height='12' />&nbsp&nbsp";
								}
							}
						}?>				</div>				<div class="control-group">					<label class="control-label" for="fichier_chang">Drapeau</label>					<input type="file" name="fichier_chang" size="20" />(image.png)				</div>				<center><input class="btn" type="submit" name="envoyer" value="Changer le drapeau"></center>
			</form>		</div>		<?php
		echo "<A class='btn btn-link' HREF=index.php?page=page_administrateur>Retour à la page précédente</A></CENTER>";
	}
}?>
