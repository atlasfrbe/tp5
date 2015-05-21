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

echo '<body bgcolor="#FFFF66">'; // change la couleur du fond d'écran
echo '<center><a href="index.php"><h1>Accueil</h1></a></p>';
// table à afficher
echo '<table border="1">';
echo '<tr><th>Titre</th> <th>Date d\'inscription</th> <th>Modif</th> <th>Suppr</th></tr>';
while ($donnees = $requete->fetch())
{
	echo '<tr><td>'.$donnees['titre'].'</td> <td>'.$donnees['datetitre'].'</td>';
	echo '<td><a href="index.php?modifiertitre_m&idtitre='.$donnees['idtitre'].'&titre='.$donnees['titre'].'"onclick="return (confirm(\'Etes-vous sur de vouloir modifier ce titre\'))">Modif</a></td>';
	echo '<td><a href="index.php?supprimertitre&amp;idtitre='.$donnees['idtitre'].'"onclick="return (confirm(\'Etes-vous sur de vouloir supprimer ce titre\'))">Suppr</a></td></tr>';	

}
echo '</table>';
// echo '<a href="ajoutTitre.php">Ajouter un titre via une autre page</a></br>';
echo '<a href="index.php?ajoutertitre_m">Ajouter un titre</a></center>';

$requete->closeCursor();

// appel de la fonction supprimertitre
if (isset($_GET['supprimertitre']))
	{
		supprimertitre($donnees['idtitre']);
	}
// au retour de la fonction supprimer:
if (isset($_GET['suppression']))
{
	while ($donnees = $requete->fetch())
	{
		echo 'Le titre <strong>'.$donnees['titre'].'</strong> a été supprimé</br>';
	}
}
// appel des fonctions modifiertitre_v (partie vue) et modifiertitre_c (partie controleur)
if (isset($_GET['modifiertitre_m']))
	{
		modifiertitre_v($donnees['idtitre']);
	}
if (isset($_GET['modifiertitre_c']))
	{
		modifiertitre_c($donnees['idtitre']);
	}
// au retour de la fonction modifiertitre_c :
if (isset($_GET['modifierfini']))
{
	// $requete=$pdo->prepare("SELECT idtitre, titre, datetitre FROM ttitres WHERE idtitre='".$idtitre."' ");
	// $requete->execute();
	// while ($donnees = $requete->fetch())
	// {
		// echo 'Le titre <strong>'.$donnees['titre'].'</strong> a été modifié</br>';
	// }
	$titre=$_GET['titre'];
	$modiftitre=$_GET['modiftitre'];
	echo 'Le titre <strong>'.$_GET['titre'].'</strong> a été modifié en <strong>'.$_GET['modiftitre'].'</strong>.</br> Cliquez sur <a href="index.php">Accueil</a> pour enlever ce message';
}
// appel des fonctions ajoutertitre
if (isset($_GET['ajoutertitre_m']))
	{
		ajoutertitre_v();
	}
if (isset($_GET['ajoutertitre_c']))
	{
		ajoutertitre_c();
	}
// affichage du compteur et du copyright
echo "<center><p>Copyright &copy; 2014-" . date("Y") . "  Tanguy iepsm.be</p>";
echo 'Page vue '.readfile(PAGE.'.txt').' fois.</center>';
?>
