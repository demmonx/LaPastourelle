<?php
verifLoginWithArray($_SESSION, 1, true);
    echo "<h1>Gestion des droits</h1>";
    echo "<DIV id='container_admin'>";
    require 'list_admin.php';
    echo "</DIV>";
?>
