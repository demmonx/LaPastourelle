<?php
// On écrase le tableau de session
$_SESSION = array();

// On détruit la session
session_destroy();
echo "
	
		Vous êtes déconnecté<br />
		Cliquez ici pour revenir à l'Accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
	";
exit(footer());
?>