<?php
include ('connexiontp5.php');
if (isset($_POST['bAnnuler']) OR isset($_POST['bEnregistrer']))
	{
	header('Location: index.php'); 
	}
if(isset($_POST['bEnregistrer']))

{	
	// $req2=$pdo->prepare("SELECT idclient FROM tclients WHERE nom='".$_POST['client']."'");
	// $req2->execute();
	// $rep=$req2->fetch();
	// $idclient=$rep['idclient'];
	
	$requete=$pdo->prepare("INSERT INTO ttitres SET titre='".$_POST['titre']."',datetitre=now()");
	$requete->execute();
}

?>
<!DOCTYPE html>

<html>
<head>
<meta charset= "utf-8"/>
<title>AjoutTitre</title> 
</head>
<body style="background:#80BFFF"
span style="color:#FE2E64">
Ajouter un titre
</br>
<!--Formulaire-->
<form id="monform" name="form1" method="POST"  action="ajoutTitre.php">
<table>
<tr><td><label>Titre :</td><td>	<input type="text" name="titre"  size="60" colspan="2" autofocus /> </label></td></tr>

	<tr><td></td><td>
		<label>
			<input type="submit" name="bEnregistrer" value="Enregistrer et retour à l'index" onclick='location.href="ajoutTitre.php"' />
		</label>
	
		<label>
			<input type="reset" name="bReset" value="Réinitialiser" />
		</label>
	
		<label>
			<input type="submit" name="bAnnuler" value="Annuler et retour à l'index" onclick='location.href="ajoutTitre.php"' />
		</label></td></tr>
</table>	
</form>

</body>
</html>