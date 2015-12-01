<?php
@session_start();
require_once 'traitement.inc.php';
verifLoginWithArray ( $_SESSION, 1 );
$aValider = getUnvalitedMember ();
if (count ( $aValider ) == 0) {
	echo("Il n'y a aucun membre en attente");
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
				<th colspan='2'>Gestion</th>";
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
					<a class='btn btn-link' href='demande_traitement.php?id=" . $row ['id'] . "&ac=3'><i class='fa fa-check fa-2x'></i></a>
				</td>";
		echo "
				<td>
					<a class='btn btn-link' href='demande_traitement.php?id=" . $row ['id'] . "&ac=4'><i class='fa fa-close fa-2x'></i></a>
				</td>";
		echo "
			</tr>";
	}
	echo "
		</table>
	</div>";
}