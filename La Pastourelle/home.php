ï»¿<?php /*// connexionsession_start();//inclusion des fichiers de fonction//Definition de la langueif (!isset($_SESSION['lang'])) {	$_SESSION['lang'] = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);}if (isset($_GET['lang']) AND !empty($_GET['lang'])) {	$_SESSION['lang'] = $_GET['lang'];} */require_once ("\Object\Connection.class.php");require_once ("traitement.inc.php");?>
<!DOCTYPE html>
<html>
<head>
<title>Groupe Folklorique La Pastourelle de Rodez | Association de
	danses dans l'aveyron</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!--<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />-->
<!--<link rel="stylesheet" href="css/reset.css" type="text/css" />-->
<link rel="stylesheet" href="css/grid.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome-ie7.css" type="text/css" />
<!--<link rel="stylesheet" href="css/bootstrap.min.css" media="screen" />-->
<!--<link rel="stylesheet" href="css/bootstrap-responsive.css" type="text/css" />-->
<!--<link rel="stylesheet" href="css/bootstrap-responsive.min.css" type="text/css" />-->
<!--<link rel="stylesheet" href="css/main.css" type="text/css" />-->
<!--<link rel="stylesheet" href="css/nav.css" type="text/css" />-->
<link rel="stylesheet" media="screen" type="text/css"
	href="js/ui.totop.css" />
<link rel="stylesheet" href="style.css" type="text/css" />
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
</head>
<body
	
	<div id="bg-top"></div>
	<div id="#content" class="page container_12">
		<!-- HEADER -->
		<div id="header">
			<div class="logo grid_7">
				<div id="logo-text-1">La Pastourelle</div>
				<div id="logo-text-2">de Rodez</div>
				<div id="logo-text-3">
					<!-- Test de récupération des données pour la phrase du jour 09/03/2013 -->				<?php					//Récupération de la phrase du jour					//$req_phrase = $bdd->prepare("SELECT valeurTrad FROM tradannexe WHERE nomTrad LIKE 'phrasejour' AND lang= ? ORDER BY nomTrad");					//$req_phrase->execute(array("fr"));					//$phrase = $req_phrase->fetchAll();					$phrase = recup_phrasejour();						                    echo "<span>Groupe Folklorique Rouergat</span><br />";                    echo "Fondé en 1948";					//echo "<marquee>Phrase du jour : ".$phrase[0][0]. " </marquee>";					echo "<marquee>Phrase du jour : ". $phrase . " </marquee>";?>					                </div>
				<div id="logo-text-4">Affilié à la Fédération des Arts et Traditions
					Populaire du Centre et Massif Central</div>
			</div>
			<div class="grid_5">
				<ul class="diaporama">
					<li><img src="img/diaporama/diaporama1.jpg" alt="Image 1" /></li>
					<li><img src="img/diaporama/diaporama2.jpg" alt="Image 2" /></li>
					<li><img src="img/diaporama/diaporama3.jpg" alt="Image 3" /></li>
					<li><img src="img/diaporama/diaporama4.jpg" alt="Image 4" /></li>
					<li><img src="img/diaporama/diaporama5.jpg" alt="Image 5" /></li>
					<li><img src="img/diaporama/diaporama6.jpg" alt="Image 6" /></li>
					<li><img src="img/diaporama/diaporama7.jpg" alt="Image 7" /></li>
					<li><img src="img/diaporama/diaporama8.jpg" alt="Image 8" /></li>
					<li><img src="img/diaporama/diaporama9.jpg" alt="Image 9" /></li>
				</ul>
			</div>
		</div>
		<!-- END HEADER -->
		<!-- CORPS DE LA PAGE -->
		<div id="boutonsHaut">
			<!-- Modules MP3 -->
			<div id="mp3">
				<a class="btn btn-link" class="btn btn-link"
					href="index.php?page=player" title="Nos musiques"><img
					src="image/casque.png"></a>
			</div>
			<div id="livre">
				<a class="btn btn-link" href="index.php?page=livreOR"
					title="Le livre d'or"><img src="image/book.png"></a>
			</div>
			<div id="mondeL">
				<a class="btn btn-link" href="index.php?page=mondeLogo"
					title="Nos Voyages"><img src="image/planete.png"></a>
			</div>
			<!-- Module Langue -->
			<div id="lang">
				<p><?php			//Récupération de toutes les langues disponibles			$req_allLang = $bdd->query("SELECT DISTINCT lang FROM texte");			$allLang = $req_allLang->fetchAll();			//Affichage du drapeau correspondant			for ($i=0; $i < count($allLang); $i++) {				if ($allLang[$i]['lang'] == $_SESSION['lang']) {					if(!file_exists('image/lang/'.$allLang[$i]['lang'].'.png')) {						if (isset($_GET['page'])) {							echo "<a class='btn btn-link' href='index.php?page=".$_GET['page']."&lang=".$allLang[$i]['lang']."'><img src='image/lang/inc.png' style='border :1px solid green;' width='19' height='12' /></a>";						} else {							echo "<a class='btn btn-link' href='index.php?lang=".$allLang[$i]['lang']."'><img src='image/lang/inc.png' style='border :1px solid green;' width='19' height='12' /></a>";						}					} else {						if (isset($_GET['page'])) {							echo "<a class='btn btn-link' href='index.php?page=".$_GET['page']."&lang=".$allLang[$i]['lang']."'><img src='image/lang/".$allLang[$i]['lang'].".png' style='border :1px solid green;' width='19' height='12' /></a>";						} else {							echo "<a class='btn btn-link' href='index.php?lang=".$allLang[$i]['lang']."'><img src='image/lang/".$allLang[$i]['lang'].".png' style='border :1px solid green;' width='19' height='12' /></a>";						}					}				} else {					if(!file_exists('image/lang/'.$allLang[$i]['lang'].'.png')) {						if (isset($_GET['page'])) {							echo "<a class='btn btn-link' href='index.php?page=".$_GET['page']."&lang=".$allLang[$i]['lang']."'><img src='image/lang/inc.png' width='19' height='12' /></a>";						} else {							echo "<a class='btn btn-link' href='index.php?lang=".$allLang[$i]['lang']."'><img src='image/lang/inc.png' width='19' height='12' /></a>";						}					} else {						if (isset($_GET['page'])) {							echo "<a class='btn btn-link' href='index.php?page=".$_GET['page']."&lang=".$allLang[$i]['lang']."'><img src='image/lang/".$allLang[$i]['lang'].".png' width='19' height='12' /></a>";						} else {							echo "<a class='btn btn-link' href='index.php?lang=".$allLang[$i]['lang']."'><img src='image/lang/".$allLang[$i]['lang'].".png' width='19' height='12' /></a>";						}					}				}				echo "&nbsp&nbsp";			}			?>			</p>
			</div>
		</div>
		<!-- corps  -->
		<div id="corps">
			<!-- Menu -->
			<center>				<?php				if (isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {?>					<div
					id="menu">
					<center><?php						//Récupération des valeurs du menu						$req_menuTrad = $bdd->prepare("SELECT valeurTrad FROM tradannexe WHERE nomTrad LIKE 'menu%' AND lang= ? ORDER BY nomTrad");						$req_menuTrad->execute(array($_SESSION['lang']));						$menuTrad = $req_menuTrad->fetchAll();?>						<script>var menuTrad = new Array(												"<?php echo $menuTrad[0]['valeurTrad']; ?>", "<?php echo $menuTrad[1]['valeurTrad']; ?>",												"<?php echo $menuTrad[2]['valeurTrad']; ?>", "<?php echo $menuTrad[3]['valeurTrad']; ?>",												"<?php echo $menuTrad[4]['valeurTrad']; ?>", "<?php echo $menuTrad[5]['valeurTrad']; ?>",												"<?php echo $menuTrad[6]['valeurTrad']; ?>", "<?php echo $menuTrad[7]['valeurTrad']; ?>",												"<?php echo $menuTrad[8]['valeurTrad']; ?>", "<?php echo $menuTrad[9]['valeurTrad']; ?>",												"<?php echo $menuTrad[10]['valeurTrad']; ?>", "<?php echo $menuTrad[11]['valeurTrad']; ?>"												);</script>
						<script type="text/javascript" src="menu_javascript.js"></script>
					</center>
				</div><?php					if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {?>						<div
					id="menuA">
					<center>
						<script type="text/javascript" src="menuA_javascript.js"></script>
					</center>
				</div><?php					} else {?>						<div id="menuM">
					<center>
						<script type="text/javascript" src="menuM_javascript.js"></script>
					</center>
				</div><?php					}				} else {?>					<div id="menu">
					<center><?php						//Récupération des valeurs du menu						$req_menuTrad = $bdd->prepare("SELECT valeurTrad FROM tradannexe WHERE nomTrad LIKE 'menu%' AND lang= ? ORDER BY nomTrad");						$req_menuTrad->execute(array($_SESSION['lang']));						$menuTrad = $req_menuTrad->fetchAll();?>						<script>var menuTrad = new Array(												"<?php echo $menuTrad[0]['valeurTrad']; ?>", "<?php echo $menuTrad[1]['valeurTrad']; ?>",												"<?php echo $menuTrad[2]['valeurTrad']; ?>", "<?php echo $menuTrad[3]['valeurTrad']; ?>",												"<?php echo $menuTrad[4]['valeurTrad']; ?>", "<?php echo $menuTrad[5]['valeurTrad']; ?>",												"<?php echo $menuTrad[6]['valeurTrad']; ?>", "<?php echo $menuTrad[7]['valeurTrad']; ?>",												"<?php echo $menuTrad[8]['valeurTrad']; ?>", "<?php echo $menuTrad[9]['valeurTrad']; ?>",												"<?php echo $menuTrad[10]['valeurTrad']; ?>", "<?php echo $menuTrad[11]['valeurTrad']; ?>"												);</script>
						<script type="text/javascript" src="menu_javascript.js"></script>
					</center>
				</div><?php				}				?>-			</center>
			<br /><?php			if (isset($_GET['page'])){				if (!strstr($_GET['page'], 'http://') && !strstr($_GET['page'], 'www.') && !strstr($_GET['page'], '/')) {					require_once($_GET['page'].".php");				} else {					require_once("accueil.php");				}			}			else			{				require_once("accueil.php");			}			?>		</div>
	</div>
	<!-- FOOTER -->
	<footer class="container_12">
		<div class="footer_copy grid_9">
			<p>
				Groupe Folklorique La Pastourelle de Rodez<br /> Immeuble des
				Sociétés Musicales - Avenue de l'Europe - 12000 RODEZ -
				05.65.75.95.28<br /> Association reconnue d'intérêt général et
				habilitée à ce titre à recevoir des dons - <span class="comment"><a
					class="btn btn-link" href="mailto:pastourelle.rodez@yahoo.fr">pastourelle.rodez@yahoo.fr</a></span>
				<br /> <br />					<?php					if (isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {						if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {							echo '<b>Vous êtes Administrateur : '.$_SESSION['pseudo']. ' ';						} else {							echo '<b>Vous êtes Membre : '.$_SESSION['pseudo'];						}						echo "<br/> <a class='btn btn-link' href='index.php?page=infoPersonnelle'>Mon compte</a> || <a class='btn btn-link' href='index.php?page=deconnexion'>Se Déconnecter</a> </b> <br>";					} else {						//echo '<a href="index.php?page=identification">'.$recupHead[7]['valeurTrad'].'</a> || <a href="index.php?page=inscription">'.$recupHead[8]['valeurTrad'].'</a></b> </p>';					}					?>				</p>
		</div>
		<div class="footer_icon grid_3">
			<div>					<?php						if (isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {							echo "<br/>";						}?>												<a
					class="btn btn-link" href="index.php?page=inscription"
					id="boutonsConnexion"><i class="icon-user icon-large"></i>
					S'inscrire</a> <br /> <br /> <a class="btn btn-link"
					href="index.php?page=identification" id="boutonsConnexion"><i
					class="icon-key icon-large"></i> Se connecter</a>
			</div>
		</div>
		<div class="clear"></div>
	</footer>
	<!--<footer>	<!-- END FOOTER -->
	<!-- Bouton haut de page en javascript -->
	<script src="js/jquery.ui.totop.min.js" type="text/javascript"> </script>
	<script src="js/easing.js" type="text/javascript"> </script>
	<script type="text/javascript">		$(document).ready(function() {			var defaults = {				containerID: 'toTop', // fading element id				containerHoverID: 'toTopHover', // fading element hover id				scrollSpeed: 1200,				easingType: 'linear' 			};								$().UItoTop({ easingType: 'easeOutQuart' });					});		</script>
</body>
</html>