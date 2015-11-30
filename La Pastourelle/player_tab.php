<?php
require 'header.inc.php';
// récupération du titre de la page
$titre = getTraduction("music", $_SESSION['lang']);

if (isset($titre["content"]))
    echo "<h1>" . $titre["content"] . "</h1>";

require 'player.inc.php';
?>
</body>
</html>