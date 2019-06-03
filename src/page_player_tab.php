<?php
require 'inc.header.php';
require_once 'inc.top_page.php';
top();
// récupération du titre de la page
$titre = getTraduction("music", $_SESSION['lang']);

if (isset($titre["content"]))
    echo "<h1>" . $titre["content"] . "</h1>";

require 'inc.player.php';
require_once 'inc.footer.php';
footer();
?>