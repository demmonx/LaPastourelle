<?php
require 'header.inc.php';
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
        $type = isset($_GET["type"]) ? $_GET["type"] : null;
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
            echo '<b>Vous êtes Administrateur : ' . $_SESSION['pseudo'] . '</b>';
        } else {
            echo '<b>Vous êtes Membre : ' . $_SESSION['pseudo'] . "</b>";
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

</html>