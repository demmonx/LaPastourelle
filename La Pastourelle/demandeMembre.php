<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass'])OR !verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accéder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	//redirect("index.php?page=accueil", 3);
	echo'
			<script language="javascript" type="text/javascript">
				setTimeout("window.location=\'index.php?page=accueil\'", 3000);
			</script>';
	exit(0);
} else {
	//$bdd = connect_BD_PDO();
	// Acceptation ou refus d'un message du livre d'or ou d'un membre*/
	if (isset($_GET['id']) AND isset($_GET['confirm'])) {
		//Refus d'un message ou d'un membre
		if ($_GET['confirm'] == 0) {
			if (isset($_GET['mb']) AND $_GET['mb'] == 1) { //Membre
				$delMess = $bdd->select("DELETE FROM user WHERE pseudo = '" . $_GET['id'] . "'");
			} else { //Message
				$delMess = $bdd->select("DELETE FROM livreOR WHERE id = '" . $_GET['id'] . "'");
			}
			//$delMess->execute(array($_GET['id']));
		//Acceptation d'un message ou d'un membre
		} else if ($_GET['confirm'] == 1) {
			if (isset($_GET['mb']) AND $_GET['mb'] == 1) { //Membre
				$modMess = $bdd->select("UPDATE user SET etat_validation = '1', niveau = 'membre' WHERE pseudo = '" . $_GET['id'] . "'");
			} else { //Message
				$modMess = $bdd->select("UPDATE livreor SET confirm = '1' WHERE id = '" . $_GET['id'] . "'");
			}
			//$modMess->execute(array($_GET['id']));
		}
	}
	// Message en attente de validation du livre d'or
	echo "
	<center>
		<h2>Messages du livre d'or en attente de validation</h2>";
	//$req_messNoValid = $bdd->query('SELECT * FROM livreor WHERE confirm = 0 ORDER BY date');
	$req_messNoValid = $bdd->select('SELECT * FROM livreor WHERE confirm = "0" ORDER BY date');
	$NBmessNoValid = count($req_messNoValid);
	if ($NBmessNoValid == 0) {
		echo "Il n'y a aucun message en attente
	</center>";
	} else {
		echo "
	<div id=\"liens\">
		<table class='table table-bordered' style='font-size:13px;'>";
		echo "
			<tr>";
		echo"
				<th>Date</th>
				<th>Nom</th>
				<th>Message</th>
				<th>+</th>
				<th>-</th>";
		echo "
			</tr>";
		foreach ($req_messNoValid as $row) { //$messNoValid = $req_messNoValid->fetch()) {
			echo "
			<tr>";
			echo"
				<td>".$row['date']."</td><td>".$row['nom']."</td>
				<td>".$row['message']."</td>";
			echo "
				<td>
					<a class='btn btn-link' href='index.php?page=page_administrateur&id=".$row['id']."&confirm=1'>Accepter</a>
				</td>";
			echo "
				<td>
					<a class='btn btn-link' href='index.php?page=page_administrateur&id=".$row['id']."&confirm=0'>Refuser</a>
				</td>";
			echo "
			</tr>";
		}
		echo "
		</table>
	</div>";
	//</center>";
	}
	// Membre en attente de validation
	echo "
	<center>
		<h2>Membres en attente de validation</h2>";
	//$req_membNoValid = $bdd->query('SELECT pseudo, email, telephone, nom, prenom, adresse FROM user WHERE etat_validation=0 ORDER BY nom');
	$req_membNoValid = $bdd->selectTableau('SELECT pseudo, email, telephone, nom, prenom, adresse
											FROM user
											WHERE etat_validation="0"
											ORDER BY nom');
	$NBmembNoValid = count($req_membNoValid); //->rowCount();
	if ($NBmembNoValid == 0) {
		echo "Il n'y a aucun membre en attente
	</center>";
	} else {
		echo "
	<div id=\"liens\">
		<table class='table table-bordered' whidth=860px style='font-size:13px;'>";
		echo "
			<tr>";
	echo"
				<th>Nom</th>
				<th>Prénom</th>
				<th>Pseudo</th>
				<th>Email</th>
				<th>Telephone</th>
				<th>Adresse</th>
				<th>+</th>
				<th>-</th>";
				echo "
			</tr>";
		foreach ($req_membNoValid as $row) { //$membNoValid = $req_membNoValid->fetch()) {
			echo "
			<tr>";
			echo"
				<td>".$row['nom']."</td>
				<td>".$row['prenom']."</td>
				<td>".$row['pseudo'] ."</td>
				<td>".$row['email']."</td>
				<td>".$row['telephone']."</td>
				<td>".$row['adresse']."</td>";
			echo "
				<td>
					<a class='btn btn-link' href='index.php?page=page_administrateur&id=".$row['pseudo']."&confirm=1&mb=1'>Accepter</a>
				</td>";
			echo "
				<td>
					<a class='btn btn-link' href='index.php?page=page_administrateur&id=".$row['pseudo']."&confirm=0&mb=1'>Refuser</a>
				</td>";
			echo "
			</tr>";
		}
		echo "
		</table>
	</div>
</center>";
	}
	/** membre à valider 
	echo "<DIV id=\"page_tab\"><CENTER> <H2> Membres en demande d'inscription </H2>  ";

	$tab_membre_aValider = recup_membre_valider();
	$cpt = 0;
	$taille_tab = count($tab_membre_aValider);
	
	echo "<DIV id=\"liens\"><TABLE WIDTH=860px>
		  <TR><H3><TH>Nom</TH><TH> </TH><TH>Prénom</TH><TH> </TH><TH>Pseudo</TH>
		  <TH> </TH><TH>E-mail</TH><TH> </TH><TH>Téléphone</TH>
		  <TH> </TH><TH>Adresse</TH></H3><TH> </TH><TH>+</TH></TR>";
	
	while ($cpt < $taille_tab )
	{
		$le_pseudo = $tab_membre_aValider[$cpt];
		$cpt++;
		$l_email = $tab_membre_aValider[$cpt];
		$cpt++;
		$le_telephone = $tab_membre_aValider[$cpt];
		$cpt++;
		$le_nom = $tab_membre_aValider[$cpt];
		$cpt++;
		$le_prenom = $tab_membre_aValider[$cpt];
		$cpt++;
		$l_adresse = $tab_membre_aValider[$cpt];
		$cpt++;
		echo "<TR><TD><B>".$le_nom."</B></TD>";
		echo "<TD>&nbsp; &nbsp;</TD>";
		echo "<TD><B>".$le_prenom."</B></TD>";
		echo "<TD>&nbsp; &nbsp;</TD>";
		echo "<TD>".$le_pseudo."</TD>";
		echo "<TD>&nbsp; &nbsp;</TD>";
		echo "<TD>".$l_email."</TD>";
		echo "<TD>&nbsp; &nbsp;</TD>";
		echo "<TD>".$le_telephone."</TD>";
		echo "<TD>&nbsp; &nbsp;</TD>";
		echo "<TD>".$l_adresse."</TD>";
		echo "<TD>&nbsp; &nbsp</TD>";
		echo "<TD><A HREF=\"supprMembre.php?pseudo=".$le_pseudo."\">Refuser</A></TD>";
		echo "<TD>&nbsp; &nbsp;</TD>";
		echo "<TD><A HREF=\"ajoutMembre.php?pseudo=".$le_pseudo."\">Valider</A></TD>";
		echo "</TR><TR></TR>";
	}
	echo "</TABLE></DIV>";*/
	
	/** membre deja valider */
	echo "
	<center>
		<H2>Membres déjà validés </H2>  ";
	
	$tab_membre = recup_membre();
	$cpt = 0;
	$taille_tab = count($tab_membre);
	
	echo "
	<DIV id=\"liens\">
		<TABLE class='table table-bordered' style='font-size:13px;'>
			<TR>
				<H3>
					<TH>Nom</TH>
					<TH>Prénom</TH>
					<TH>Pseudo</TH>
					<TH>E-mail</TH>
					<TH>Téléphone</TH>
					<TH>Adresse</TH>
				</H3>
			</TR>";
	
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
		echo "
			<TR>
				<TD><B>".$le_nom."</B></TD>";
		echo "
				<TD><B>".$le_prenom."</B></TD>";
		echo "
				<TD>".$le_pseudo."</TD>";
		echo "
				<TD>".$l_email."</TD>";
		echo "
				<TD>".$le_telephone."</TD>";
		echo "
				<TD>".$l_adresse."</TD>";
		echo "
				<TD>
					<A class='btn btn-link' HREF=\"supprMembre.php?pseudo=".$le_pseudo."\">Supprimer</A>
				</TD>";
		echo"
			</TR>
			<TR></TR>";
	}
	echo "
		</TABLE>
	</DIV>";
//	echo "
//</CENTER>";
//</DIV>";
}
?>
