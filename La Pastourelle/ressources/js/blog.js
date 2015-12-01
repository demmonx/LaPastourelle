$(document).ready(function () {
	
	function refresh() {
		$("#list-billet").load("list_blog.php");
	}
	// Inverse le statut
    $('.action').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // requete de modification
        $.ajax({
            url: $(this).attr("href"),
            type: 'GET',
            success: function (html) { // Récupération de la réponse
                    alert(html);
                    refresh();
                
            }
        });
    });
    
    $('.post-comment').on('submit', function (e) {
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
                    if (html.search("succès") >= 0) {
                    	form.get(0).reset();
                    	refresh();
                    }
                    alert(html);
                }
            });
        }
    });
});