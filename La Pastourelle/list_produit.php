<?php
@session_start();
require_once 'traitement.inc.php';
verifLoginWithArray($_SESSION, 1);
echo "<table>";
$tab = getProducts();
if (count($tab) != 0) {
    
    echo "<tr>";
    
    echo "<th>Produit</th>";
    echo "<th>Prix</th>";
    echo "<th>Image</th>";
    echo "<th>Modifier</th>";
    echo "<th>Supprimer</th>";
    echo "</tr>";
    // mise en forme
    foreach ($tab as $row) {
        echo "<tr>";
        
        echo "<td>" . $row["name_admin"] . "</td>";
        echo "<td><form method='post' action='produit_maj.php' class='change-prix'>";
        echo "<input type='number' step='0.01' name='newprix' value='" .
                 $row["prix"] . "' />";
        echo "<input class='btn btn-info' type='submit' value='Modifier'>";
        echo "<input type='hidden' name='id' value='" . $row["id"] . "' />";
        echo "</form></td>";
        $delete_img = "<a class='delete' href='produit_maj.php?ac=1&id=" .
                 $row["id"] . "'><i class='fa fa-close fa-2x'></i></a>";
        echo "<td>" .
                 (! empty($row["img"]) ? $row["img"] . $delete_img : "Pas d'image") .
                 "</td>";
        echo "<td><form method='post' action='produit_maj.php' class='change-img' enctype='multipart/form-data'>";
        echo "<input type='file' name='fichier'>";
        echo "<input class='btn btn-info' type='submit' value='Ajouter'>";
        echo "<input type='hidden' name='id' value='" . $row["id"] . "' />";
        echo "</form></td>";
        echo "<td><a class='delete' href='produit_maj.php?ac=2&id=" . $row["id"] .
                 "'><i class='fa fa-close fa-2x'></i></a></td>";
        echo "</tr>";
    }
}
?>
</table>
<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
        $('#boutique-container').load("list_boutique.php");
        $('#modif-produit').load("list_produit.php");
	}

	$('.delete').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // confirmation
        if (confirm("Supprimer l'élément selectionnée ?")) {
            // requete de suppression
            $.ajax({
                url: $(this).attr("href"),
                type: 'GET',
                success: function (html) { // Récupération de la réponse
                    // recharge la liste des images si ok
                    if (html.search("succès") >= 0) {
                        refresh();
                    } else {
                   	 alert(html);                   
                    }
                }
            });
        }
    });

	// Ajout d'une nouvelle musique
    $('.change-img').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        var formdata = (window.FormData) ? new FormData(form[0]) : null;
        var data = (formdata !== null) ? formdata : form.serialize();

        var fichier =$("input[name='fichier']", form).val();

        // Vérifie pour éviter de lancer une requête fausse
        if (fichier === '') {
            alert('Le fichier doit être renseigné');
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                enctype: 'multipart/form-data',
                contentType: false, // obligatoire pour de l'upload
                processData: false, // obligatoire pour de l'upload
                data: data, // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    // On efface si ok
                    if (html.search("succès") >= 0) {
                    	$("input[name=fichier]").val('');
                        refresh();
                    } else {
                        alert(html);
                    }
                }
            });
        }
    });

    /** Création de type */
    $('.change-prix').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        var prix =$("input[name=newprix]", form).val();
        var id =$("input[name=id]", form).val();
        if (id === "" || prix === '') {
        	 alert("Les champs doivent être remplis");
        } else if (isNaN(prix) || prix <= 0) {
        	alert("Le prix n'est pas valide");
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    alert(html);  // affichage du résultat
                    if (html.search("succès") >= 0) {
                        refresh();
                    }
                }
            });
        }
    });

});
</script>