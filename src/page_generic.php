<?php
if (! isset($page)) {
    echo "Page non disponible";
    exit(footer());
}

if (isset($type)) {
    switch ($type) {
        case 'v':
            // Ecrit la méthode qui récupère les infos d'un seul voyage
            $content = getVoyageDetail($page);
            $txt = $content['txt'];
            $titre = $content['titre'];
            break;
        default:
            $content = getContent($page, $_SESSION['lang']);
            $txt = $content['txt'];
            $titre = $content['titre'];
    }
} else {
    $content = getContent($page, $_SESSION['lang']);
    $txt = $content['txt'];
    $titre = $content['titre'];
}
echo "<h1>" . $titre . "</h1>";
echo (isset($txt) ? nl2br(html_entity_decode($txt)) : "Aucun contenu");