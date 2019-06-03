<?php
// Gestion de la langue
session_start();
// inclusion des fichiers de fonction
require_once ("inc.function.php");
$supported_lang = getSupportedLanguages();

// Definition de la langue
if (! isset($_SESSION['lang'])) {
    $_SESSION['lang'] = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
}

if (isset($_GET['lang']) && ! empty($_GET['lang'])) {
    $_SESSION['lang'] = strtolower($_GET['lang']);
}

// Récupère l'id à partir du code
$_SESSION['lang'] = $_SESSION['lang'] < 0 ? 1 : $_SESSION['lang'];

if (count($supported_lang) > 0 && $supported_lang[array_search(
        $_SESSION['lang'], $supported_lang)] != $_SESSION['lang']) {
    $_SESSION['lang'] = reverseLanguage('fr');
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Groupe Folklorique La Pastourelle de Rodez | Association de
	danses dans l'aveyron</title>

<meta name="description"
	content="La Pastourelle de Rodez, association de danse folklorique Rouergate affiliée à la Fédération des Arts et Traditions Populaires du Centre et Massif Central" />
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" media="all"
	href="ressources/back-to-top/css/style.css" type="text/css" />
<link rel="stylesheet" type="text/css"
	href="ressources/js/jquery-ui-1.11.4/jquery-ui.css" />
<link rel="stylesheet"
	href="ressources/font-awesome/css/font-awesome.css" type="text/css" />
<link rel="stylesheet" href="ressources/bootstrap/css/bootstrap.css"
	type="text/css" />
<link rel="stylesheet"
	href="ressources/bootstrap/css/bootstrap-theme.css" type="text/css" />
<link rel="stylesheet" href="ressources/bootstrap/css/normalize.css"
	type="text/css" />
<link rel="stylesheet"
	href="ressources/smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.css"
	type="text/css" />
<link rel="stylesheet" type="text/css" href="ressources/slick/slick.css" />
<link rel="stylesheet" type="text/css"
	href="ressources/slick/slick-theme.css" />
<link rel="stylesheet" media="all" href="ressources/style.css"
	type="text/css" />

<link rel="icon" type="image/png"
	href="ressources/images/faviconlogo.png" />

<!-- Diaporama -->
<script type="text/javascript" src="ressources/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="ressources/tinymce/tinymce.min.js"></script>
<script type="text/javascript"
	src="ressources/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="ressources/js/sorttable.js"></script>
<script type="text/javascript"
	src="ressources/smartmenus/jquery.smartmenus.js"></script>
<script type="text/javascript"
	src="ressources/smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.js"></script>
<script type="text/javascript" src="ressources/js/tiny-conf.js"></script>
<script type="text/javascript"
	src="ressources/js/jquery-ui-1.11.4/jquery-ui.js"></script>
<script type="text/javascript"
	src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript" src="ressources/slick/slick.js"></script>
<script type="text/javascript" src="ressources/js/datepicker-fr.js"></script>
<script type="text/javascript" src="ressources/back-to-top/js/main.js"></script>
<script type="text/javascript"
	src="ressources/back-to-top/js/modernizr.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('.slide-top').slick({
    		  dots: false,
    		  arrows: false,
    		  infinite: true,
    		  speed: 500,
    		  autoplay: true,
    		  fade: true,
    		  cssEase: 'linear'
    });	
});
</script>

<script src="https://maps.googleapis.com/maps/api/js"></script>

</head>

<body>