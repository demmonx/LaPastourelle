<?php
session_start ();
// inclusion des fichiers de fonction
require_once ("traitement.inc.php");
require_once ("Connection.class.php");
$supported_lang = getSupportedLanguages ();

// Definition de la langue
if (! isset ( $_SESSION ['lang'] )) {
	$_SESSION ['lang'] = substr ( $_SERVER ["HTTP_ACCEPT_LANGUAGE"], 0, 2 );
}

if (isset ( $_GET ['lang'] ) && ! empty ( $_GET ['lang'] )) {
	$_SESSION ['lang'] = strtolower ( $_GET ['lang'] );
}

// Récupère l'id à partir du code
$_SESSION ['lang'] = $_SESSION ['lang'] < 0 ? 1 : $_SESSION ['lang'];

if (count ( $supported_lang ) > 0 && $supported_lang [array_search ( $_SESSION ['lang'], $supported_lang )] != $_SESSION ['lang']) {
	$_SESSION ['lang'] = reverseLanguage ( 'fr' );
}

require 'header.php';
// connexion à la base de donnée
$bdd = new Connection ();
?>

<div id="bg-top"></div>

<div id="#content" class="page container_12">
	<!-- HEADER -->
	<div id="header">

		<div class="logo grid_7">
			<div id="logo-text-1">La Pastourelle</div>
			<div id="logo-text-2">de Rodez</div>

			<div id="logo-text-3">
				<span>Groupe Folklorique Rouergat</span><br /> Fondé en 1948
			</div>
			<div id="logo-text-4">Affilié à la Fédération des Arts et Traditions
				Populaires du Centre et Massif Central</div>

		</div>
		<div class="grid_5">
			<ul class="diaporama">
						<?php
						$tab = getActiveDiapos ();
						$i = 1;
						foreach ( $tab as $diapo ) {
							echo "<li><img  height=225 src='" . $diapo ["lien"] . "' alt='Image " . $i . "' /></li>";
							$i ++;
						}
						?>
					</ul>
		</div>

	</div>
	<div class="clear"></div>
	<!-- END HEADER -->

	<!-- CORPS DE LA PAGE -->
	<div id="boutonsHaut">
		<!-- Modules MP3 -->
		<div id="mp3">
			<a href="index.php?page=player" title="Nos musiques"><img
				src="/ressources/images/casque.png"></a>
		</div>
		<div id="mp3_texte">Nos musiques</div>
		<div id="livre">
			<a href="index.php?page=livre_or" title="Le livre d'or"><img
				src="/ressources/images/book.png"></a>
		</div>
		<div id="livre_texte">Le livre d'or</div>
		<div id="mondeL">
			<a href="index.php?page=mondeLogo" title="Nos Voyages"><img
				src="/ressources/images/monde.jpg"></a>
		</div>
		<div id="mondeL_texte">Nos voyages</div>
		<!-- Module Langue -->

		<div id="lang">
			<p><?php
			// Récupération de toutes les langues disponibles
			// Affichage du drapeau correspondant
			$languages = getLanguages ();
			foreach ( $languages as $lang ) {
				$lien = "index.php?lang=" . $lang ['id'];
				
				// On a récupéré une page
				if (isset ( $_GET ['page'] )) {
					$lien .= "&page=" . $_GET ['page'];
				}
				
				if (isset ( $_GET ['id'] )) {
					$lien .= "&id=" . $_GET ['id'];
				}
				
				// Affichage des selecteurs
				echo " <a href='" . $lien . "'><img src='" . $lang ['img'] . "'  /></a>";
			}
			?>
					</p>
		</div>
	</div>
	<!-- corps  -->

	<div id="corps">

		<!-- Menu -->
				<?php
				// On vérifie les statuts de connexion
				try {
					$member = checkLoginWithArray ( $_SESSION, 0 );
				} catch ( Exception $e ) {
					$member = false;
				}
				try {
					$admin = checkLoginWithArray ( $_SESSION, 1 );
				} catch ( Exception $e ) {
					$admin = false;
				}
				if ($member) {
					// menu admin
					?>
					<div class="clear"></div>
		<nav class="grid_12">
			<ul class="navigM">
				<li><a href="index.php?page=deconnexion">Se déconnecter</a></li>
					<?php
					if ($admin) {
						
						echo "<li><a href='index.php?page=page_administrateur'>Administration</a>";
					}
					?>



						<li><a href="index.php?page=blog">Blog</a>
				
				<li><a href="index.php?page=planning">Planning</a></li>
				<li><a href="index.php?page=annuaire">Annuaire</a></li>
				<li><a href="index.php?page=compte_rendu">Compte Rendu</a></li>
			</ul>
		</nav>
		<div class="clear"></div>
			<?php } ?>
			
					<div class="clear"></div>
		<nav class="grid_12">
			<ul class="navig">
				<li><a href="index.php">Accueil</a></li>
				<li><a href="#">Présentation</a>
					<ul>
						<?php
						$pageDispo = getPage ();
						foreach ( $pageDispo as $unePage ) {
							echo "<li><a href='index.php?page=generic&id=" . $unePage ['id'] . "'>" . $unePage ['nom'] . "</a></li>";
						}
						?>
						</ul></li>
				<li><a href="index.php?page=boutique">Boutique</a></li>
				<li><a href="index.php?page=revuedepresse">Revue de presse</a></li>
				<li><a href="index.php?page=lien">Liens</a></li>
				<li><a href="#">Contact</a>
					<ul>
						<li><a href="index.php?page=coordonnees">Coordonnées</a></li>
						<li><a href="index.php?page=avis">Laissez votre avis</a></li>
					</ul></li>
			</ul>
		</nav>
		<div class="clear"></div>
		<br /><?php
		
		if (isset ( $_GET ['page'] )) {
			if ($_GET ['page'] == 'generic' && isset ( $_GET ['id'] ) && is_numeric ( $_GET ['id'] )) {
				$page = $_GET ["id"];
				$type = isset($_GET ["type"]) ? $_GET ["type"] : null;
				require_once ("generic.php");
			} else if (! strstr ( $_GET ['page'], 'http://' ) && ! strstr ( $_GET ['page'], 'www.' ) && ! strstr ( $_GET ['page'], '/' )) {
				// && file_exists($_GET['page'])) {
				require_once ($_GET ['page'] . ".php");
			} else {
				require_once ("accueil.php");
			}
		} else {
			require_once ("accueil.php");
		}
		?>
	
	</div>
</div>
<!-- FOOTER -->
<footer class="container_12" id="basDePage">
	<div class="footer_copy grid_9">
		<p>
		<?php
		$coord = getCoordonnees ();
		if (isset ( $coord ['adr'] )) {
			echo nl2br ( html_entity_decode ( $coord ['adr'] ) ) . " - ";
		}
		if (isset ( $coord ['tel'] )) {
			echo convertPhoneNumber ( $coord ['tel'] ) . "<br />";
		}
		echo "Association reconnue d'intérêt général et
			habilitée à ce titre à recevoir des dons";
		if (isset ( $coord ['mail'] )) {
			echo " - <a href='mailto:" . $coord ['mail'] . "'>" . $coord ['mail'] . "</a>";
		}
		?>
					<?php
					
					?>
				</p>
	</div>
	<div>
					<?php
					if ($member) {
						if ($admin) {
							echo '<b>Vous êtes Administrateur : ' . $_SESSION ['pseudo'] . ' ';
						} else {
							echo '<b>Vous êtes Membre : ' . $_SESSION ['pseudo'];
						}
						?>
       <br /> <a href="index.php?page=infoPersonnelle"><i
			class="icon-user icon-large"></i> Mon compte</a><br /> <a
			href="index.php?page=deconnexion"><i class="icon-lock icon-large"></i>
			Se Déconnecter</a>
                 
                 
                 <?php
					} else {
						?>
						
						<a href="index.php?page=inscription"><i
			class="icon-user icon-large"></i> S'inscrire</a> <br /> <br /> <a
			href="index.php?page=identification"><i class="icon-key icon-large"></i>
			Se connecter</a>
				<?php }?>
		
	
	</div>
	<div class="clear"></div>
</footer>

<!-- END FOOTER -->
<!-- Bouton haut de page en javascript -->
<script src="js/jquery.ui.totop.min.js" type="text/javascript"> </script>
<script src="js/easing.js" type="text/javascript"> </script>

<script type="text/javascript">
		$(document).ready(function() {

			var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
			};
		
			
			$().UItoTop({ easingType: 'easeOutQuart' });
			
		});
		</script>
</body>
</html>



