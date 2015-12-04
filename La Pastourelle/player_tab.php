<?php
require 'header.inc.php';
require_once 'top_page.inc.php';
top();
// récupération du titre de la page
$titre = getTraduction("music", $_SESSION['lang']);

if (isset($titre["content"]))
    echo "<h1>" . $titre["content"] . "</h1>";

require 'player.inc.php';
require_once 'footer.inc.php';
footer();
?>