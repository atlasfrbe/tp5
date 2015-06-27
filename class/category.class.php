<?php
class Category
{
private $pdo;

public function __construct($dbPdo)
	{
	$this->pdo=$dbPdo;
	}

public function supprimercategorie($idcategorie)
{
		include ('connect/connexiontp5.php');
		$idcategorie=$_GET['idcategorie'];
		// $idtitre=$donnees['idtitre']
		$pdo->exec("DELETE FROM tcategories WHERE idcategorie=".$idcategorie." ");
		// echo '<a href="index.php?suppression">Actualiser la liste</a></br>';
		// header('Location: index.php?suppressionfini'); 

}
// ----------------------------------------------------------

function modifiertitre_c($idtitre)
{
	include ('connect/connexiontp5.php');
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
		header('Location: indextitre.php?modifierfini&titre='.$titre.'&modiftitre='.$modiftitre.''); 
		// header('Location: indextitre.php?modifierfini&amp;titre='.$titre.'&amp;modiftitre='.$modiftitre.''); 
		//  onclick="return (confirm(\'Le titre est modifie\'))" "javascript:window.opener.refresh(); window.close();"
	}
}
// -----------------------------------------------------------
// function ajoutertitre_v()
// {
	// include ('connect/connexiontp5.php');
	// $html = '<center><form id="monform" name="formajoutertitre" method="POST"  action="indextitre.php?ajoutertitre_c">';
	// $html.= '<label>Titre :	<input type="text" name="ajoutertitre"  size="60" colspan="2" autofocus /> </label>';
	// $html.= '<label><input type="submit" name="bAjouterTitre" value="Ajouter" /> </label>';
	// $html.= '<label><input type="submit" name="bAnnuler" value="Annuler"  /> </label> </form></center>';
	// echo $html;

// }
// function ajoutertitre_c()
// {
	// include ('connect/connexiontp5.php');
	// if(isset($_POST['bAjouterTitre']))
	// {	
		// $requeteajouttitre=$pdo->prepare("INSERT INTO ttitres SET titre='".$_POST['ajoutertitre']."',datetitre=now()");
		// $requeteajouttitre->execute();
	// }
	// header('Location: indextitre.php?ajoutfini'); 
// }
}
?>

