<?php
// fichiers prérequis
require 'connexiontp5.php';
require 'fonction.php';

$requete=$pdo->prepare('SELECT idtitre, titre, datetitre FROM ttitres ORDER BY titre');
$requete->execute();

echo '<body bgcolor="#FFFF66">'; // change la couleur du fond d'écran
// echo '<a href="index.html"><h1>Accueil</h1></a></p>';

// table à afficher
echo '<center><table border="1">';
echo '<tr><th>Titre</th> <th>Date d\'inscription</th> <th>Modif</th> <th>Suppr</th></tr>';
while ($donnees = $requete->fetch())
{
	echo '<tr><td>'.$donnees['titre'].'</td> <td>'.$donnees['datetitre'].'</td>';
	echo '<td><a href="indextitre.php?modifiertitre_m&idtitre='.$donnees['idtitre'].'&titre='.$donnees['titre'].'"onclick="return (confirm(\'Etes-vous sur de vouloir modifier ce titre\'))"><img src="images/Modifier42x48.png" alt= "Modif"></a></td>';
	echo '<td><a href="indextitre.php?supprimertitre&amp;idtitre='.$donnees['idtitre'].'"onclick="return (confirm(\'Etes-vous sur de vouloir supprimer ce titre\'))"><img src="images/supprimer45x45.png" alt= "supprimer"></a></td></tr>';	
	// echo '<td><a href="indextitre.php?supprimertitre&amp;idtitre='.$donnees['idtitre'].'"onclick="return (confirm(\'Etes-vous sur de vouloir supprimer ce titre\'))">Suppr</a></td></tr>';
	// <a href="http://ton lien"><img src="ton image.gif" alt= "nom de ton image"></a>
	// <a href="http://www.adressedetonsite.com" title="adresse de ton site.com"><img src="http://www.adressedetonsite.com/tonimage.jpg" alt="tonimage" border="0"></a> 
}
echo '</table>';
// echo '<a href="ajoutTitre.php">Ajouter un titre via une autre page</a></br>';
echo '<a href="indextitre.php?ajoutertitre_m">Ajouter un titre</a></center>';

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
	echo 'Le titre <strong>'.$_GET['titre'].'</strong> a été modifié en <strong>'.$_GET['modiftitre'].'</strong>.</br><center>Cliquez sur <a href="indextitre.php">ICI</a> pour enlever ce message<center>';
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
// echo "<center><p>Copyright &copy; 2014-" . date("Y") . "  Tanguy iepsm.be</p>";
// echo '<center>Page vue '.readfile(PAGE.'.txt').' fois.</center>';
?>
