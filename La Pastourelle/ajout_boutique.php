<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {
    if (isset($_POST["nom"]) and isset($_POST["prix"]) and isset($_POST["texte"])){
	
	    $rqt = "SELECT MAX(pd_img) FROM boutique";
		//$rep = mysql_query($rqt);
		$rep = $bdd->select($rqt);
		
		foreach($rep as $row) {
			$index=$row[0]+1;
		}
		
		//$val = mysql_fetch_row($rep);
		//$index=$val[0]+1;
		
		$rqt_num = "SELECT MAX(pd_num) FROM boutique";
		$val_num = $bdd->select($rqt_num);
		//$rep_num = mysql_query($rqt_num);
		
		foreach($val_num as $row) {
			$index_num = $row[0]+1;
		}
		//$val_num = mysql_fetch_row($rep_num);
		//$index_num=$val_num[0]+1;
		
		//Récupération de toutes les langues disponibles
		//$bdd=connect_BD_PDO();
		$req_allLang = $bdd->select("SELECT DISTINCT lang FROM texte");
		$allLang = $req_allLang->fetchAll();
		
		for ($i = 0; $i < count($allLang); $i++) {
			if ($allLang[$i]['lang'] == $_SESSION['lang']) {
				$maj_prod= "INSERT INTO boutique VALUES ('".$index_num."','".$_SESSION['lang']."', '".$_POST["prix"]."','".$index."','".$index."','".$_POST["nom"]."')";   
				$maj_txt=  "INSERT INTO texte VALUES ('".$index."','boutique','".$_SESSION['lang']."','".$_POST["texte"]."')";
			} else {
				$maj_prod= "INSERT INTO boutique VALUES ('".$index_num."','".$allLang[$i]['lang']."', '".$_POST["prix"]."','".$index."','".$index."','Traduction non faite')";   
				$maj_txt=  "INSERT INTO texte VALUES ('".$index."','boutique','".$allLang[$i]['lang']."','Traduction non faite')";
			}
			$res_prod = $bdd->select($maj_prod);
			$res_txt = $bdd->select($maj_txt);
			//$res_prod = mysql_query($maj_prod);
			//$res_txt = mysql_query($maj_txt);
		}
	    

		
		
		
		if ( !empty($_FILES['fichier_choisi']['name'])){
		    include("upload.php");
		    $chemin = new_produit();
			if ($chemin != "-1"){
			    $maj_img = "INSERT INTO image VALUES ('".$index."','boutique','".$chemin."')"; 
				$res_txt = $bdd->select($maj_img);
				//$res_txt = mysql_query($maj_img);
			}
		}
	   
	    echo '<center><h3>Ajout effectué</h3><br />';
		echo "<a class='btn btn-link' href='index.php?page=boutique'>Revenir à la page précédente</a></center>";
		exit();
	   
	}else{
			
	        echo '<BR><BR>
			<CENTER>
				<h1>Attention, vous ajoutez un article dans la langue suivante : <img src="image/lang/'.$_SESSION["lang"].'.png" width="19" height="12" /></h1>
				<br />Alors les autres langues auront le texte : "Traduction non faite"
				<form name="formulaire" method="POST" enctype="multipart/form-data" action="index.php?page=ajout_boutique">
					<TABLE>
						<TR>			
							<TD>Nom du produit : </TD>
							<TD>  <TEXTAREA name="nom" rows=1 cols=50 wrap=hard></TEXTAREA></TD>
						</TR>
				
						<TR>
							<TD>Description du produit :</TD>
							<TD><TEXTAREA name="texte"   rows=4 cols=50 wrap=hard></TEXTAREA></TD>
						</TR>
						<TR>
							<TD>Prix :</TD>
							<TD>         <TEXTAREA name="prix"     rows=1 cols=10 wrap=hard></TEXTAREA>&nbsp;euros</TD>
						</TR>
						<TR>
							<TD/>
							<TD> <i>*Utilisez un point et non une virgule (ex : 3 euros --> 3.00 ) </i></TD>
						</TR>
						<TR>
							<TD><BR/></TD>
						</TR>
						<TR>
							<TD>Fichier : </TD>
							<TD><input type="file" name="fichier_choisi" size="66"></TD>
						</TR>	
						<TR>
							<TD/>
							<TD><i>*Si vous ne mettez pas de photo, vous ne pourez plus la modifier pour ce produit</i></TD>
						</TR> 
					</TABLE>
					<INPUT TYPE=SUBMIT VALUE="Valider">
				</FORM>
			</CENTER>';	
	}
    echo "<BR><BR>
	<CENTER>
		<A class='btn btn-link' HREF='index.php?page=boutique'>Retour à la page précédente</A>
	</CENTER>";
}			
?>