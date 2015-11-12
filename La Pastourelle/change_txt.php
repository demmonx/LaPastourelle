<?php
if (! isset ( $_SESSION ['pseudo'] ) or ! isset ( $_SESSION ['pass'] ) or ! verifLoAdmin ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect ( "index.php?page=accueil", 3 );
	exit ( 0 );
} // else
echo "
	<center>
		<h1>Modification d'un texte</h1>
	</center>";
	?>
		