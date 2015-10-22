<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {
    if (isset($_POST["nom"]) and isset($_POST["prix"]) and isset($_POST["texte"]) and isset($_POST["num"]) and isset($_POST["num_txt"]) and isset($_POST["num_img"])){
	
	    //$rqt = "SELECT MAX(pd_img) FROM boutique";
		//$rep = mysql_query($rqt);
		//$val = mysql_fetch_row($rep);
		
		$rqt = "SELECT MAX(pd_img) FROM boutique";
		$rep = $bdd->select($rqt);
		//$val = mysql_fetch_row($rep);
		
		foreach ($rep as $val) {
		
			$index=$val[0]+1;
			
			//$rqt_num = "SELECT MAX(pd_num) FROM boutique";
			//$rep_num = mysql_query($rqt_num);
			//$val_num = mysql_fetch_row($rep_num);
			
			$rqt_num = "SELECT MAX(pd_num) FROM boutique";
			$rep_num = $bdd->select($rqt_num);
			//$val_num = mysql_fetch_row($rep_num);
			
			foreach ($rep_num as $val_num) {
			
				$index_num=$val_num[0]+1;
				
				$maj_prod= "UPDATE boutique SET pd_prix ='".$_POST["prix"]."', pd_nom ='".$_POST["nom"]."' WHERE pd_num = '".$_POST["num"]."' AND lang='".$_SESSION["lang"]."'"; 
				$maj_txt=  "UPDATE texte SET texte='".$_POST['texte']."' WHERE  txt_page='boutique' AND txt_num='".$_POST['num_txt']."' AND lang='".$_SESSION["lang"]."'";
				
				//$res_prod = mysql_query($maj_prod);
				//$res_txt = mysql_query($maj_txt);
				
				$res_prod = $bdd->select($maj_prod);
				$res_txt = $bdd->select($maj_txt);
				
				if ( !empty($_FILES['fichier_choisi']['name'])){
					include("upload.php");
					$chemin = new_produit();
					if ($chemin != "-1"){
						$maj_img = "UPDATE image SET img_adr='".$chemin."' WHERE img_num ='".$_POST['num_img']."' AND img_page = 'boutique'"; 
						//$res_img = mysql_query($maj_img);
						$res_img = $bdd->select($maj_img);
					}
				}
			   
				echo '<center><h3>Modification effectuée</h3><br />';
				echo "<a class='btn btn-link' href='index.php?page=boutique'>Revenir à la page précédente</a></center>";
				exit();
			}
		}
	   
	}else{

            //$rqt = "SELECT * FROM boutique WHERE pd_num =".$_GET["num"]." AND lang='".$_SESSION["lang"]."'";
	        //$result = mysql_query($rqt);
	        //$ligne = mysql_fetch_object($result);
			
			$rqt = "SELECT * FROM boutique WHERE pd_num ='".$_GET["num"]."' AND lang='".$_SESSION["lang"]."'";
	        $result = $bdd->select($rqt);
	        //$ligne = mysql_fetch_object($result);
			
			foreach($result as $ligne) {
			
				//$rqt_texte = "SELECT texte FROM texte WHERE txt_num = ".$ligne->pd_txt." AND txt_page='boutique' AND lang='".$_SESSION["lang"]."'";
				//$result_txt = mysql_query($rqt_texte);
				//$ligne_txt = mysql_fetch_object($result_txt);
				
				$rqt_texte = "SELECT texte FROM texte WHERE txt_num ='".$ligne['pd_txt']."' AND txt_page='boutique' AND lang='".$_SESSION["lang"]."'";
				$result_txt = $bdd->select($rqt_texte);
				//$ligne_txt = mysql_fetch_object($result_txt);
				
				foreach($result_txt as $ligne_txt) {
				
					echo '
					<BR><BR>
					<CENTER>
						<h1>Attention, vous modifiez un article dans la langue suivante : <img class="ssBordure" src="image/lang/'.$_SESSION["lang"].'.png" width="19" height="12" /></h1>
						<form name="formulaire" method="POST" enctype="multipart/form-data" action="index.php?page=modif_boutique">
							<TABLE>
								<TR>			
									<TD>Nom du produit : </TD>
									<TD>  <TEXTAREA name="nom" rows=1 cols=50 wrap=hard>'.$ligne['pd_nom'].'</TEXTAREA></TD>
								</TR>
								<TR>
									<TD>Description du produit :</TD>
									<TD><TEXTAREA name="texte"   rows=4 cols=50 wrap=hard>'.$ligne_txt['texte'].'</TEXTAREA></TD>
								</TR>
								<TR>
									<TD>Prix :</TD>
									<TD>         <TEXTAREA name="prix"     rows=1 cols=10 wrap=hard>'.$ligne['pd_prix'].'</TEXTAREA>&nbsp;euros</TD>
								</TR>
								<TR>
									<TD/>
									<TD> <i>*Utiliser un point et non une virgule (ex : 3 euros --> 3.00 ) </i></TD>
								</TR>
								<TR>
									<TD><BR/></TD>
								</TR>
								<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
								<TR>
									<TD>Photo du produit : </TD><TD><input type="file" name="fichier_choisi" size="66"></TD>
								</TR>
								<input type="hidden" name="num_txt" value="'.$ligne['pd_txt'].'">
								<input type="hidden" name="num_img" value="'.$ligne['pd_img'].'">
								<input type="hidden" name="num" value="'.$ligne['pd_num'].'">
							</TABLE>
							<INPUT TYPE=SUBMIT VALUE="Valider">
						</FORM>
					</CENTER>';
				}
			}
	}
    echo "<BR><BR><CENTER><A class='btn btn-link' HREF='index.php?page=boutique'>Retour à la page précédente</A></CENTER>";
}
?>