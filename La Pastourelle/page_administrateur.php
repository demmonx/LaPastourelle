<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass'])OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accéder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	exit(0);
} else {
	echo "
		<DIV id=\"menu2\">
			<CENTER><B><BR>

				Gérer : 
				<A class='btn btn-link' HREF='index.php?page=slider'>Le diaporama de photos </A>&nbsp;&nbsp;
				<A class='btn btn-link' HREF='index.php?page=adminActualite'>L'actualité</A> &nbsp;&nbsp;
				<A class='btn btn-link' HREF='index.php?page=change_admin'>Les administrateurs </A> &nbsp;&nbsp;
				<A class='btn btn-link' HREF='index.php?page=adminTrad'>Les traductions</A> &nbsp;&nbsp;<br /><br />
				Modifier :
				<A class='btn btn-link' HREF='index.php?page=change_txt'>Un texte</A>&nbsp;&nbsp; &nbsp;&nbsp;
				<A class='btn btn-link' HREF='index.php?page=change_img'>Une image </A>&nbsp;&nbsp; &nbsp;&nbsp;
				<a class='btn btn-link' href='index.php?page=change_phrasejour'>La phrase de la semaine</a>&nbsp;&nbsp; &nbsp;&nbsp;
			
			</CENTER>
			</B>
		</DIV>
		<br />"; 
	 
	if (isset($_GET['page_spe']))
	{
		if (!strstr($_GET['page_spe'], 'http://') && !strstr($_GET['page_spe'], 'www.') && !strstr($_GET['page_spe'], '/'))
		{
			$pageInclure = $_GET['page_spe'];
			require_once("$pageInclure.php");
		}
		else
		{
			require_once("demandeMembre.php");
		}
	}
	else
	{
		require_once("demandeMembre.php");
	}
}

?>