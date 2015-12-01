$(document).ready(function () {
	/*** Spoiler ***/
    // Clique sur élément
    $(".spoiler").click(function () {
    	if ($( this ).next().css( "diplay" ) == 'none') {
    		$( this ).html("<i class='fa fa-plus-square-o'></i>");
    	} else {
    		$( this ).html("<i class='fa fa-minus-square-o'></i>");
    	}
        $(this).next().toggle(400); // inverse l'état de l'élément suivant en 4ms
        return false;  // bloque la fonction par défaut
    });
    
});