<?php
include ('connexiontp4.php');
if (isset($_POST['bAnnuler']))
	{
	header('Location: index.php'); 
	}
if(isset($_POST['bEnregistrer']))
{	if(isset($_POST['actif']))
	{
	$requete=$pdo->prepare(" INSERT INTO tpersonne SET NOMPERSONNE='".$_POST['nom']."',actif='O' ");
	$requete->execute();
	}
	else
	{
	$requete=$pdo->prepare(" INSERT INTO tpersonne SET NOMPERSONNE='".$_POST['nom']."',actif='N' ");
	$requete->execute();
	}
}
?>
<!DOCTYPE html>
<html>

<head>
<meta charset= "utf-8"/>
<title>tp4</title> 
</head>

<body style="background:#81BFFF"
span style="color:#FE2E64">
Insérer un enregistrement dans la table "tpersonne"
</br>

<form id="monform" name="form1" method="POST"  action="inserttpersonne.php">
	<table>
	<tr>
		<td><label>Nom:</td>
		<td colspan=2> <input type="text" name="nom" size="30" autofocus/></label></td>
		<td><label><input type="checkbox" name="actif" checked> Cocher	si la personne est active</label></td>
	</tr>
	<tr>
		<td></td> <!-- décale le bouton enregistrer -->
		<td><label>	<input type="submit" name="bEnregistrer" value="Enregistrer" /> </label></td>
		<td><label>	<input type="reset" name="bReset" value="Réinitialiser" /> </label></td>
		<td><label>	<input type="submit" name="bAnnuler" value="Annuler et retour à l'index" onclick='location.href="inserttpersonne.php"' /> </label></td>
	</tr>
	</table>
</form>

</body>
</html>