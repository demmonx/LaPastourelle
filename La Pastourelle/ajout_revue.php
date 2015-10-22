<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {
    if(isset($_POST["commentaire"]) and isset($_FILES['fichier_choisi'])){
	    if(empty($_POST["commentaire"]) or empty($_FILES['fichier_choisi']['name'])){
		    echo '
			<BR/>
			<center>
				<h3>Tous les champs sont obligatoires</h3>
			</center>';
			echo "
			<BR><BR>
			<CENTER>
				<A class='btn btn-link' HREF='index.php?page=ajout_revue'</A>
			</CENTER>";
		}else{	

	    $rqt_num = "SELECT MAX(num_presse) FROM revue_presse";
		//$rep_num = mysql_query($rqt_num);
		//$val_num = mysql_fetch_row($rep_num);
		$req_num = $bdd->select($rqt_num);
		
		
		foreach ($req_num as $row) {
			$index_num=$row[0]+1;
		}
		
		
		
	    $rqt_txt = "SELECT MAX(presse_txt) FROM revue_presse";;
		//$rep_txt = mysql_query($rqt_txt);
		//$val_txt = mysql_fetch_row($rep_txt);
		
		$rep_txt = $bdd->select($rqt_txt);
		//$txt = $req_txt->fetchAll();
		
		foreach($rep_txt as $txt) {
			$index_txt = $txt[0]+1;
		}
		
		//$index_txt=$val_txt[0]+1;
		
		$rqt_img = "SELECT MAX(presse_img) FROM revue_presse";;
		//$rep_img = mysql_query($rqt_img);
		//$val_img = mysql_fetch_row($rep_img);
		$rep_img = $bdd->select($rqt_img);
		//$img = $rep_img->fetchAll();
		
		foreach($rep_img as $img) {
			$index_img = $img[0]+1;
		}
		
		//$index_img=$val_img[0]+1;
		//Récupération de toutes les langues disponibles
		//$bdd=connect_BD_PDO();
		$req_allLang = $bdd->select("SELECT DISTINCT lang FROM texte");
		$allLang = $req_allLang->fetchAll();
		
		for ($i = 0; $i < count($allLang); $i++) {
			if ($allLang[$i]['lang'] == $_SESSION['lang']) {
				$maj_prod= "INSERT INTO revue_presse VALUES (".$index_num.",".$index_img.",".$index_txt.")";   
				$maj_txt=  "INSERT INTO texte VALUES (".$index_txt.",'revue_presse','".$allLang[$i]['lang']."','".$_POST["commentaire"]."')";
				$res_prod = $bdd->select($maj_prod);
				$res_txt = $bdd->select($maj_txt);
			} else {   
				$maj_txt=  "INSERT INTO texte VALUES (".$index_txt.",'revue_presse','".$allLang[$i]['lang']."','Traduction non faite')";
				$res_txt = $bdd->select($maj_txt);
			}
			
		}
		
		include("upload.php");
		$chemin = new_revue();
			if ($chemin != "-1"){
			    $maj_img = "INSERT INTO image VALUES ('".$index_img."','revue_presse','".$chemin."')"; 
				$res_txt = $bdd->select($maj_img);
			}

	   
	    echo '<center><h3>Ajout effectué</h3></center>';
	}	
	   
	}else{
			
	        echo '<BR><BR><CENTER><h1>Attention, vous ajoutez une revue dans la langue suivante : <img src="image/lang/'.$_SESSION["lang"].'.png" width="19" height="12" /></h1>
			<br />Alors les autres langues auront le texte : "Traduction non faite"
			<form name="formulaire" method="POST" enctype="multipart/form-data" action="index.php?page=ajout_revue">
                <TABLE>
					<TR>			
						<TD>Commentaire : </TD>
						<TD><TEXTAREA name="commentaire" rows=5 cols=60 wrap=hard></TEXTAREA></TD>
					</TR>
					<TR>
						<TD>Fichier : </TD>
						<TD><input type="file" name="fichier_choisi" size="66"></TD>
					</TR>
				</TABLE>
    	        <INPUT class="btn btn-info" TYPE=SUBMIT VALUE="Valider">
	        </FORM></CENTER>';
			
	}
    echo "<BR><BR>
	<CENTER>
		<A class='btn btn-link' HREF='index.php?page=revuedepresse'>Retour à la page précédente</A>
	</CENTER>";
}?>