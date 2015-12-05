
<!-- Menu -->
<?php
@session_start();
require_once 'inc.header.php';
require_once 'inc.function.php';
// On vérifie les statuts de connexion
try {
    $member = checkLoginWithArray($_SESSION, 0);
} catch (Exception $e) {
    $member = false;
}
try {
    $admin = checkLoginWithArray($_SESSION, 1);
} catch (Exception $e) {
    $admin = false;
}
$lang = $_SESSION['lang'];
?>
<!--  Navigation pour tout le monde -->

<nav class="navbar navbar-default" role="navigation" id="navigationbar">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse"
				data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span>
			</button>
		</div>
    <?php if ($member) { ?>
		<div class="collapse navbar-collapse navbar-menubuilder">
			<ul class='nav navbar-nav '>
				<li><a href="index.php?page=page_deconnexion"><i
						class="fa fa-sign-out fa-lg"></i> Se déconnecter</a></li>
					<?php
        if ($admin) {
            ?>
            
            <li class="dropdown"><a class="dropdown-toggle"
					data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
					aria-expanded="false"><i class="fa fa-gear fa-lg"></i>
						Aministration <span class="caret"></span></a>
					<ul class="dropdown-menu">


						<li class="dropdown"><a class="dropdown-toggle"
							data-toggle="dropdown" href="#" role="button"
							aria-haspopup="true" aria-expanded="false"> Membres <span
								class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href='index.php?page=gestion_demande'> Demandes</a></li>
								<li><a href='index.php?page=gestion_admin'> Administrateurs</a></li>
								<li><a href='index.php?page=gestion_users'> Utilisateurs</a></li>
							</ul></li>

						<li class="dropdown"><a class="dropdown-toggle"
							data-toggle="dropdown" href="#" role="button"
							aria-haspopup="true" aria-expanded="false">Contenu <span
								class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href='index.php?page=gestion_content'> Importer</a></li>
								<li><a href='index.php?page=gestion_phrasejour'> Phrase de la
										semaine</a></li>
								<li class="dropdown"><a class="dropdown-toggle"
									data-toggle="dropdown" href="#" role="button"
									aria-haspopup="true" aria-expanded="false"> Pages <span
										class="caret"></span></a>
									<ul class='dropdown-menu'>
										<li><a href='index.php?page=gestion_page'> Gestion</a></li>
										<li><a href='index.php?page=gestion_txt'> Textes</a></li>
										<li><a href='index.php?page=gestion_titre'> Titres</a></li>
									</ul></li>
								<li><a href='index.php?page=gestion_slider'> Diaporama</a></li>
								<li><a href='index.php?page=gestion_player'> Musiques</a></li>
								<li><a href='index.php?page=gestion_revue'> Revue de presse</a></li>
								<li><a href='index.php?page=gestion_boutique'> Boutique</a></li>
								<li><a href='index.php?page=gestion_actu'> Actualités</a></li>
								<li><a href='index.php?page=gestion_liens'> Liens</a></li>
								<li><a href='index.php?page=gestion_voyage'> Voyages</a></li>
							</ul></li>

						<li class="dropdown"><a class="dropdown-toggle"
							data-toggle="dropdown" href="#" role="button"
							aria-haspopup="true" aria-expanded="false"> Paramétrage <span
								class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href='index.php?page=gestion_lang'> Langues</a></li>
								<li><a href='index.php?page=gestion_coord'> Coordonnées</a></li>
							</ul></li>
					</ul>
            <?php
        }
        ?>				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				<li><a href="index.php?page=page_blog"><i
						class="fa fa-commenting-o fa-lg"></i> Blog</a>
				
				<li role="separator" class="divider"></li>
				<li><a href="index.php?page=page_planning"><i
						class="fa fa-calendar fa-lg"></i> Planning</a></li>
				<li role="separator" class="divider"></li>
				<li><a href="index.php?page=page_annuaire"><i
						class="fa fa-group fa-lg"></i> Annuaire</a></li>
				<li role="separator" class="divider"></li>
				<li><a href="index.php?page=page_compte_rendu"><i
						class="fa fa-file-text fa-lg"></i> Compte Rendu</a></li>
			</ul>

		</div>
	<?php } ?>
		<div class="collapse navbar-collapse navbar-menubuilder">
			<ul class='nav navbar-nav'>
				<li><a href="index.php"><i class="fa fa-home fa-lg"></i> <?php echo getTitre('accueil', $lang); ?></a></li>
										<?php
        $pageDispo = getPageTitre($_SESSION['lang']);
        if (count($pageDispo) != 0) {
            ?>
				<li role="separator" class="divider"></li>
				<li class="dropdown"><a class="dropdown-toggle"
					data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
					aria-expanded="false"><i class="fa fa-book fa-lg"></i> <?php echo getTitre('pres', $lang); ?>
						<span class="caret"></span> </a>
					<ul class="dropdown-menu">
				<?php
            foreach ($pageDispo as $unePage) {
                echo "
					<li><a href='index.php?page=page_generic&id=" .
                         $unePage['page'] . "'>" . $unePage['titre'] .
                         "</a></li>";
            }
            ?>
				</ul></li>
				<?php }?>
				<li role="separator" class="divider"></li>
				<li><a href="index.php?page=page_boutique"><i
						class="fa fa-shopping-cart fa-lg"></i> <?php echo getTitre('boutique', $lang); ?></a></li>
				<li role="separator" class="divider"></li>
				<li><a href="index.php?page=page_revue_presse"><i
						class="fa fa-newspaper-o fa-lg"></i> <?php echo getTitre('revue', $lang); ?></a></li>
				<li role="separator" class="divider"></li>
				<li><a href="page_player_tab.php" target="_blank"><i
						class="fa fa-music fa-lg"></i> <?php echo getTitre('music', $lang); ?></a></li>
				<li role="separator" class="divider"></li>
				<li><a href="index.php?page=page_voyage"><i
						class="fa fa-globe fa-lg"></i>
						<?php echo getTitre('voyage', $lang); ?></a></li>
				<li role="separator" class="divider"></li>
				<li class="dropdown"><a class="dropdown-toggle"
					data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
					aria-expanded="false"><i class="fa fa-envelope fa-lg"></i> <?php echo getTitre('contact', $lang); ?>
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?page=page_coordonnees"> <?php echo getTitre('coord', $lang); ?></a></li>
						<li><a href="index.php?page=page_avis"> <?php echo getTitre('avis', $lang); ?></a></li>
						<li><a href="index.php?page=page_livre_or"> <?php echo getTitre('livre', $lang); ?></a></li>
						<li><a href="index.php?page=page_lien"> <?php echo getTitre('lien', $lang); ?></a></li>
					</ul></li>
			</ul>
		</div>
	</div>
</nav>