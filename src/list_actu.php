<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
require_once 'inc.function.php';
verifLoginWithArray($_SESSION, 1);
/*
 * Teste si on a reçu tous les champs, même vide
 * Pour cela, besoin de lister les champs à recevoir
 */
$type = getActuType();
$langage = getLanguages();
if (count($type) == 0) {
    echo "Aucun type d'actualité disponible";
} else {
    ?>
<FORM METHOD='POST' id='actuMaj' ACTION='traitement_actu.php'>
					<?php
    foreach ($langage as $lang) {
        echo "<h3 class='spoiler'>" . $lang['name'] .
                 " <i class='fa fa-plus-square-o'></i></h3> ";
        echo "<div class='spoiler-hidden' >";
        foreach ($type as $field) {
            echo "<div>";
            echo $field['name'] . " ";
            echo "<span class='spoiler'><i class='fa fa-plus-square-o'></i></span><div class='spoiler-hidden' >";
            // Formulaire de modification
            $content = getActuAdmin($lang["id"], $field["id"]);
            $content = isset($content["txt"]) ? $content["txt"] : "";
            echo "<textarea class='bigta' name='" . $field["type"] . "[" .
                     $lang["id"] . "]'>";
            echo stripnl2br2($content);
            echo "</textarea>";
            echo "</div></div>";
        }
        echo "</div>";
    }
    ?>
	<input class='btn' type='submit' value='Modifier' />
	<div id='msgReturn'></div>
</FORM>
<script language="javascript">
$(document).ready(function () {
    /** * Formulaire d'actualité ** */
    $('#actuMaj').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        $('#msgReturn').empty();
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    $('#msgReturn').append(html);  // affichage du résultat
                }
            });
    });
});
</script>
<script language="javascript" src='ressources/js/spoiler.js'></script>
<?php }?>