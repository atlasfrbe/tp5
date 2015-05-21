<?php
// fichiers prérequis
require 'connexiontp5.php';
require 'fonction.php';

// instauration d'un compteur
define ('PAGE','index.html');
$nombre=1;
if(file_exists(PAGE.'.txt')){
$nombre=file_get_contents(PAGE.'.txt');
if(is_numeric($nombre)){$nombre++;}
}
file_put_contents(PAGE.'.txt',$nombre);
//fin compteur

$requete=$pdo->prepare('SELECT idtitre, titre, datetitre FROM ttitres ORDER BY titre');
$requete->execute();

// table à afficher
echo '<center><table border="1">';
echo '<tr><th>Titre</th> <th>Date d\'inscription</th> <th>Modif</th> <th>Suppr</th></tr>';
while ($donnees = $requete->fetch())
{
	echo '<tr><td>'.$donnees['titre'].'</td> <td>'.$donnees['datetitre'].'</td>';
	echo '<td><a href="index.php?modifier&amp;idtitre='.$donnees['idtitre'].'&amp;titre='.$donnees['titre'].'"onclick="return (confirm(\'Etes-vous sur de vouloir modifier ce titre\'))">Modif</a></td>';
	echo '<td><a href="index.php?supprimer&amp;idtitre='.$donnees['idtitre'].'"onclick="return (confirm(\'Etes-vous sur de vouloir supprimer ce titre\'))">Suppr</a></td></tr>';	

}
echo '</table>';
echo '<a href="ajoutTitre.php">Ajouter un titre</a></center>';

$requete->closeCursor();

// appel de la fonction supprimer
if (isset($_GET['supprimer']))
	{
		supprimer($donnees['idtitre']);
	}
// au retour de la fonction supprimer:
if (isset($_GET['suppression']))
{
	while ($donnees = $requete->fetch())
	{
		echo 'Le titre <strong>'.$donnees['titre'].'</strong> a été supprimé</br>';
	}
}
// appel de la fonction modifiertitre (partie formulaire) et modifiertitre2 (partie UPDATE)
if (isset($_GET['modifier']))
	{
		modifiertitre($donnees['idtitre']);
	}
if (isset($_GET['modifier2']))
	{
		modifiertitre2($donnees['idtitre']);
	}
// au retour de la fonction modifiertitre2 :
if (isset($_GET['modification']))
{
	while ($donnees = $requete->fetch())
	{
		echo 'Le titre <strong>'.$donnees['titre'].'</strong> a été modifié</br>';
	}
}
	
// affichage du compteur et du copyright
echo "<center><p>Copyright &copy; 2014-" . date("Y") . " iepsm.be</p></center>";
echo 'Page vue '.readfile(PAGE.'.txt').' fois.';
?>
