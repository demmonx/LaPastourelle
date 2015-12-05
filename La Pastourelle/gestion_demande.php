<?php
verifLoginWithArray ( $_SESSION, 1, true );
echo "<h1>Gestion des demandes</h1>";
// Message en attente de validation du livre d'or
echo "<h2>Messages du livre d'or en attente de validation</h2>";
echo "<div id='container-livre'>";
require_once 'list_validation_livre.php';
echo "</div>";

// Membre en attente de validation
echo "<h2>Membres en attente de validation</h2>";
echo "<div id='container-membre-valid'>";
require_once 'list_validation_membre.php';
echo "</div>";

// Liste des membres inscrits
echo "<H2>Membres déjà validés </H2>";
echo "<div id='container-membre'>";
require_once 'list_membre_actif.php';
echo "</div>";
?>
