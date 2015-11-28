<?php
if (! isset($page))
    exit("404 not found");

$content = getContent($page, $_SESSION['lang']);
echo (isset($content['txt']) ? nl2br(html_entity_decode($content['txt'])) : "Aucun contenu");
