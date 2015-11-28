<?php
@session_start();
require_once 'traitement.inc.php';
verifLoginWithArray ( $_SESSION, 1 );
// tester la connexion en admin
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$pays = $id ? getPays ($id) : getPays();
echo "<option value=''>Pays</option>";
foreach ( $pays as $row )
	echo "<option value=" . $row ['id'] . ">" . $row ["name_fr"] . "</option>";