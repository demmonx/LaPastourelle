$(document).ready(function () {
	/*** Spoiler ***/
    // Clique sur élément
    $(".spoiler").click(function () {
    	var spoil = $( this );
    	var el = spoil.next();
    	if (el.css( 'display' ) != 'none') {
    		spoil.children().removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
    	} else {
    		spoil.children().removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
    	}
        el.toggle(400); // inverse l'état de l'élément suivant en 4ms

        return false;  // bloque la fonction par défaut
    });
    
});