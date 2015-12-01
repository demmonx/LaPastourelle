<?php
@session_start ();
require_once 'traitement.inc.php';
verifLoginWithArray ( $_SESSION, 1 );
$messNoValid = getMessageValidationLivre ();
if (count ( $messNoValid ) == 0) {
	echo ("Il n'y a aucun message en attente");
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
				<th colspan='2'>Gestion</th>";
	echo "
			</tr>";
	foreach ( $messNoValid as $row ) {
		echo "<tr>";
		echo "<td>" . $row ['date'] . "</td><td>" . $row ['nom'] . "</td>
				<td>" . nl2br ( html_entity_decode ( $row ['message'] ) ) . "</td>";
		echo "<td>";
		echo "<a class='btn btn-link' href='demande_traitement.php?id=" . $row ['id'] . "&ac=1'><i class='fa fa-check fa-2x'></i></a>";
		echo "</td>";
		echo "<td>";
		echo "<a class='btn btn-link' href='demande_traitement.php?id=" . $row ['id'] . "&ac=2'><i class='fa fa-close fa-2x'></i></a>";
		echo "</td>";
		echo "</tr>";
	}
	echo "
		</table>
	</div>";
}