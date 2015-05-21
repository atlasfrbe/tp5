<?php
// liste des fonctions
function supprimertitre($idtitre)
{
if (isset($_GET['supprimertitre']))
	{
		include ('connexiontp5.php');
		$idtitre=$_GET['idtitre'];
		$pdo->exec("DELETE FROM ttitres WHERE idtitre=".$idtitre." ");
		echo 'La suppression a été correctement effectuée</br>';
		echo '<a href="index.php?suppression">Actualiser la liste</a></br>';
		header('Location: index.php?suppressionfini'); 
	}
}
// ----------------------------------------------------------
function modifiertitre_v($idtitre)
{
if (isset($_GET['modifiertitre_m']))
	{
		include ('connexiontp5.php');
		$idtitre=$_GET['idtitre'];
		$titre=$_GET['titre'];
		$html = '<center><form id="monform" name="form1" method="POST"  action="index.php?modifiertitre_c">';
		$html.= '<label><input type="hidden" name="idtitre" value="'.$idtitre.'" /> </label>';
		$html.= '<label><input type="hidden" name="titre" value="'.$titre.'" /> </label>';
		$html.= '<label>Titre :	<input type="text" name="modiftitre" value="'.$_GET['titre'].'" size="60" colspan="2" autofocus /> </label>';
		$html.= '<label><input type="submit" name="bEnregistrer" value="Modifier" /> </label>';
		$html.= '<label><input type="submit" name="bAnnuler" value="Annuler"  /> </label> </form></center>';
		
		echo $html;
	}
}
function modifiertitre_c($idtitre)
{
	include ('connexiontp5.php');
	if (isset($_POST['bEnregistrer']))
	{
		$titre=$_POST['titre'];
		$modiftitre=$_POST['modiftitre'];
		$idtitre=$_POST['idtitre']; // récupére le paramêtre passé en HIDDEN car raffraichissement de la page par le formulaire
		$pdo->exec("UPDATE ttitres SET titre='".$modiftitre."'WHERE idtitre='".$idtitre."' ");
		// echo 'La modification a été correctement effectuée</br>';
		// echo '<a href="index.php?modification">Actualiser la liste</a></br>';
		// sleep(5);
		echo '<label><input type="hidden" name="idtitre" value="'.$idtitre.'" /> </label>';
		echo '<label><input type="hidden" name="titre" value="'.$titre.'" /> </label>';
		echo '<label><input type="hidden" name="modiftitre" value="'.$modiftitre.'" /> </label>';
		header('Location: index.php?modifierfini&titre='.$titre.'&modiftitre='.$modiftitre.''); 
		// header('Location: index.php?modifierfini&amp;titre='.$titre.'&amp;modiftitre='.$modiftitre.''); 
		//  onclick="return (confirm(\'Le titre est modifie\'))" "javascript:window.opener.refresh(); window.close();"
	}
}
// -----------------------------------------------------------
function ajoutertitre_v()
{
if (isset($_GET['ajoutertitre_m']))
	{
		include ('connexiontp5.php');
		$html = '<center><form id="monform" name="formajoutertitre" method="POST"  action="index.php?ajoutertitre_c">';
		$html.= '<label>Titre :	<input type="text" name="ajoutertitre"  size="60" colspan="2" autofocus /> </label>';
		$html.= '<label><input type="submit" name="bEnregistrer" value="Ajouter" /> </label>';
		$html.= '<label><input type="submit" name="bAnnuler" value="Annuler"  /> </label> </form></center>';
		echo $html;
	}
}
function ajoutertitre_c()
{
		include ('connexiontp5.php');
		if(isset($_POST['bEnregistrer']))
		{	
			$requeteajouttitre=$pdo->prepare("INSERT INTO ttitres SET titre='".$_POST['ajoutertitre']."',datetitre=now()");
			$requeteajouttitre->execute();
		}
		header('Location: index.php?ajoutfini'); 
}
?>

