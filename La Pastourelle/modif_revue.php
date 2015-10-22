<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {
    if(isset($_POST["commantaire"]) or isset($_FILES['fichier_choisi'])) {
	    $rqt = "SELECT * FROM revue_presse WHERE num_presse ='".$_POST["num"]."'";
		//$rep= mysql_query($rqt);
		//$val= mysql_fetch_object($rep);
		
		$rep= $bdd->select($rqt);
		//$val= mysql_fetch_object($rep);
		
		foreach($rep as $val) {
 
			$maj_txt=  $bdd->select("UPDATE texte SET texte='".$_POST['commantaire']."' WHERE  txt_page='revue_presse' AND txt_num='".$val['presse_txt']."' AND lang = '".$_SESSION['lang']."'");
			//mysql_query($maj_txt);
			
			if ( isset($_FILES['fichier_choisi']) and !empty($_FILES['fichier_choisi']['name'])){
				include("upload.php");
				$chemin = new_revue();
				if ($chemin != "-1"){
					//Récupération du nom
					//$bdd = connect_BD_PDO();
					$req_addrimg = $bdd->select("SELECT img_adr FROM image WHERE img_num ='" . $val['presse_img']. "' AND img_page = 'revue_presse'");
					//$req_addrimg->execute(array($val->presse_img));
					$addrimg = $req_addrimg->fetchAll();
					unlink($addrimg[0]['img_adr']);
					$maj_img = "UPDATE image SET img_adr='".$chemin."' WHERE img_num ='".$val['presse_img']."' AND img_page = 'revue_presse'"; 
					$res_img = $bdd->select($maj_img);
				}
			}
			echo '<center><h3>Ajout effectué</h3></center>';	
		}
	} else {
		$num = $_GET["num"];
		$rqt = "SELECT * FROM revue_presse WHERE num_presse = '".$num."'";
		$rep= $bdd->select($rqt);
		//$val= mysql_fetch_object($rep);
		
		foreach ($rep as $val) {
		
			$rqt = "SELECT * FROM texte WHERE txt_num ='".$val['presse_txt']."' AND txt_page='revue_presse' AND lang = '".$_SESSION['lang']."'";
			$rep= $bdd->select($rqt);
			//$ligne= mysql_fetch_object($rep);
			
			foreach($rep as $ligne) {
			
				echo '<BR><BR><CENTER>
				<form name="formulaire" method="POST" enctype="multipart/form-data" action="index.php?page=modif_revue">
					<TABLE>
						<TR>			
							<TD>Commentaire :</TD>
							<TD>   <TEXTAREA name="commantaire" rows=5 cols=60 wrap=hard>'.$ligne['texte'].'</TEXTAREA></TD>
						</TR>
						<TR>
							<TD>Fichier : </TD>
							<TD><input type="file" name="fichier_choisi" size="66">(optionnel)</TD>
						</TR>
						<input type="hidden" name="num" value='.$num.'>
					</TABLE>
					<INPUT TYPE=SUBMIT VALUE="Valider">
				</FORM></CENTER>';
			}
		}
	}
    echo "<BR><BR><CENTER><A class='btn btn-link' HREF='index.php?page=revuedepresse'>Retour à la page précédente</A></CENTER>";
}?>