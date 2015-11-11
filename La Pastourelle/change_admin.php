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
	<CENTER>
		<H2> Administrateurs</H2>
	</CENTER> ";
	
	$rqt = "SELECT * FROM tuser WHERE niveau=\"administrateur\" ORDER BY pseudo";
	$rep = $bdd->select($rqt);
	echo "
	<DIV id=\"liens\">
	<TABLE class='table table-bordered' CELLPADDING=5px>
		<TR>
			<H3>
				<TH>Prenom</TH>
				<TH>Nom</TH>
				<TH>Pseudo</TH>
				<TH>E-mail</TH>
				<TH>Telephone</TH>
				<TH>Adresse</TH>
			</H3>
		</TR>";
	foreach ($rep as $row) {
		echo "
		<TR>
			<TD><B>".$row['prenom']."</B></TD>
			<TD><B>".$row['nom']."</B></TD>
			<TD>".$row['pseudo']."</TD>
			<TD>".$row['email']."</TD>
			<TD>".$row['telephone']."</TD>
			<TD>".$row['adresse']."</TD>
			<TD><A class='btn btn-link' HREF=\"index.php?page=suppradmin&psd=".$row['pseudo']."\">Supprimer</A></TD>
		</TR>
		<TR></TR>";
	}
	echo "
	</TABLE>
	</DIV>
	<CENTER>
		<A class='btn btn-link' HREF=\"index.php?page=ajout_admin\">Creer un administrateur</A>
		<BR><BR>
		<CENTER>
			<A class='btn btn-link' HREF=index.php?page=page_administrateur>Retour à la page précédente</A>
		</CENTER>
	</CENTER>
	</DIV>";
}?>
