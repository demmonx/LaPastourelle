<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
require_once 'traitement.inc.php';
verifLoginWithArray($_SESSION, 1);
/*
 * Teste si on a reçu tous les champs, même vide
 * Pour cela, besoin de lister les champs à recevoir
 */
$type = getActuType();
$langage = getLanguages();
?>
<FORM METHOD='POST' id='actuMaj' ACTION='actu_maj.php'>
	<table>
		<tr>
			<th>Langue</th>
					<?php
    foreach ($type as $field) {
        echo "<th>" . $field["name"] . "</th>";
    }
    ?>
				</tr>
				<?php
    
    // Récupération de toutes les langues
    foreach ($langage as $lang) {
        echo "<tr><td>" . $lang["name"] . "</td>";
        
        // Récupération de tous les types pour toutes les langues
        foreach ($type as $field) {
            // Récupération du contenu
            $content = getActuAdmin($lang["id"], $field["id"]);
            $content = isset($content["txt"]) ? $content["txt"] : "";
            echo "<td><textarea name='" . $field["type"] . "[" . $lang["id"] .
                     "]'>";
            echo stripnl2br2($content);
            echo "</textarea></td>";
        }
        echo "</tr>";
    }
    ?>
			</table>
	<input type='submit' value='Modifier' />
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