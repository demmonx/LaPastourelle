<?php
session_start ();
// inclusion des fichiers de fonction
require_once ("traitement.inc.php");
require_once ("Connection.class.php");

// Definition de la langue
if (! isset ( $_SESSION ['lang'] )) {
	$_SESSION ['lang'] = substr ( $_SERVER ["HTTP_ACCEPT_LANGUAGE"], 0, 2 );
}
if (isset ( $_GET ['lang'] ) and ! empty ( $_GET ['lang'] )) {
	$_SESSION ['lang'] = $_GET ['lang'];
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Groupe Folklorique La Pastourelle de Rodez | Association de
	danses dans l'aveyron</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="css/grid.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome-ie7.css" type="text/css" />
<link rel="stylesheet" href="css/nav.css" type="text/css" />
<link rel="stylesheet" media="screen" type="text/css"
	href="js/ui.totop.css" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="icon" type="image/png" href="image/faviconlogo.png" />

<!-- polices -->
<link href='http://fonts.googleapis.com/css?family=Kaushan+Script'
	rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oxygen'
	rel='stylesheet' type='text/css'>

<!-- Diaporama -->
<script src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery.diaporama.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body>
		<?php
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
						$tab = recup_image ();
						$i = 1;
						foreach ( $tab as $diapo ) {
							echo "<li><img width=335 height=225 src='/diaporama/" . $diapo . "' alt='Image " . $i . "' /></li>";
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
				<a href="index.php?page=livreOR" title="Le livre d'or"><img
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
				$req_allLang = $bdd->select ( "SELECT DISTINCT lang FROM texte" );
				$allLang = $req_allLang->fetchAll ();
				// Affichage du drapeau correspondant
				for($i = 0; $i < count ( $allLang ); $i ++) {
					if ($allLang [$i] ['lang'] == $_SESSION ['lang']) {
						if (! file_exists ( 'image/lang/' . $allLang [$i] ['lang'] . '.png' )) {
							if (isset ( $_GET ['page'] )) {
								echo "<a href='index.php?page=" . $_GET ['page'] . "&lang=" . $allLang [$i] ['lang'] . "'><img src='image/lang/inc.png' style='border :1px solid green;' width='19' height='12' /></a>";
							} else {
								echo "<a href='index.php?lang=" . $allLang [$i] ['lang'] . "'><img src='image/lang/inc.png' style='border :1px solid green;' width='19' height='12' /></a>";
							}
						} else {
							if (isset ( $_GET ['page'] )) {
								echo "<a href='index.php?page=" . $_GET ['page'] . "&lang=" . $allLang [$i] ['lang'] . "'><img src='image/lang/" . $allLang [$i] ['lang'] . ".png' style='border :1px solid green;' width='19' height='12' /></a>";
							} else {
								echo "<a href='index.php?lang=" . $allLang [$i] ['lang'] . "'><img src='image/lang/" . $allLang [$i] ['lang'] . ".png' style='border :1px solid green;' width='19' height='12' /></a>";
							}
						}
					} else {
						if (! file_exists ( 'image/lang/' . $allLang [$i] ['lang'] . '.png' )) {
							if (isset ( $_GET ['page'] )) {
								echo "<a href='index.php?page=" . $_GET ['page'] . "&lang=" . $allLang [$i] ['lang'] . "'><img src='image/lang/inc.png' width='19' height='12' /></a>";
							} else {
								echo "<a href='index.php?lang=" . $allLang [$i] ['lang'] . "'><img src='image/lang/inc.png' width='19' height='12' /></a>";
							}
						} else {
							if (isset ( $_GET ['page'] )) {
								echo "<a href='index.php?page=" . $_GET ['page'] . "&lang=" . $allLang [$i] ['lang'] . "'><img src='image/lang/" . $allLang [$i] ['lang'] . ".png' width='19' height='12' /></a>";
							} else {
								
								echo "<a href='index.php?lang=" . $allLang [$i] ['lang'] . "'><img src='image/lang/" . $allLang [$i] ['lang'] . ".png' width='19' height='12' /></a>";
							}
						}
					}
					echo "&nbsp&nbsp";
				}
				?>
					</p>
			</div>
		</div>
		<!-- corps  -->

		<div id="corps">
			<center>
				<!-- Menu -->
				<?php
				if (isset ( $_SESSION ['pseudo'] ) and isset ( $_SESSION ['pass'] ) and verifLo ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
					// menu admin
					if (verifLoAdmin ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
						?>
					<div class="clear"></div>
				<nav class="grid_12">
					<ul class="navigM">
						<li><a href="index.php?page=deconnexion">Se déconnecter</a></li>
						<li><a href="index.php?page=page_administrateur">Administration</a>
						
						<li><a href="index.php?page=blog">Blog</a>
						
						<li><a href="index.php?page=planning">Planning</a></li>
						<li><a href="index.php?page=annuaire">Annuaire</a></li>
						<li><a href="index.php?page=compte_rendu">Compte Rendu</a></li>
					</ul>
				</nav>
				<div class="clear"></div>
					
						<?php
						// membre non admin
					} else {
						?>
							
					<div class="clear"></div>
				<nav class="grid_12">
					<ul class="navigM">
						<li><a href="index.php?page=deconnexion">Se déconnecter</a></li>
						<li><a href="index.php?page=blog">Blog</a>
						
						<li><a href="index.php?page=planning">Planning</a></li>
						<li><a href="index.php?page=annuaire">Annuaire</a></li>
						<li><a href="index.php?page=compte_rendu">Compte Rendu</a></li>
					</ul>
				</nav>
				<div class="clear"></div>
							
						<?php
					} // menu commun
					?>
			
					<div class="clear"></div>
				<nav class="grid_12">
					<ul class="navig">
						<li><a href="index.php">Accueil</a></li>
						<li><a href="#">Présentation</a>
							<ul>
								<li><a href="index.php?page=danse">Les danses</a></li>
								<li><a href="index.php?page=theatre">Le théâtre</a></li>
								<li><a href="index.php?page=ecole">Les écoles de danse</a></li>
							</ul></li>
						<li><a href="index.php?page=historique">Historique</a></li>
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
					
				<?php
				} else { // menu visiteur
					?>
				
					<div class="clear"></div>
				<nav class="grid_12">
					<ul class="navigV">
						<li><a href="index.php">Accueil</a></li>
						<li><a href="#">Présentation</a>
							<ul>
								<li><a href="index.php?page=danse">Les danses</a></li>
								<li><a href="index.php?page=theatre">Le théâtre</a></li>
								<li><a href="index.php?page=ecole">Les écoles de danse</a></li>
							</ul></li>
						<li><a href="index.php?page=historique">Historique</a></li>
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
					
				<?php
				}
				?>	
			<br /><?php
			
			if (isset ( $_GET ['page'] )) {
				if (! strstr ( $_GET ['page'], 'http://' ) && ! strstr ( $_GET ['page'], 'www.' ) && ! strstr ( $_GET ['page'], '/' )) {
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
				Groupe Folklorique La Pastourelle de Rodez<br /> Immeuble des
				Sociétés Musicales - Avenue de l'Europe - 12000 RODEZ -
				05.65.75.95.28<br /> Association reconnue d'intérêt général et
				habilitée à ce titre à recevoir des dons - <span class="comment"><a
					class="btn btn-link" href="mailto:pastourelle.rodez@yahoo.fr">pastourelle.rodez@yahoo.fr</a></span>
				<br /> <br />
					<?php
					
					if (isset ( $_SESSION ['pseudo'] ) and isset ( $_SESSION ['pass'] ) and verifLo ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
						if (verifLoAdmin ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
							echo '<b>Vous êtes Administrateur : ' . $_SESSION ['pseudo'] . ' ';
						} else {
							echo '<b>Vous êtes Membre : ' . $_SESSION ['pseudo'];
						}
						echo '<br/> <a href="index.php?page=infoPersonnelle">Mon compte</a> || <a href="index.php?page=deconnexion">Se Déconnecter</a> </b> <br>';
					} else {
						// echo '<a href="index.php?page=identification">'.$recupHead[7]['valeurTrad'].'</a> || <a href="index.php?page=inscription">'.$recupHead[8]['valeurTrad'].'</a></b> </p>';
					}
					
					?>
				</p>
		</div>
		<div class="footer_icon grid_3">
			<div>
					<?php
					if (isset ( $_SESSION ['pseudo'] ) and isset ( $_SESSION ['pass'] ) and verifLo ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
						echo "<br/>";
					}
					?>
						
						<a href="index.php?page=inscription" id="boutonsConnexion"><i
					class="icon-user icon-large"></i> S'inscrire</a> <br /> <br /> <a
					href="index.php?page=identification" id="boutonsConnexion"><i
					class="icon-key icon-large"></i> Se connecter</a>
			</div>
		</div>
		<div class="clear"></div>
	</footer>

	<!-- END FOOTER -->
	<!-- Bouton haut de page en javascript -->
	<script src="js/jquery.ui.totop.min.js" type="text/javascript"> </script>
	<script src="js/easing.js" type="text/javascript"> </script>
	<script src="js/prototype.js" type="text/javascript"> </script>
	<script src="js/sortHTMLTable.js" type="text/javascript"> </script>

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



