<?php
verifLoginWithArray($_SESSION, 1);
?>
<DIV id='menu2'>
	<B><BR> Gérer : <A class='btn btn-link' HREF='index.php?page=slider'>Le
			diaporama de photos </A> <A class='btn btn-link'
		HREF='index.php?page=adminActualite'>L'actualité</A> <A
		class='btn btn-link' HREF='index.php?page=change_admin'>Les
			administrateurs </A> <A class='btn btn-link'
		HREF='index.php?page=adminTrad'>Les traductions</A> <br /> <br />
		Modifier : <A class='btn btn-link' HREF='index.php?page=change_txt'>Un
			texte</A> <a class='btn btn-link'
		href='index.php?page=change_phrasejour'>La phrase de la semaine</a> <br />
		<br /> <A class='btn btn-link' HREF='index.php?page=gest_content'>Importer
			du contenu</A> | <A class='btn btn-link'
		HREF='index.php?page=gestion_page'>Gérer les pages</A> | <A
		class='btn btn-link' HREF='index.php?page=gestion_revue'>Gérer les
			revues</A> </B> | <A class='btn btn-link'
		HREF='index.php?page=gestion_coordonnees'>Gérer les coordonnées</A> |
	<A class='btn btn-link' HREF='index.php?page=gestion_liens'>Gérer les
		liens</A> </B> | <A class='btn btn-link'
		HREF='index.php?page=gestion_boutique'>Gérer la boutique</A> </B> | <A class='btn btn-link' HREF='index.php?page=adminMondeLogo'>Voyages</A>
</DIV>
<br />
<?php
    
    if (isset($_GET['page_spe'])) {
        if (! strstr($_GET['page_spe'], 'http://') &&
                 ! strstr($_GET['page_spe'], 'www.') &&
                 ! strstr($_GET['page_spe'], '/')) {
            $pageInclure = $_GET['page_spe'];
            require_once ($pageInclure . ".php");
        } else {
            require_once ("demandeMembre.php");
        }
    } else {
        require_once ("demandeMembre.php");
    }
?>