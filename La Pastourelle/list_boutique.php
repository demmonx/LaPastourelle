<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
require_once 'traitement.inc.php';
verifLoginWithArray($_SESSION, 1);
/*
 * Teste si on a reçu tous les champs, même vide
 * Pour cela, besoin de lister les champs à recevoir
 */
$produit = getProducts();
$langage = getLanguages();
?>
<FORM METHOD='POST' id='boutiqueMaj' ACTION='boutique_maj.php'>
	<table>
		<tr>
			<th>Langue</th>
					<?php
    foreach ($produit as $field) {
        echo "<th>" . $field["name_admin"] . "</th>";
    }
    ?>
				</tr>
				<?php
    
    // Récupération de toutes les langues
    foreach ($langage as $lang) {
        echo "<tr><td>" . $lang["name"] . "</td>";
        
        // Récupération de tous les types pour toutes les langues
        foreach ($produit as $field) {
            // Récupération du contenu
            $content = getBoutiqueAdmin($lang["id"], $field["id"]);
            echo "<td>";
            // Récupération du nom
            echo "<input type='text' required value='" .
                     (isset($content["name"]) ? $content["name"] : "") .
                     "' name='" . $field["produit"] . "[" . $lang["id"] .
                     "][name]' />";
            
            // Récupération de la description
            echo "<textarea name='" . $field["produit"] . "[" . $lang["id"] .
                     "][desc]'>";
            echo stripnl2br2(isset($content["txt"]) ? $content["txt"] : "");
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