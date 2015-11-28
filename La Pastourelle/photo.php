<?php
require_once 'traitement.inc.php';

	if (isset($_GET['id_photo'])){
		echo $_GET['id_photo'];
	} else {
		echo "Aucune photo de ce voyage n'est disponible.";
	}
?>