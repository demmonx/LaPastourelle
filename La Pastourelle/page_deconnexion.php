<?php
// On écrase le tableau de session
$_SESSION = array();

// On détruit la session
session_destroy();
echo "Vous êtes déconnecté<br /><a class='btn btn-link' href='index.php'>Retour à l'accueil</a>";
exit(footer());
?>