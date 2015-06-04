<?php
// liste des fonctions


// ======================================================================
	FONCTIONS EN RAPPORT AVEC LE TITRE
// ======================================================================
function supprimertitre($idtitre)
{
if (isset($_GET['supprimertitre']))
	{
		include ('connect/connexiontp5.php');
		$idtitre=$_GET['idtitre'];
		$pdo->exec("DELETE FROM ttitres WHERE idtitre=".$idtitre." ");
		echo 'La suppression a été correctement effectuée</br>';
		echo '<a href="indextitre.php?suppression">Actualiser la liste</a></br>';
		header('Location: indextitre.php?suppressionfini'); 
	}
}
// ----------------------------------------------------------
function modifiertitre_v($idtitre)
{
if (isset($_GET['modifiertitre_m']))
	{
		include ('connect/connexiontp5.php');
		$idtitre=$_GET['idtitre'];
		$titre=$_GET['titre'];
		$html = '<center><form id="monform" name="form1" method="POST"  action="indextitre.php?modifiertitre_c">';
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
function ajoutertitre_v()
{
if (isset($_GET['ajoutertitre_m']))
	{
		include ('connect/connexiontp5.php');
		$html = '<center><form id="monform" name="formajoutertitre" method="POST"  action="indextitre.php?ajoutertitre_c">';
		$html.= '<label>Titre :	<input type="text" name="ajoutertitre"  size="60" colspan="2" autofocus /> </label>';
		$html.= '<label><input type="submit" name="bEnregistrer" value="Ajouter" /> </label>';
		$html.= '<label><input type="submit" name="bAnnuler" value="Annuler"  /> </label> </form></center>';
		echo $html;
	}
}
function ajoutertitre_c()
{
		include ('connect/connexiontp5.php');
		if(isset($_POST['bEnregistrer']))
		{	
			$requeteajouttitre=$pdo->prepare("INSERT INTO ttitres SET titre='".$_POST['ajoutertitre']."',datetitre=now()");
			$requeteajouttitre->execute();
		}
		header('Location: indextitre.php?ajoutfini'); 
}
// ======================================================================
		FONCTIONS EN RAPPORT AVEC LA PERSONNE
// ======================================================================

function supprimerpersonne($idpersonne)
{
if (isset($_GET['supprimerpersonne']))
	{
		include ('connect/connexiontp5.php');
		$idpersonne=$_GET['idpersonne'];
		$pdo->exec("DELETE FROM tpersonnes WHERE idpersonne=".$idpersonne." ");
		echo 'La suppression a été correctement effectuée</br>';
		echo '<a href="indexpersonne.php?suppression">Actualiser la liste</a></br>';
		header('Location: indexpersonne.php?suppressionfini'); 
	}
}
// ----------------------------------------------------------
function modifierpersonne_v($idpersonne)
{
if (isset($_GET['modifierpersonne_m']))
	{
		include ('connect/connexiontp5.php');
		$idpersonne=$_GET['idpersonne'];
		$nom=$_GET['nom'];
		$prenom=$_GET['prenom'];
		$telephone=$_GET['telephone'];
		$gsm=$_GET['gsm'];
		$html = '<center><form id="monform" name="form1" method="POST"  action="indexpersonne.php?modifierpersonne_c">';
		$html.= '<label><input type="hidden" name="idpersonne" value="'.$idpersonne.'" /> </label>';
		$html.= '<label><input type="hidden" name="nom" value="'.$nom.'" /> </label>';
		$html.= '<label><input type="hidden" name="prenom" value="'.$prenom.'" /> </label>';
		$html.= '<label><input type="hidden" name="telephone" value="'.$telephone.'" /> </label>';
		$html.= '<label><input type="hidden" name="gsm" value="'.$gsm.'" /> </label>';
		$html.= '<label>Nom :	<input type="text" name="modifnom" value="'.$_GET['nom'].'" size="60" colspan="2" autofocus /> </label>';
		$html.= '<label>Prenom :	<input type="text" name="modifprenom" value="'.$_GET['prenom'].'" size="60" colspan="2" /> </label>';
		$html.= '<label>Telephone :	<input type="text" name="modifprenom" value="'.$_GET['prenom'].'" size="60" colspan="2" /> </label>';
		$html.= '<label>GSM :	<input type="text" name="modifprenom" value="'.$_GET['prenom'].'" size="60" colspan="2" /> </label>';
		$html.= '<label><input type="submit" name="bEnregistrer" value="Modifier" /> </label>';
		$html.= '<label><input type="submit" name="bAnnuler" value="Annuler"  /> </label> </form></center>';
		
		echo $html;
	}
}
function modifierpersonne_c($idpersonne)
{
	include ('connect/connexiontp5.php');
	if (isset($_POST['bEnregistrer']))
	{
		$nom=$_POST['nom'];
		$modifnom=$_POST['modifnom'];
		$idpersonne=$_POST['idpersonne']; // récupére le paramêtre passé en HIDDEN car raffraichissement de la page par le formulaire
		$pdo->exec("UPDATE tpersonnes SET nom='".$modifnom."'WHERE idtitre='".$idpersonne."' ");
		// echo 'La modification a été correctement effectuée</br>';
		// echo '<a href="index.php?modification">Actualiser la liste</a></br>';
		// sleep(5);
		echo '<label><input type="hidden" name="idpersonne" value="'.$idpersonne.'" /> </label>';
		echo '<label><input type="hidden" name="nom" value="'.$nom.'" /> </label>';
		echo '<label><input type="hidden" name="modifnom" value="'.$modifnom.'" /> </label>';
		header('Location: indextitre.php?modifierfini&titre='.$titre.'&modiftitre='.$modiftitre.''); 
		// header('Location: indextitre.php?modifierfini&amp;titre='.$titre.'&amp;modiftitre='.$modiftitre.''); 
		//  onclick="return (confirm(\'Le titre est modifie\'))" "javascript:window.opener.refresh(); window.close();"
	}
}
// -----------------------------------------------------------
function ajouterpersonne_v()
{
if (isset($_GET['ajouterpersonne_m']))
	{
		include ('connect/connexiontp5.php');
		$html = '<center><form id="monform" name="formajouterpersonne" method="POST"  action="indexpersonne.php?ajouterpersonne_c">';
		$html.= '<label>Nom :	<input type="text" name="nom"  size="30" colspan="2" autofocus /> </label>';
		$html.= '<label>Prenom :	<input type="text" name="prenom"  size="30" colspan="2"  /> </label></br>';
		$html.= '<label>adresse :	<input type="text" name="adresse"  size="50" colspan="2"  /> </label></br>';
		$html.= '<label>code postal :	<input type="text" name="codepostal"  size="10" colspan="2"  /> </label>';
		$html.= '<label>localité :	<input type="text" name="localite"  size="60" colspan="2"  /> </label></br>';
		$html.= '<label>Téléphone :	<input type="text" name="telephone"  size="14" colspan="2"  /> </label>';
		$html.= '<label>GSM :	<input type="text" name="gsm"  size="14" colspan="2"  /> </label>';
		$html.= '<label><input type="submit" name="bEnregistrer" value="Ajouter" /> </label>';
		$html.= '<label><input type="submit" name="bAnnuler" value="Annuler"  /> </label> </form></center>';
		echo $html;
	}
}
function ajouterpersonne_c()
{
		include ('connect/connexiontp5.php');
		if(isset($_POST['bEnregistrer']))
		{	
			$requeteajouttitre=$pdo->prepare("INSERT INTO tpersonnes SET nom='".$_POST['nom']."',prenom='".$_POST['prenom']."',adresse='".$_POST['adresse']."',codepostal='".$_POST['codepostal']."',localite='".$_POST['localite']."',telephone='".$_POST['telephone']."',gsm='".$_POST['gsm']."' ");
			$requeteajouttitre->execute();
		}
		header('Location: indexpersonne.php?ajoutfini'); 
}

?>

