<!DOCTYPE html>
<?php
	// Lancement de la session
	session_start();

	//inclusion des fichiers de fonction
	require_once ("traitement.inc.php");

	//Definition de la langue
	if (!isset($_SESSION['lang'])) {
		$_SESSION['lang'] = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
	}
	if (isset($_GET['lang']) AND !empty($_GET['lang'])) {
		$_SESSION['lang'] = $_GET['lang'];
	}
	//connexion Ã  la base de donnÃ©e
		$bdd = new Connection();
?>
<html>

<head>
    <meta charset="utf-8">    
    <meta name="description" content="" />
    
    <link rel="stylesheet" href="css/reset.css" type="text/css" />
    <link rel="stylesheet" href="css/grid.css" type="text/css" />
    <link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
    <link rel="stylesheet" href="css/font-awesome-ie7.css" type="text/css" />
    <link rel="stylesheet" href="css/main.css" type="text/css" />
    <link rel="stylesheet" href="css/nav.css" type="text/css" />
	<!--<link rel="stylesheet" href="css/style.css" type="text/css" />-->

	<link rel="icon" type="image/png" href="image/faviconlogo.png" />
	
    <link href='http://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

    <script src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.diaporama.js"></script>
    <script type="text/javascript" src="js/script.js"></script>

    <title>La Pastourelle</title>

</head>

<body>

    <div class="page container_12">
        
        <header>

            <div class="logo grid_7">
                <div class="logo-text-1">La Pastourelle</div>
                <div class="logo-text-2">de Rodez</div>

                <div class="logo-text-3">
                    <span>Groupe Folklorique Rouergat</span><br />
                    FondÃ© en 1948
                </div>
                <div class="logo-text-4">
                    AffiliÃ© Ã  la FÃ©dÃ©ration des Arts et Traditions Populaire du Centre et Massif Central
					<marquee>TEST phrase du jour </marquee>
                </div>
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

        </header>
        <div class="clear"></div>
		
		<div id="boutonsHaut">	
			<div id="mp3">
				<a href="index.php?page=player" title="Nos musiques" ><img src="image/casque.png" ></a>
			</div>
			<div id="livre">
				<a href="index.php?page=livreOR" title="Le livre d'or"><img src="image/book.png" ></a>
			</div>
			<div id="mondeL">
				<a href="index.php?page=mondeLogo" title="Nos Voyages"><img src="image/planete.png" ></a>
			</div>
			<div id="lang">
				<p><?php
				//RÃ©cupÃ©ration de toutes les langues disponibles
				$req_allLang = $bdd->query("SELECT DISTINCT lang FROM texte");
				$allLang = $req_allLang->fetchAll();
				//Affichage du drapeau correspondant
				for ($i=0; $i < count($allLang); $i++) {
					if ($allLang[$i]['lang'] == $_SESSION['lang']) {
						if(!file_exists('image/lang/'.$allLang[$i]['lang'].'.png')) {
							if (isset($_GET['page'])) {
								echo "<a href='index5.php?page=".$_GET['page']."&lang=".$allLang[$i]['lang']."'><img src='image/lang/inc.png' style='border :1px solid green;' width='19' height='12' /></a>";
							} else {
								echo "<a href='index.php?lang=".$allLang[$i]['lang']."'><img src='image/lang/inc.png' style='border :1px solid green;' width='19' height='12' /></a>";
							}
						} else {
							if (isset($_GET['page'])) {
								echo "<a href='index.php?page=".$_GET['page']."&lang=".$allLang[$i]['lang']."'><img src='image/lang/".$allLang[$i]['lang'].".png' style='border :1px solid green;' width='19' height='12' /></a>";
							} else {
								echo "<a href='index.php?lang=".$allLang[$i]['lang']."'><img src='image/lang/".$allLang[$i]['lang'].".png' style='border :1px solid green;' width='19' height='12' /></a>";
							}
						}
					} else {
						if(!file_exists('image/lang/'.$allLang[$i]['lang'].'.png')) {
							if (isset($_GET['page'])) {
								echo "<a href='index.php?page=".$_GET['page']."&lang=".$allLang[$i]['lang']."'><img src='image/lang/inc.png' width='19' height='12' /></a>";
							} else {
								echo "<a href='index.php?lang=".$allLang[$i]['lang']."'><img src='image/lang/inc.png' width='19' height='12' /></a>";
							}
						} else {
							if (isset($_GET['page'])) {
								echo "<a href='index.php?page=".$_GET['page']."&lang=".$allLang[$i]['lang']."'><img src='image/lang/".$allLang[$i]['lang'].".png' width='19' height='12' /></a>";
							} else {
								echo "<a href='index.php?lang=".$allLang[$i]['lang']."'><img src='image/lang/".$allLang[$i]['lang'].".png' width='19' height='12' /></a>";
							}
						}
					}
					echo "&nbsp&nbsp";
				}
			?>
				</p>
			</div>	
		</div>
		<div id="corps">

			<!-- Menu -->

			<center>

				<?php

				if (isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {?>

					<div id ="menu"><center><?php

						//RÃ©cupÃ©ration des valeurs du menu

						$req_menuTrad = $bdd->prepare("SELECT valeurTrad FROM tradannexe WHERE nomTrad LIKE 'menu%' AND lang= ? ORDER BY nomTrad");

						$req_menuTrad->execute(array($_SESSION['lang']));

						$menuTrad = $req_menuTrad->fetchAll();?>

						<script>var menuTrad = new Array(

												"<?php echo $menuTrad[0]['valeurTrad']; ?>", "<?php echo $menuTrad[1]['valeurTrad']; ?>",

												"<?php echo $menuTrad[2]['valeurTrad']; ?>", "<?php echo $menuTrad[3]['valeurTrad']; ?>",

												"<?php echo $menuTrad[4]['valeurTrad']; ?>", "<?php echo $menuTrad[5]['valeurTrad']; ?>",

												"<?php echo $menuTrad[6]['valeurTrad']; ?>", "<?php echo $menuTrad[7]['valeurTrad']; ?>",

												"<?php echo $menuTrad[8]['valeurTrad']; ?>", "<?php echo $menuTrad[9]['valeurTrad']; ?>",

												"<?php echo $menuTrad[10]['valeurTrad']; ?>", "<?php echo $menuTrad[11]['valeurTrad']; ?>"

												);</script>

						<script type="text/javascript" src="menu_javascript.js"></script>

					</center></div><?php

					if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {?>

						<div id ="menuA"><center><script type="text/javascript" src="menuA_javascript.js"></script></center>

						</div><?php

					} else {?>

						<div id ="menuM"><center>

							<script type="text/javascript" src="menuM_javascript.js"></script>

						</center></div><?php

					}

				} else {?>

					<div id ="menu"><center><?php

						//RÃ©cupÃ©ration des valeurs du menu

						$req_menuTrad = $bdd->prepare("SELECT valeurTrad FROM tradannexe WHERE nomTrad LIKE 'menu%' AND lang= ? ORDER BY nomTrad");

						$req_menuTrad->execute(array($_SESSION['lang']));

						$menuTrad = $req_menuTrad->fetchAll();?>

						<script>var menuTrad = new Array(

												"<?php echo $menuTrad[0]['valeurTrad']; ?>", "<?php echo $menuTrad[1]['valeurTrad']; ?>",

												"<?php echo $menuTrad[2]['valeurTrad']; ?>", "<?php echo $menuTrad[3]['valeurTrad']; ?>",

												"<?php echo $menuTrad[4]['valeurTrad']; ?>", "<?php echo $menuTrad[5]['valeurTrad']; ?>",

												"<?php echo $menuTrad[6]['valeurTrad']; ?>", "<?php echo $menuTrad[7]['valeurTrad']; ?>",

												"<?php echo $menuTrad[8]['valeurTrad']; ?>", "<?php echo $menuTrad[9]['valeurTrad']; ?>",

												"<?php echo $menuTrad[10]['valeurTrad']; ?>", "<?php echo $menuTrad[11]['valeurTrad']; ?>"

												);</script>

						<script type="text/javascript" src="menu_javascript.js"></script>

						</center>

					</div><?php

				}

				?>

-			</center><br /><?php

			if (isset($_GET['page'])){

				if (!strstr($_GET['page'], 'http://') && !strstr($_GET['page'], 'www.') && !strstr($_GET['page'], '/')) {

					require_once($_GET['page'].".php");

				} else {

					require_once("accueil.php");

				}

			}

			else

			{

				require_once("accueil.php");

			}

			?>

		</div>
        <div class="clear"></div>
    </div>
	<?php 
/*		if (isset($_GET['page'])){
		    if (!strstr($_GET['page'], 'http://') && !strstr($_GET['page'], 'www.') && !strstr($_GET['page'], '/')) {
			    require_once($_GET['page'].".php");
		    } else {
		        require_once("index5.php");
		    }
		} else 	{
			require_once("index5.php");
		} */
	?>
    <footer class="container_12">
        <div class="footer_copy grid_9">
            <p>
                Groupe Folklorique La Pastourelle de Rodez<br /> 
                Immeuble des SociÃ©tÃ©s Musicales - Avenue de l'Europe - 12000 RODEZ - 05.65.75.95.28<br /> 
                Association reconnue d'intÃ©rÃªt gÃ©nÃ©ral et habilitÃ©e Ã  ce titre Ã  recevoir des dons - <span class="comment">pastourelle.rodez@yahoo.fr</span> 
            </p>
        </div>
        <div class="footer_icon grid_3">
            <div>
                <a href="#"><i class="icon-user icon-large"></i> Se connecter</a>
                <br /><br />
                <a href="#"><i class="icon-key icon-large"></i> Administrer</a>
            </div>
        </div>
        <div class="clear"></div>
    </footer>
    <!-- Bouton haut de page en javascript -->
		<script src="js/jquery-1.7.2.min.js"  type="text/javascript"> </script>
		<script src="js/jquery.ui.totop.min.js"  type="text/javascript"> </script>
		<script src="js/easing.js"  type="text/javascript"> </script>

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