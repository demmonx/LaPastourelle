<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {
	//Choix de la langue <étape 1>
	if (!isset($_POST['page_lang'])) {?>
		<center>
			<h1>Administration de l'actualité</h1>
		</center>
		<center>
			<FORM METHOD=POST ACTION='index.php?page=adminActualite'>
				<label for='page_lang'>Choisissez la langue : </label><?php
				//Affichage du drapeau correspondant
				echo "<table class='table' id='tableau'><tr>";
				for ($i=0; $i < count($allLang); $i++) {
					if ($allLang[$i]['lang'] == $_SESSION['lang'] ) {
						echo '<td><input type="radio" name="page_lang" value="'.$allLang[$i]['lang'].'" checked="checked"/></td>';
					} else {
						echo '<td><input type="radio" name="page_lang" value="'.$allLang[$i]['lang'].'" /></td>';
					}
					if(!file_exists('image/lang/'.$allLang[$i]['lang'].'.png')) {
						echo "<td><img class='ssBordure' src='image/lang/inc.png' width='19' height='12' /></td>";
					} else {
						echo "<td><img class='ssBordure' src='image/lang/".$allLang[$i]['lang'].".png' width='19' height='12' /></td>";
					}
					
				}echo '</tr></table>';?>
				<label>
					<input class="btn" type="submit" value="Selectionner" />
				</label>
			</form>
		</center><?php
	//Modification de l'actualité <étape 3>
	} else if (isset($_POST['lieu_theatre']) AND isset($_POST['date_theatre']) AND isset($_POST['heure_theatre']) AND isset($_POST['act_theatre'])
			 AND (isset($_POST['lieu_danse']) AND isset($_POST['date_danse']) AND isset($_POST['heure_danse']) AND isset($_POST['act_danse'])) ) {
		//$bdd = connect_BD_PDO();
		$req_modifT = $bdd->prepare('UPDATE actualite SET act_lieu=?, act_date=?, act_heure=?, act_txt=?
									 WHERE act_type="theatre" AND lang = ?');
		$req_modifT->execute(array($_POST['lieu_theatre'], $_POST['date_theatre'], $_POST['heure_theatre'], $_POST['act_theatre'], $_POST['page_lang']));

		$req_modifD = $bdd->prepare('UPDATE actualite SET act_lieu=?, act_date=?, act_heure=?, act_txt=?
									WHERE act_type="danse" AND lang = ?');
		$req_modifD->execute(array($_POST['lieu_danse'], $_POST['date_danse'], $_POST['heure_danse'], $_POST['act_danse'], $_POST['page_lang']));
		//Affichage
		echo '<center><h3>Modification effectuée</h3>';
		echo "<a class='btn btn-link' href='index.php?page=adminActualite'>Retour à la page précédente</a></center>";
		exit();
	//Formulaire de modification de l'actualité <étape 2>
	} else {
		//récupération de l'actualité du théatre
		$tab_theatre = recup_act("theatre");
		$cpt=0;
		
		$lieu_theatre = $tab_theatre[$cpt];
		$cpt++;
		$date_theatre = $tab_theatre[$cpt];
		$cpt++;
		$heure_theatre = $tab_theatre[$cpt];
		$cpt++;
		$texte_theatre = $tab_theatre[$cpt];
		$cpt++;
		$img_theatre = recup_img($tab_theatre[$cpt], "actualite");
		
		$texte_theatre = str_replace("<br />", "", $texte_theatre);
		
		//récupération de l'actualité de la danse
		$tab_danse = recup_act("danse");
		$cpt=0;
		
		$lieu_danse = $tab_danse[$cpt];
		$cpt++;
		$date_danse = $tab_danse[$cpt];
		$cpt++;
		$heure_danse = $tab_danse[$cpt];
		$cpt++;
		$texte_danse = $tab_danse[$cpt];
		$cpt++;
		$img_danse = recup_img($tab_danse[$cpt], "actualite");

		$texte_danse = str_replace("<br />", "", $texte_danse);
		
		echo "<DIV id=\"accueil\"><center><H2>ADMINISTRATION DES ACTUALITES</H2><BR>"; 
		echo "Langue choisie : <img src='image/lang/".$_POST['page_lang'].".png' width='19' height='12' />";
		//Message d'information
		echo "<p style='text-align:center'>Tous les champs sont optionnels.<br />Vous pouvez donc n'avoir qu'une seule actualité (uniquement théatre par exemple)";
		//nouvelle actualité
		echo "
		<FORM METHOD='POST' ACTION='index.php?page=adminActualite'>
			<br /><br />Modifier l'actualité pour le <B>théatre</B> : <BR><BR>
			<TABLE>
				<TR>
					<TD>Lieu</TD>
					<TD><INPUT TYPE=text NAME=\"lieu_theatre\" VALUE=\"".$lieu_theatre."\" SIZE=26></TD>
				</TR>
				<TR>
					<TD>Date</TD>
					<TD><INPUT TYPE=text NAME=\"date_theatre\" VALUE=\"".$date_theatre."\" SIZE=26></TD>
				</TR>
				<TR>
					<TD>Heure</TD>
					<TD><INPUT TYPE=text NAME=\"heure_theatre\" VALUE=\"".$heure_theatre."\" SIZE=26></TD>
				</TR>
				<TR>
					<TD>Description</TD>
					<TD><TEXTAREA rows=\"4\" name=\"act_theatre\" >".$texte_theatre."</TEXTAREA><BR><BR></TD>
				</TR>
			</TABLE>
			<BR>Modifier l'actualite pour la <B>danse</B> : <BR><BR>
			<TABLE>
				<TR>
					<TD>Lieu</TD>
					<TD><INPUT TYPE=text NAME=\"lieu_danse\" VALUE=\"".$lieu_danse."\" SIZE=26></TD>
				</TR>
				<TR>
					<TD>Date</TD>
					<TD><INPUT TYPE=text NAME=\"date_danse\" VALUE=\"".$date_danse."\" SIZE=26></TD>
				</TR>
				<TR>
					<TD>Heure</TD>
					<TD><INPUT TYPE=text NAME=\"heure_danse\" VALUE=\"".$heure_danse."\" SIZE=26></TD>
				</TR>
				<TR>
					<TD>Description</TD>
					<TD><TEXTAREA rows=\"4\" name=\"act_danse\" >".$texte_danse."</TEXTAREA><BR><BR></TD>
				</TR>
			</TABLE>
			<input type='hidden' name='page_lang' value='".$_POST['page_lang']."' />
			<input NAME='btn_modif' type='submit' value='Modifier' />
		
		</FORM>
		</CENTER>
		</DIV> ";
			  
		echo "<CENTER><A class='btn btn-link' HREF=index.php?page=change_img_act>Modifier les images</A></CENTER><BR>";
	}		
} 
?>