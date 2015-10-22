<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {
	echo "
	<center>
		<h1>Modification d'un texte</h1>
	</center>";
	
	//Modification d'un texte
	if (isset($_POST["texte0"]) AND isset($_POST["page"]) AND isset($_POST["page_lang"])) {
		//$bdd = connect_BD_PDO();
		if (isset($_POST["texte1"])) {
			$req_modifTxt = $bdd->select("UPDATE texte SET texte = '" . $_POST["texte0"] . "' 
										  WHERE txt_num = '0' AND txt_page = '" . $_POST["page"] . "' AND lang = '" . $_POST["page_lang"] ."'");
			//$req_modifTxt->execute(array($_POST["texte0"], $_POST["page"], $_POST["page_lang"]));
			$req_modifTxt2 = $bdd->select("UPDATE texte SET texte = '" . $_POST["texte1"] . "' 
										   WHERE txt_num = '1' AND txt_page = '" . $_POST["page"] . "' AND lang = '" .$_POST["page_lang"] . "'");
			//$req_modifTxt2->execute(array($_POST["texte1"], $_POST["page"], $_POST["page_lang"]));
		} else {
			$req_modifTxt = $bdd->select("UPDATE texte SET texte = '" . $_POST["texte0"] . "' 
										  WHERE txt_num = '0' AND txt_page = '" . $_POST["page"] . "' AND lang = '" . $_POST["page_lang"] ."'");
			//$req_modifTxt->execute(array($_POST["texte0"], $_POST["page"], $_POST["page_lang"]));
			
		}
		echo "<center>Modification effectuée<br />";
		//redirect("index.php?page=accueil",3);
		echo "<a class='btn btn-link' href='index.php?page=change_txt'>Revenir à la page précédente</a></center>";
		exit();
	}?>
	<CENTER><BR><BR>
	<form name="formS" METHOD ="POST" action="index.php?page=change_txt">
		<label for="page_lang">Choisissez la langue :</label>
		<?php
			//Affichage du drapeau correspondant
			for ($i=0; $i < count($allLang); $i++) {
				if ($allLang[$i]['lang'] == $_SESSION['lang'] ) {
					echo '<input type="radio" name="page_lang" value="'.$allLang[$i]['lang'].'" checked="checked"/>';
				} else {
					echo '<input type="radio" name="page_lang" value="'.$allLang[$i]['lang'].'" />';
				}
				if(!file_exists('image/lang/'.$allLang[$i]['lang'].'.png')) {
					echo "<img class='ssBordure' src='image/lang/inc.png' width='19' height='12' /></label>&nbsp&nbsp";
				} else {
					echo "<img class='ssBordure' src='image/lang/".$allLang[$i]['lang'].".png' width='19' height='12' /></label>&nbsp&nbsp";
				}
			}?>
		<br/><br/>
		<label for="page_txt">Choissez la page :</label>
		<select name="page_txt" class="select_lang_txt">
			<?php
			//Recupération des pages
			$req_allPage = $bdd->select("SELECT DISTINCT txt_page FROM texte WHERE txt_page != 'compte_rendu'");
			$allPage = $req_allPage->fetchAll();
			//Affichage du drapeau correspondant
			for ($i=0; $i < count($allPage); $i++) {	
				echo "<option>".ucfirst(strtolower(trim($allPage[$i]['txt_page'])))."</option>";
			}?>
		</select><br /><br />
		<INPUT class="btn" type="submit" value="Sélectionner">
	</form>
	</CENTER><hr /><?php
	
	
	if (isset($_POST["page_txt"]) and isset($_POST["page_lang"])){
		$page_txt = $_POST["page_txt"];
		$page_lang = $_POST["page_lang"];
		echo "<p style='text-align:center;'><b>Page : </b>".$_POST["page_txt"]."&nbsp&nbsp&nbsp&nbsp<b>Langue : </b><img class='ssBordure' src='image/lang/".$_POST["page_lang"].".png' width='19' height='12' /></p>";
		$req_selectTxt = $bdd->select("SELECT texte FROM texte WHERE txt_page ='" .$page_txt ."' AND lang='" .$page_lang ."' LIMIT 0, 2");
		//$req_selectTxt->execute(array($page_txt, $page_lang));
		$texte = $req_selectTxt->fetchAll();
		echo '<CENTER>
		<FORM METHOD="POST" action="index.php?page=change_txt">';
			if ($page_txt == "Theatre" OR $page_txt == "Danse" OR $page_txt == "Ecole" OR $page_txt == "Historique") {
				echo '<label for="texte0">Titre</label>';
				//echo '<TEXTAREA name="texte0" rows=1 cols=100 wrap=soft style="text-align:center;">'.$texte[0]['texte'].'</TEXTAREA><br />';
				echo "<input type=\"text\" name=\"texte0\">";
				echo '<label for="texte1">Texte</label><br/>';
				//echo '<TEXTAREA name="texte1" rows=40 cols=100 wrap=soft>'.$texte[1]['texte'].'</TEXTAREA><br />';
				echo "<input type=\"text\" name=\"texte1\">";
			} else {
				echo '<label for="texte0">Titre</label><br/>';
				//echo '<TEXTAREA name="texte0" rows=1 cols=100 wrap=soft style="text-align:center;">'.$texte[0]['texte'].'</TEXTAREA><br />';
				echo "<input type=\"text\" name=\"texte0\">";
			}
			echo '<BR>
			<input type="hidden" name="page" value="'.$page_txt.'">
			<input type="hidden" name="page_lang" value="'.$page_lang.'">
			<INPUT class="btn btn-info" TYPE=SUBMIT VALUE="Enregistrer la modification">
		</FORM></CENTER>';
	}
	echo "<BR><BR><CENTER><A class='btn btn-link' HREF='index.php?page=page_administrateur'>Retour à la page précédente</A></CENTER>";
}?>
