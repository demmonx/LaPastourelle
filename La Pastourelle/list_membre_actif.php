<?php
@session_start();
require_once 'traitement.inc.php';
verifLoginWithArray ( $_SESSION, 1 );
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
	echo "<TD><A class='btn btn-link' href='demande_traitement.php?id=" . $row ['id'] . "&ac=4'><i class='fa fa-close fa-2x'></i></A></TD>";
	echo "</TR>";
}

echo "
		</TABLE>
	</DIV>";