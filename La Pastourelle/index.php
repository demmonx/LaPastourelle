<?php
session_start();
// inclusion des fichiers de fonction
require_once ("traitement.inc.php");
require_once ("Connection.class.php");
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

require 'header.php';
// connexion à la base de donnée
?>
<!-- HEADER -->
<header class="row">

	<div class="col-md-3">
		<span>Groupe Folklorique Rouergat</span><br /> Fondé en 1948
	</div>

	<div class="col-md-3">
		<div>La Pastourelle</div>
		<div>de Rodez</div>

	</div>

	<div class="col-md-5">
		<div class="slide-top">
						<?php
    $tab = getActiveDiapos();
    foreach ($tab as $diapo) {
        echo "<div><img  height=225 src='" . $diapo["lien"] . "'/></div>";
    }
    ?>		
		</div>
		<div>Affilié à la Fédération des Arts et Traditions Populaires du
			Centre et Massif Central</div>

		<!-- END HEADER -->

	</div>
	<div class="col-md-1 dropdown">
    <?php require 'menu_lang.php'; ?>
	</div>

</header>
<!-- fin - header  -->
<?php require 'menu.php'; ?>
<!-- .contain-to-grid -->

<section>
		<?php

if (isset($_GET['page'])) {
    if ($_GET['page'] == 'generic' && isset($_GET['id']) &&
             is_numeric($_GET['id'])) {
        $page = $_GET["id"];
        require_once ("generic.php");
    } else 
        if (! strstr($_GET['page'], 'http://') && ! strstr($_GET['page'], 
                'www.') && ! strstr($_GET['page'], '/')) {
            // && file_exists($_GET['page'])) {
            require_once ($_GET['page'] . ".php");
        } else {
            require_once ("accueil.php");
        }
} else {
    require_once ("accueil.php");
}
?>
</section>
<!-- FOOTER -->
<footer class="row">
	<div class="col-md-8 border-right">
		<?php
$coord = getCoordonnees();
if (isset($coord['adr'])) {
    echo nl2br(html_entity_decode($coord['adr'])) . " - ";
}
if (isset($coord['tel'])) {
    echo convertPhoneNumber($coord['tel']) . "<br />";
}
echo "Association reconnue d'intérêt général et
			habilitée à ce titre à recevoir des dons";
if (isset($coord['mail'])) {
    echo " - <a href='mailto:" . $coord['mail'] . "'>" . $coord['mail'] . "</a>";
}
?>
	</div>
	<div class="col-md-4">
					<?php
    if ($member) {
        if ($admin) {
            echo '<b>Vous êtes Administrateur : ' . $_SESSION['pseudo'] . ' ';
        } else {
            echo '<b>Vous êtes Membre : ' . $_SESSION['pseudo'];
        }
        ?>
       <br /> <a href="index.php?page=info_perso"><i
			class="fa fa-user fa-lg"></i> Mon compte</a><br /> <a
			href="index.php?page=deconnexion"><i class="fa fa-sign-out fa-lg"></i>
			Se Déconnecter</a>
                 
                 
                 <?php
    } else {
        ?>
						
						<a href="index.php?page=inscription"><i class="fa fa-user fa-lg"></i>
			S'inscrire</a> <br /> <br /> <a href="index.php?page=identification"><i
			class="fa fa-lock fa-lg"></i> Se connecter</a>
				<?php }?>
		
	
	</div>
</footer>

<!-- END FOOTER -->
</body>
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
</html>