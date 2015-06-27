<?php 

session_start();
include ('connect.php'); ?><!--connexion a la base de donnees-->
<!doctype html>


<html>

<head>

<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="style.css" />


<title> </title>

</head>
<body>

<?php


if (isset($_POST['bAnnuler']))
	{
	header('Location: index.php?support'); 
	}

if(isset($_GET['id']))//verification que la reference a bien été envoyée
{

$_SESSION['idsupport']=$_GET['id'];//instancier une variable de session qui contient l'identifiant du support a modifier


$req = $bdd->prepare('SELECT * FROM support WHERE idsupport="'.$_SESSION['idsupport'].'"') or die (print_r($bdd->errorInfo()));//requete de selection
$req->execute();
$donnees = $req->fetch();
	

$support=($donnees['typesupport']);

?>
<header>

<h1>Modifier un support</h1>
</br>
</header>
<center>
<section>
<article>
<form id="monform" name="form1" method="POST"  action="updatesupport.php">
	<table border="2" width="600px" height="100px">
	<tr><td>
		<label>Support:</td><td>
		<input type="text" name="support" size="30"  value="<?php echo $support; ?>"autofocus/>
		</td></tr>

	
		<tr><td COLSPAN=3><label>
			<input type="submit"  class="monBouton" name="bModifier" value="Modifier" />
		</label>
	
		<label>
			<input type="reset" class="monBouton"   name="bReset" value="Réinitialiser" />
		</label>

		<label>
			<input type="submit" class="monBouton" name="bAnnuler" value="Annuler" onclick='location.href="support.php"' />
		</label></td></tr></table>
		</center>
	
	
</form>

</article>
</section>
</center>
<?php
}

if(isset($_POST['bModifier']))
{
	// verification d'enregistrement du fichier


	$bdd->exec("UPDATE support SET typesupport='".$_POST['support']."' WHERE idsupport='".$_SESSION['idsupport']."'");

	
	
	if(isset($bdd))
		
			{	echo '<center>';
				echo '<br>La modification à été effectuer.</br>';
				echo '<a href="index.php?support">Retour a la liste</a> </center>';
			}			
  		
  
		else
			{
				echo 'La modification à échouée' ;
	
			}
		
 	
}



?>



</body>
</html>
