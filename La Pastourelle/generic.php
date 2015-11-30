<?php
if (! isset($page))
    exit("404 not found". footer());

if (isset($type)) {
    switch ($type) {
        case 'v':
            // Ecrit la méthode qui récupère les infos d'un seul voyage
            $content = getVoyageDetail($page);
            break;
        default:
            $content = getContent($page, $_SESSION['lang']);
    }
} else {
    $content = getContent($page, $_SESSION['lang']);
}
echo (isset($content['txt']) ? nl2br(html_entity_decode($content['txt'])) : "Aucun contenu");