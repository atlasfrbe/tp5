<?php
// fichiers prérequis
require 'connexiontp5.php';
require 'fonction.php';

$requete=$pdo->prepare('SELECT idpersonne, nom, prenom, telephone, gsm FROM tpersonnes ORDER BY nom');
$requete->execute();

echo '<body bgcolor="#FFFF66">'; // change la couleur du fond d'écran
// echo '<a href="index.html"><h1>Accueil</h1></a></p>';

// table à afficher
echo '<center><table border="1">';
echo '<tr><th>Nom</th> <th>Prenom</th> <th>Telephone</th> <th>GSM</th> <th>Modif</th> <th>Suppr</th></tr>';
while ($donnees = $requete->fetch())
{
	echo '<tr><td>'.$donnees['nom'].'</td> <td>'.$donnees['prenom'].'</td>';
	echo '<td>'.$donnees['telephone'].'</td> <td>'.$donnees['gsm'].'</td>';
	echo '<td><a href="indextitre.php?modifiertitre_m&idtitre='.$donnees['idpersonne'].'&titre='.$donnees['nom'].'"onclick="return (confirm(\'Etes-vous sur de vouloir modifier ce titre\'))"><img src="images/Modifier42x48.png" alt= "Modif"></a></td>';
	echo '<td><a href="indextitre.php?supprimertitre&amp;idtitre='.$donnees['idpersonne'].'"onclick="return (confirm(\'Etes-vous sur de vouloir supprimer ce titre\'))"><img src="images/supprimer45x45.png" alt= "supprimer"></a></td></tr>';	
	// echo '<td><a href="indextitre.php?supprimertitre&amp;idtitre='.$donnees['idtitre'].'"onclick="return (confirm(\'Etes-vous sur de vouloir supprimer ce titre\'))">Suppr</a></td></tr>';
	// <a href="http://ton lien"><img src="ton image.gif" alt= "nom de ton image"></a>
	// <a href="http://www.adressedetonsite.com" title="adresse de ton site.com"><img src="http://www.adressedetonsite.com/tonimage.jpg" alt="tonimage" border="0"></a> 
}
echo '</table>';
// echo '<a href="ajoutTitre.php">Ajouter un titre via une autre page</a></br>';
echo '<a href="indexpersonne.php?ajouterpersonne_m">Ajouter une personne</a></center>';

$requete->closeCursor();

// appel de la fonction supprimerpersonne
if (isset($_GET['supprimerpersonne']))
	{
		supprimerpersonne($donnees['idpersonne']);
	}
// au retour de la fonction supprimer:
if (isset($_GET['suppression']))
{
	while ($donnees = $requete->fetch())
	{
		echo 'La personne <strong>'.$donnees['titre'].'</strong> a été supprimée de la liste</br>';
	}
}
// appel des fonctions modifierpersonne_v (partie vue) et modifierpersonne_c (partie controleur)
if (isset($_GET['modifierpersonne_m']))
	{
		modifierpersonne_v($donnees['idtitre']);
	}
if (isset($_GET['modifierpersonne_c']))
	{
		modifierpersonne_c($donnees['idpersonne']);
	}
// au retour de la fonction modifierpersonne_c :
if (isset($_GET['modifierfini']))
{
	// $requete=$pdo->prepare("SELECT idtitre, titre, datetitre FROM ttitres WHERE idtitre='".$idtitre."' ");
	// $requete->execute();
	// while ($donnees = $requete->fetch())
	// {
		// echo 'Le titre <strong>'.$donnees['titre'].'</strong> a été modifié</br>';
	// }
	$nom=$_GET['nom'];
	$modifnom=$_GET['modifnom'];
	echo 'La personne nommée <strong>'.$_GET['titre'].'</strong> a été modifié en <strong>'.$_GET['modifnom'].'</strong>.</br><center>Cliquez sur <a href="indexpersonne.php">ICI</a> pour enlever ce message<center>';
}
// appel des fonctions ajouterpersonne
if (isset($_GET['ajouterpersonne_m']))
	{
		ajouterpersonne_v();
	}
if (isset($_GET['ajouterpersonne_c']))
	{
		ajouterpersonne_c();
	}
// affichage du compteur et du copyright
// echo "<center><p>Copyright &copy; 2014-" . date("Y") . "  Tanguy iepsm.be</p>";
// echo '<center>Page vue '.readfile(PAGE.'.txt').' fois.</center>';
?>
