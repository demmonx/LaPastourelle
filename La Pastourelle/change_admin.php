<?php
verifLoginWithArray($_SESSION, 1);
    
    echo "<DIV id='container_admin'>";
    require 'list_admin.php';
    echo "</DIV>";
?>
