<script src="js/sorttable.js" type="text/javascript"></script>

<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </CENTER>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {
	if (isset($_GET['pseudo'])) {
		//$bdd = connect_BD_PDO();
		$req_del = $bdd->select("DELETE FROM annuaire WHERE pseudo='".$_GET['pseudo']."'");
		//$req_del->execute(array($_GET['pseudo']));
		
		//Affichage
		echo '<center>Suppression effectuée</center>';
		echo "<center><a class='btn btn-link' href='index.php?page=annuaire'>Retour à la page précédente</a></center>";
		exit();
	}
	
	//récupération des liens dans la BD et traitement
	if (isset($_POST['aRechercher'])) {
		$tab_membre = recup_annuaire($_POST['aRechercher'],$_POST['typeRecherche'],0);
	} else if (isset($_POST['aTrier']) ) {
		$tab_membre = recup_annuaire($_POST['aTrier'],"",1);
	} else {
		$tab_membre = recup_annuaire("","",2);
	}
	$cpt = 0;
	$taille_tab = count($tab_membre);?>
	<DIV id="liens"><CENTER><H2>ANNUAIRE</H2></center>
	
	
	<form class="form-inline" action="index.php?page=annuaire" method="POST">
		<input class="span2" type="text" name="aRechercher" />
		<!-- Ajout d'une liste déroulante pour optimiser la recherche -->
			<div class="input-append">
				<SELECT class="span2" name="typeRecherche">
					<option>Nom
					<option>Prenom
					<option>Pseudo
					<option>E-mail
					<option>Telephone
					<option>Adresse
				</SELECT>
				<input type="submit" value="Rechercher" class="btn" />
			</div>
	</form><?php
	if (isset($_POST['aRechercher'])) {
		echo "<a class='btn btn-link' href='index.php?page=annuaire'><img src='image/maison.png' alt='Voir la liste complète' width='20' height='20' style='margin-top: 10px;'></a>";
	}?>
	<p>Cliquez sur le titre de la colonne choisie (ex : Nom) pour ordonner la liste</p>
	<?php
	echo "<TABLE class='sortable table table-bordered table-striped' CELLPADDING=5px WIDTH=860px style='font-size:13px'>
			<TR>
				<H3>
					<TH>Nom</TH>
					<TH>Prénom</TH>
					<TH>Pseudo</TH>
					<TH>E-mail</TH>
					<TH>Téléphone</TH>
					<TH>Adresse</TH>"; 
	if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
		  echo "<TH><center>Action</center></TH>";
	}
	echo	  "</H3></TR><br/></center>";
	$adminOk = false;
	if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
		$adminOk = true;
	}
	while ($cpt < $taille_tab )
	{
		$le_pseudo = $tab_membre[$cpt];
		$cpt++;
		$l_email = $tab_membre[$cpt];
		$cpt++;
		$le_telephone = $tab_membre[$cpt];
		$cpt++;
		$le_nom = $tab_membre[$cpt];
		$cpt++;
		$le_prenom = $tab_membre[$cpt];
		$cpt++;
		$l_adresse = $tab_membre[$cpt];
		$cpt++;
		$l_etat_annuaire = $tab_membre[$cpt];
		$cpt++;
		if ($l_etat_annuaire==1){
			echo "<TR>
					<TD><B>".$le_nom."</B></TD>";
			echo "	<TD><B>".$le_prenom."</B></TD>";
			echo "	<TD>".$le_pseudo."</TD>";
			echo "	<TD>".$l_email."</TD>";
			echo "	<TD>".$le_telephone."</TD>";
			echo "	<TD>".$l_adresse."</TD>";
			if ($adminOk) {
				echo "<TD><A class='btn btn-link' HREF='annuaire.php?pseudo=".$le_pseudo."'>Supprimer</A></TD>";
			}
			echo "</TR>";
		}
	}
	
	echo "</TABLE></DIV>";
	if ($taille_tab == 0) {
		echo "<center>Aucun membre ne correspond à votre recherche</center>";
	}
}
?>