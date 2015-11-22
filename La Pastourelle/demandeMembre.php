<?php
verifLoginWithArray ( $_SESSION, 1 );
// Acceptation ou refus d'un message du livre d'or ou d'un membre*/
if (isset ( $_GET ['id'] ) && isset ( $_GET ['confirm'] ) && is_numeric ( $_GET ['id'] )) {
	// Refus d'un message ou d'un membre
	if ($_GET ['confirm'] == 0) {
		if (isset ( $_GET ['mb'] ) and $_GET ['mb'] == 1) { // Membre
			deleteMembre ( $_GET ['id'] );
		} else { // Message
			deleteMessageLivre ( $_GET ['id'] );
		}
		
		// Acceptation d'un message ou d'un membre
	} else if ($_GET ['confirm'] == 1) {
		if (isset ( $_GET ['mb'] ) and $_GET ['mb'] == 1) { // Membre
			activerMembre ( $_GET ['id'] );
		} else { // Message
			validerArticle ( $_GET ['id'] );
		}
	}
}
// Message en attente de validation du livre d'or
echo "
	
		<h2>Messages du livre d'or en attente de validation</h2>";
$messNoValid = getMessageValidationLivre ();
if (count ( $messNoValid ) == 0) {
	echo "Il n'y a aucun message en attente";
} else {
	echo "
	<div id='liens'>
		<table class='table table-bordered' >";
	echo "
			<tr>";
	echo "
				<th>Date</th>
				<th>Nom</th>
				<th>Message</th>
				<th>+</th>
				<th>-</th>";
	echo "
			</tr>";
	foreach ( $messNoValid as $row ) {
		echo "
			<tr>";
		echo "
				<td>" . $row ['date'] . "</td><td>" . $row ['nom'] . "</td>
				<td>" . nl2br ( html_entity_decode ( $row ['message'] ) ) . "</td>";
		echo "
				<td>
					<a class='btn btn-link' href='index.php?page=page_administrateur&id=" . $row ['id'] . "&confirm=1'>Accepter</a>
				</td>";
		echo "
				<td>
					<a class='btn btn-link' href='index.php?page=page_administrateur&id=" . $row ['id'] . "&confirm=0'>Refuser</a>
				</td>";
		echo "
			</tr>";
	}
	echo "
		</table>
	</div>";
	// ";
}
// Membre en attente de validation
echo "
	
		<h2>Membres en attente de validation</h2>";
$aValider = getUnvalitedMember ();
if (count ( $aValider ) == 0) {
	echo "Il n'y a aucun membre en attente
	";
} else {
	echo "
	<div id='liens'>
		<table class='table table-bordered' >";
	echo "
			<tr>";
	echo "
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
	foreach ( $aValider as $row ) { // $membNoValid =
	                              // $req_membNoValid->fetch()) {
		echo "
			<tr>";
		echo "
				<td>" . $row ['nom'] . "</td>
				<td>" . $row ['prenom'] . "</td>
				<td>" . $row ['pseudo'] . "</td>
				<td>" . $row ['email'] . "</td>
				<td>" . $row ['telephone'] . "</td>
				<td>" . $row ['adresse'] . "</td>";
		echo "
				<td>
					<a class='btn btn-link' href='index.php?page=page_administrateur&id=" . $row ['id'] . "&confirm=1&mb=1'>Accepter</a>
				</td>";
		echo "
				<td>
					<a class='btn btn-link' href='index.php?page=page_administrateur&id=" . $row ['id'] . "&confirm=0&mb=1'>Refuser</a>
				</td>";
		echo "
			</tr>";
	}
	echo "
		</table>
	</div>
";
}

/**
 * membre deja valider
 */
echo "
	
		<H2>Membres déjà validés </H2>  ";

$tab_membre = getMembers ();
$cpt = 0;
$taille_tab = count ( $tab_membre );

echo "
	<DIV id='liens'>
		<TABLE class='table table-bordered' >
			<TR>
					<TH>Nom</TH>
					<TH>Prénom</TH>
					<TH>Pseudo</TH>
					<TH>E-mail</TH>
					<TH>Téléphone</TH>
					<TH>Adresse</TH>
			</TR>";

foreach ( $tab_membre as $row ) {
	echo "<TR>
					<TD><B>" . $row ['nom'] . "</B></TD>";
	echo "	<TD><B>" . $row ['prenom'] . "</B></TD>";
	echo "	<TD>" . $row ['pseudo'] . "</TD>";
	echo "	<TD>" . $row ['email'] . "</TD>";
	echo "	<TD>" . $row ['telephone'] . "</TD>";
	echo "	<TD>" . $row ['adresse'] . "</TD>";
	echo "<TD><A class='btn btn-link' HREF='supprMembre.php?id=" . $row ['id'] . "'>Supprimer</A></TD>";
	echo "</TR>";
}

echo "
		</TABLE>
	</DIV>";
?>
