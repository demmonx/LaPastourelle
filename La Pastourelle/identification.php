<?php
/*
Contenu de l'ancienne page verifLogin
	La page verifLogin a été supprimé. Son contenu a été largement optimisé et exporté sur la page ici présente : identification.php
	Par conséquent le formulaire au bas de cette page n'envoie plus ses données à la page verifLogin mais sur cette même page identification.php
=============================================================================================================
//connexion à la base de donnée
connect_BD();
$loginOK = false;  
// s'effectuera uniquement si les cases ont été renseignées
if ( isset($_POST) && (!empty($_POST['pseudo'])) && (!empty($_POST['motdepasse'])) ) {

  extract($_POST);
  $sql = "SELECT pseudo, motdepasse, niveau FROM user WHERE pseudo = '".addslashes($pseudo)."' AND etat_validation=1";
  $req = mysql_query($sql) or die('Erreur SQL : <br />'.$sql);
 
  // On vérifie que l'utilisateur existe bien
  if (mysql_num_rows($req) > 0) {
     $data = mysql_fetch_assoc($req);
   
    // On vérifie que son mot de passe est correct
    if (sha1($motdepasse) == $data['motdepasse']) {
      $loginOK = true;
    }
  }
}
if ($loginOK) {
  $_SESSION['pseudo'] = $data['pseudo'];
  $_SESSION['niveau'] = $data['niveau'];
  $_SESSION['pass'] = $data['motdepasse'];
}
// renvoie vers la page adéquate
if ( $data['niveau'] == membre ){
	header("location:index.php?page=page_membre");
}else if ( $data['niveau'] == administrateur ){
	header("location:index.php?page=page_administrateur");
}
echo "<BR><BR><BR><BR><BR><BR><CENTER>Pseudo ou mot de passe incorrect<BR>
		Vous allez être redirigé</CENTER>";

?>
----scrhj language="javascript" type="text/javascript"----
	setTimeout("window.location='index.php?page=accueil'", 3000);
</sjhjg>
=============================================================================================================
*/
/* Analyse du formulaire, Variables de session, Redirection   OPTIMISE
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 */
if (!empty($_POST['pseudo']) AND !empty($_POST['motdepasse'])){
	echo "
	<center>";
	if (verifLo($_POST['pseudo'], sha1($_POST['motdepasse']))) {
		$_SESSION['pseudo'] = $_POST['pseudo'];
		$_SESSION['pass'] = sha1($_POST['motdepasse']);
		echo"Félicitations ! Vous êtes maintenant connecté sur le site de La Pastourelle de Rodez<br />";
	} else {
		echo"Pseudo ou mot de passe incorrect<br />";
	}
	echo "Pour revenir à la page d'accueil, cliquez<a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
	</center>";
	exit(0);
}

echo '
	<div id="espace_reserve">
		Espace <span>réservé</span> aux membres de la Pastourelle<br />
		Pour <span>accéder</span> à cet espace, vous devez obligatoirement être <span>inscrit</span>.<br />
		Pour vous <span>inscrire</span>, <span>cliquez</span> sur la rubrique <span>"s\'inscrire"</span> et <span>remplissez</span> les champs qui vous sont demandés.
	</div>
	<center><H2>Identification</H2></center>
	<div class="identification">
	<FORM class="form-horizontal" ACTION="index.php?page=identification" METHOD="POST">
		<div class="control-group">
			<label class="control-label for="inputEmail">Pseudo</label>
			<div class="controls">
				<input type="text" name="pseudo" placeholder="Pseudo">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputPassword">Mot de passe</label>
			<div class="controls">
				<input type="password" name="motdepasse" placeholder="Mot de Passe">
			</div>
		</div>
		<button type="submit" class="btn">Se Connecter</button>
	</FORM></div>';
	
	//<P>
	//			<TABLE> <TR>	<TD>Pseudo       </TD> 		<TD><INPUT TYPE="text" NAME="pseudo" />      </TD> 	</TR>
	//					<TR>	<TD>Mot de passe </TD> 		<TD><INPUT TYPE="password" NAME="motdepasse" />      </TD>	</TR>
	//			</TABLE>
	//			<BR><INPUT TYPE="submit" VALUE="Se Connecter" />				
	//		</P>
?>