$(document).ready(function () {

    /*** Spoiler ***/
    // Clique sur élément
    $(".spoiler").click(function () {
        $(this).next().toggle(0); // inverse l'état de l'élément suivant en 4ms
        return false;  // bloque la fonction par défaut
    });

	$('.delete').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // confirmation
        if (confirm("Supprimer l'élément selectionnée ?")) {
            // requete de suppression
            $.ajax({
                url: $(this).attr("href"),
                type: 'GET',
                success: function (html) { // Récupération de la réponse
                   	 alert(html); 
                   	 refresh();                  
                    
                }
            });
        }
    });

    
    $('.update').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire

        // Récupération des valeurs
        var content = $("textarea[name=content]", form).val();
        // Vérifie pour éviter de lancer une requête fausse
        if (content === '') {
            alert('Les champs doivent êtres remplis');
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    alert(html);
                }
            });
        }
    });
});