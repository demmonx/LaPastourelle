<?php
verifLoginWithArray($_SESSION, 1, true);
echo "<h1>Gestion des membres</h1>";

// Liste des membres
echo "<div id='container-membre'>";
require_once 'list_membres.php';
echo "</div>";
?>
