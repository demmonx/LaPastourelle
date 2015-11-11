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
	// Acceptation ou refus d'un message du livre d'or ou d'un membre*/
	if (isset($_GET['id']) && isset($_GET['confirm']) && is_numeric($_GET['id'])) {
		//Refus d'un message ou d'un membre
		if ($_GET['confirm'] == 0) {
			if (isset($_GET['mb']) AND $_GET['mb'] == 1) { //Membre
				deleteMembre($_GET['id']);
			} else { //Message
				deleteMessageLivre($_GET['id']);
			}			
			
		//Acceptation d'un message ou d'un membre
		} else if ($_GET['confirm'] == 1) {
			if (isset($_GET['mb']) AND $_GET['mb'] == 1) { //Membre
				$modMess = $bdd->prepare("UPDATE tuser SET etat_validation = 1 WHERE id_membre = :id");
			} else { //Message
				$modMess = $bdd->prepare("UPDATE livreor SET validation = 1 WHERE id = :id");
			}
			$modMess->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
			$modMess->execute();
		}
	}
	// Message en attente de validation du livre d'or
	echo "
	<center>
		<h2>Messages du livre d'or en attente de validation</h2>";
	$messNoValid = getMessageValidationLivre();
	if (count($messNoValid) == 0) {
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
		foreach ($messNoValid as $row) { //$messNoValid = $req_messNoValid->fetch()) {
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
	$aValider = recup_membre_valider();
	if (count($aValider) == 0) {
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
		foreach ($aValider as $row) { //$membNoValid = $req_membNoValid->fetch()) {
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
					<a class='btn btn-link' href='index.php?page=page_administrateur&id=".$row['id']."&confirm=1&mb=1'>Accepter</a>
				</td>";
			echo "
				<td>
					<a class='btn btn-link' href='index.php?page=page_administrateur&id=".$row['id']."&confirm=0&mb=1'>Refuser</a>
				</td>";
			echo "
			</tr>";
		}
		echo "
		</table>
	</div>
</center>";
	}

	
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
	
	foreach ( $tab_membre as $row ) {
		echo "<TR>
					<TD><B>" . $row['nom'] . "</B></TD>";
		echo "	<TD><B>" . $row['prenom'] . "</B></TD>";
		echo "	<TD>" . $row['pseudo'] . "</TD>";
		echo "	<TD>" . $row['email'] . "</TD>";
		echo "	<TD>" . $row['telephone'] . "</TD>";
		echo "	<TD>" . $row['adresse'] . "</TD>";
		echo "<TD><A class='btn btn-link' HREF='supprMembre.php?id=" . $row['id'] . "'>Supprimer</A></TD>";
		echo "</TR>";
	}

	echo "
		</TABLE>
	</DIV>";
//	echo "
//</CENTER>";
//</DIV>";
}
?>
