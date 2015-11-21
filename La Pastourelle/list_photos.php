<?php
@session_start();
require_once 'traitement.inc.php';
$adminOK = false;
if (isset($_SESSION['pseudo']) && isset($_SESSION['pass']) &&
         verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    $adminOK = true;
}

if ($adminOK) {
    $tab = getDiapos();
    if (count($tab) != 0) {
        
        echo "<tr>";
        
        echo "<th>Fichier</th>";
        echo "<th>Statut</th>";
        echo "<th>Activer / Désactiver</th>";
        echo "<th>Supprimer</th>";
        echo "</tr>";
        // mise en forme
        foreach ($tab as $row) {
            echo "<tr>";
            echo "<td>" . $row["lien"] . "</td>";
            echo "<td>" . ($row["statut"] == 'A' ? "Activé" : "Désactivé") .
                     "</td>";
            echo "<td><a class='statut' href='slider_traitement.php?ac=1&id=" .
                     $row["id"] . "'>" .
                     ($row["statut"] == 'A' ? "Désactiver" : "Activer") .
                     "</a></td>";
            echo "<td><a class='delete' href='slider_traitement.php?ac=2&id=" .
                     $row["id"] .
                     "'><img src='/ressources/images/delete.png'/></a></td>";
            echo "</tr>";
        }
    }
}
?>