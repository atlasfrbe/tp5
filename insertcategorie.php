<?php 
session_start();
require ('connect/connexiontp5.php');
?>

<!doctype html>
<html>

<head>
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="style.css" />
<title>insertcategorie</title>
</head>

<body>
<?php
if (isset($_POST['bAnnuler']))
	{
	header('Location: index.php?categorie'); 
	}

if(isset($_GET['id']))//verification que la reference a bien été envoyée
{
	$_SESSION['idcategorie']=$_GET['id'];	//instancier une variable de session qui contient l'identifiant de la categorie a modifier

	$req = $bdd->prepare('SELECT * FROM categories WHERE idcategories="'.$_SESSION['idcategorie'].'"') or die (print_r($bdd->errorInfo()));//requete de selection
	$req->execute();
	$donnees = $req->fetch();
	$categorie=($donnees['categorie']);
?>
<header>

<h1>Modifier une catégorie</h1>
</br>
</header>
<center>
<section>
<article>
<form id="monform" name="form1" method="POST"  action="insertcategorie.php">
	<table border="2" width="600px" height="100px">
	<tr><td>
		<label>Catégorie:</td><td>
		<input type="text" name="categorie" size="30"  value="<?php echo $categorie; ?>"autofocus/>
		</td></tr>
	
		<tr><td COLSPAN=3><label>
			<input type="submit"  class="monBouton" name="bModifier" value="Modifier" />
		</label>
	
		<label>
			<input type="reset" class="monBouton"   name="bReset" value="Réinitialiser" />
		</label>

		<label>
			<input type="submit" class="monBouton" name="bAnnuler" value="Annuler" onclick='location.href="ajoutcategorie.php"' />
		</label></td></tr></table>
	
</form>

</article>
</section>
</center>
<?php
}

if(isset($_POST['bModifier']))
{
	// verification d'enregistrement du fichier

	$pdo->exec("UPDATE tcategories SET categorie='".$_POST['categorie']."' WHERE idcategorie='".$_SESSION['idcategorie']."'");
	
	if(isset($pdo))
	{
		echo '<center>';
		echo '<br>La modification à été effectuer.</br>';
		echo '<a href="index.php?categorie">Retour a la liste</a> </center>';
	}			
  	else
	{
		echo 'La modification à échouée' ;
	}
}
?>

</body>
</html>
