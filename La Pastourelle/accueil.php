<?php
//récupération du titre de la page
$titre = recup_titre("accueil");

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

//Récupération des textes annexes de traduction pour cette zone
$req_recupAcc = $bdd->prepare("SELECT valeurTrad FROM tradannexe WHERE lang = ? AND nomTrad LIKE 'accueil%' ");
$req_recupAcc->execute(array($_SESSION['lang']));
$recupAcc = $req_recupAcc->fetchAll();

$oneActu = false;
if ( (empty($lieu_danse) AND empty($date_danse) AND empty($heure_danse) AND empty($texte_danse))
   OR(empty($lieu_theatre) AND empty($date_theatre) AND empty($heure_theatre) AND empty($texte_theatre)) ) {

	$oneActu = true;

}
?>

<div class="clear"></div>
	<?php 
		$phrase = recup_phrasejour();
		echo "<marquee scrollAmount=\"4\">Phrase de la semaine : ". $phrase . " </marquee>";
		echo "<CENTER><H1>$titre</H1></CENTER>";
	?>
	<div class="box grid_6">
		<?php echo "<img src=\" $img_danse \"><br /><br />";
			  if (!empty($lieu_danse)) { echo "<strong>" . $recupAcc[0]['valeurTrad'].' '.$lieu_danse. "</strong>";}
			  if (!empty($date_danse)) { echo "<strong>" . $recupAcc[1]['valeurTrad'].' '.$date_danse. "</strong>"; }
			  if (!empty($heure_danse)) { echo "<strong>" . $recupAcc[2]['valeurTrad'].' '.$heure_danse. "</strong>";}?><br/>
		<?php if (!empty($texte_danse)) { echo "<span class=\"comment\">$texte_danse</span>"; }?>
		<br />
	</div>
	<div class="box grid_6">
		<?php echo "<img src=\" $img_theatre \"><br /><br />";
			  if (!empty($lieu_theatre)) { echo "<strong>" . $recupAcc[0]['valeurTrad'].' '.$lieu_theatre."</strong>";}
			  if (!empty($date_theatre)) { echo "<strong>" . $recupAcc[1]['valeurTrad'].' '.$date_theatre."</strong>"; }
			  if (!empty($heure_theatre)) { echo "<strong>" . $recupAcc[2]['valeurTrad'].' '.$heure_theatre . "</strong>";}?><br />
		<?php if (!empty($texte_theatre)) { echo "Pièce jouée : <span class=\"comment\">$texte_theatre</span>"; }?>
		<br />
	</div>
	<div class="clear"></div>
<?php
//echo "<CENTER><div id=\"accueil\" ><CENTER><H1>".$titre."</H1></CENTER>";
//if (!empty($lieu_theatre) OR !empty($date_theatre) OR !empty($heure_theatre) OR !empty($texte_theatre)) {
//	echo '<TABLE CELLSPACING=5 ';
//			if ($oneActu) { echo 'ALIGN=center>'; } else { echo 'ALIGN=right>'; }
//	echo '<TR><TD><IMG SRC="'.$img_theatre.'" WIDTH=350></TD></TR><TR><TD align=left><B>';
//			if (!empty($lieu_theatre)) { echo $recupAcc[0]['valeurTrad'].' '.$lieu_theatre.' ';}
//			if (!empty($date_theatre)) { echo $recupAcc[1]['valeurTrad'].' '.$date_theatre.' '; }
//			if (!empty($heure_theatre)) { echo $recupAcc[2]['valeurTrad'].' '.$heure_theatre;}
//	echo '</B><CENTER><BR>';
//			if (!empty($texte_theatre)) { echo $texte_theatre; }
//	echo '<CENTER></TD></TR>
//		  </TABLE>';
//}

//if (!empty($lieu_danse) OR !empty($date_danse) OR !empty($heure_danse) OR !empty($texte_danse)) {
//	echo '<TABLE CELLSPACING=5 ';
//			if ($oneActu) { echo 'ALIGN=center>'; } else { echo 'ALIGN=left>'; }
//	echo '<TR><TD><IMG SRC="'.$img_danse.'" WIDTH=350></TD></TR><TR><TD align=left><B>';
//			if (!empty($lieu_danse)) { echo $recupAcc[0]['valeurTrad'].' '.$lieu_danse.' ';}
//			if (!empty($date_danse)) { echo $recupAcc[1]['valeurTrad'].' '.$date_danse.' '; }
//			if (!empty($heure_danse)) { echo $recupAcc[2]['valeurTrad'].' '.$heure_danse;}
//	echo '</B><CENTER><BR>';
//			if (!empty($texte_danse)) { echo $texte_danse; }
//	echo '<CENTER></TD></TR>
//		  </TABLE>';
//}
//echo "</DIV></CENTER>";
?>