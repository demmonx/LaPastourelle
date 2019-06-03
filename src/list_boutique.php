<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
require_once 'inc.function.php';
verifLoginWithArray($_SESSION, 1);

// Vérification si on a des produits
$produit = getProducts();
if (count($produit) == 0) {
    echo "Aucun produit disponible";
} else {
    $langage = getLanguages();
    ?>
<FORM METHOD='POST' id='boutiqueMaj' ACTION='traitement_boutique.php'>
    					<?php
    foreach ($langage as $lang) {
        echo "<h3 class='spoiler'>" . $lang['name'] .
                 " <i class='fa fa-plus-square-o'></i></h3> ";
        echo "<div class='spoiler-hidden' >";
        foreach ($produit as $field) {
            echo "<div>";
            echo $field['name_admin'] . " ";
            echo "<span class='spoiler'><i class='fa fa-plus-square-o'></i></span><div class='spoiler-hidden' >";
            // Formulaire de modification
            $content = getBoutiqueAdmin($lang["id"], $field["id"]);
            echo "<input type='text' placeholder='Nom' value='" .
                     (isset($content["name"]) ? $content["name"] : "") .
                     "' name='" . $field["produit"] . "[" . $lang["id"] .
                     "][name]' /><br>";
            $content = isset($content["txt"]) ? $content["txt"] : "";
            echo "<textarea class='bigta' placeholder='Description' name='" .
                     $field["produit"] . "[" . $lang["id"] . "][desc]'>";
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
    $('#boutiqueMaj').on('submit', function (e) {
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