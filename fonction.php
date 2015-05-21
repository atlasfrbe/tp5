<?php
// liste des fonctions
function supprimer($idtitre)
{
if (isset($_GET['supprimer']))
	{
		include ('connexiontp5.php');
		$idtitre=$_GET['idtitre'];
		$pdo->exec("DELETE FROM ttitres WHERE idtitre=".$idtitre." ");
		echo 'La suppression a été correctement effectuée</br>';
		echo '<a href="index.php?suppression">Actualiser la liste</a></br>';
	}
}
// ----------------------------------------------------------
function modifiertitre($idtitre)
{
if (isset($_GET['modifier']))
	{
		include ('connexiontp5.php');
		$idtitre=$_GET['idtitre'];
		$html = '<center><form id="monform" name="form1" method="POST"  action="index.php?modifier2">';
		$html.= '<label><input type="hidden" name="idtitre" value="'.$idtitre.'" /> </label>';
		$html.= '<label>Titre :	<input type="text" name="modiftitre" value="'.$_GET['titre'].'" size="60" colspan="2" autofocus /> </label>';
		$html.= '<label><input type="submit" name="bEnregistrer" value="Modifier" /> </label>';
		$html.= '<label><input type="submit" name="bAnnuler" value="Annuler"  /> </label> </form></center>';
		echo $html;
	}
}
function modifiertitre2($idtitre,$nouveautitre)
{
	include ('connexiontp5.php');
	if (isset($_POST['bEnregistrer']))
	{
		$modiftitretitre=$_POST['modiftitre'];
		$idtitre=$_POST['idtitre']; // récupére le paramêtre passé en HIDDEN car raffraichissement de la page par le formulaire
		$pdo->exec("UPDATE ttitres SET titre='".$modiftitretitre."'WHERE idtitre='".$idtitre."' ");
		// echo 'La modification a été correctement effectuée</br>';
		// echo '<a href="index.php?modification">Actualiser la liste</a></br>';
		// sleep(5);
		header('Location: index.php?modification'); 
		//  onclick="return (confirm(\'Le titre est modifie\'))" "javascript:window.opener.refresh(); window.close();"
	}
}
// -----------------------------------------------------------
?>

