<?php
session_start();
require ('connect/connexiontp5.php');
include ('class/user.class.php');
include ('class/title.class.php');
include ('class/category.class.php');
// print_r($_SESSION);
// echo '<br />';
// echo md5('1234');
//************
function htm($data)
	{
	$rep=htmlentities($data, ENT_QUOTES, "UTF-8");
	return $rep;
	}
//************
?>
<!DOCTYPE HTML>
<html>
<head>
	<title> TP5 de Tanguy </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<!-- <style type="text/css"> </style> -->
</head>

<body>
    <header>
		<div id="header">	<!-- l'en-tête -->
			<div class="center">
				<br/>
				<h1>Videotheque de Tanguy</h1>
				<h2>TP5</h2>
			</div>
		</div>
	</header>
<?php
if (isset($_GET['addUser']))	// pour ajouter un login et un mot de passe de connexion
	{
	if ($_GET['addUser']=="oui")
		{
		$html='<form method="POST" action="index.php?addUser=record"><table>';
		$html.='<tr><th colspan="2"></th>Ajout d\'un utilisateur</th></tr>';
		$html.='<tr><th>Login :</th><td><input type="text" name="nom"></td></tr>';
		$html.='<tr><th>Password :</th><td><input type="password" name="password"></td></tr>';
		$html.='<tr><td colspan="2"><input type="submit" name="bValider" value="Valider"></td></tr>';
		$html.='</table></form>';
		}
	else if ($_GET['addUser']=="record")
		{
		$user = new User($pdo);
		$user->nouvelUtilisateur($_POST['nom'],md5($_POST['password']));
		$html='Login introduit avec transformation UTF 8: '.htm($_POST['nom']).'<br />';
		$html.='Login introduit sans transformation UTF 8: '.$_POST['nom'].'<br />';
		$html.='Mot de passe associé : '.$_POST['password'].'<br />';
		$html.='<a href="?login">Retour</a>';
		}
	}

else if (isset($_GET['login']))	// si le login est encodé
	{
	if((isset($_POST['login']))&&(isset($_POST['pwd'])))	// et que le mot de passe l'est aussi
		{
		$user=new User($pdo);
		$html=$user->login($_POST['login'],md5($_POST['pwd']));
		}		
	else if (!isset($_SESSION['idpersonne']))	// si pas de session utilisateur
		{
		// formulaire de connexion	
		$html ='<center><form method="POST" name="formLogin" action="?login"><table>';
		$html.='<tr><th>Login</th><td><input type="text" name="login"></td></tr>';
		// pas d'autofocus pour ne pas aider les bots
		$html.='<tr><th>Password</th><td><input type="password" name="pwd"></td></tr>';
		$html.='<tr><td colspan="2"><input type="submit" name="bsubmitLogin" value="Se connecter"></td></tr>';
		$html.='</table></form></center>';			
		}
	else
		{
		$html ='<center>Vous êtes identifié.</center><br />';
		$html.='<a href="?donnees=modifier&idpersonne='.$_SESSION['idpersonne'].'">Modifier mon mot de passe</a><br />';
		}
	}

else if (isset($_GET['donnees']))
	{
	$action=$_GET['donnees'];
	switch ($action)
		{
		case 'modifier':	//	tableau pour modifier son mot de passe
			$user = NEW User($pdo);
			$data=$user->getInfoUserById($_GET['idpersonne']);
			$html='<form method="POST" name="formModifUser" action="?donnees=recModifs&idpersonne='.$_SESSION['idpersonne'].'"><table>';
			$html.='<tr><th>Login</th><th>Ancien mot de passe</th><th>Nouveau mot de passe</th><th>Nouveau mot de passe (vérif.)</th></tr>';
			while ($row=$data->fetch())
				{
				$html.='<tr><td><input type="text" name="login" value="'.$row['login'].'"></td>';
				$html.='<td><input type="password" name="oldPwd"></td>';
				$html.='<td><input type="password" name="newPwd"></td>';
				$html.='<td><input type="password" name="newPwd2"></td></tr>';
				}
			$html.='<tr><td colspan="4"><input type="submit" value="Modifier"></td></tr>';
			$html.='</table></form>';
			break;
		case 'recModifs':	//	modification de son mot de passe et erreur rapportée le cas échéant
			$user = NEW User($pdo);
			$data=$user->recModifsUser($_GET['idpersonne'], $_POST['login'], md5($_POST['oldPwd']), $_POST['newPwd'], $_POST['newPwd2']);
			switch($data)
				{
				case 1 :
					$html='Données modifiées correctement<br />';
					$html.='<a href="?index.php&login">Retour</a>';
					break;
				case 2 :
					$html='Erreur';
					break;
				case 3 :
					$html='Erreur dans le nouveau mot de passe';
					break;
				}
			break;
		case 'listepersonne':
			$i=0;
			$html='<center><h3>Liste des utilisateurs</h3>';
			// $html.='<table>';
			// $html.='<tr><th>Login</th><th>Action</th></tr>';
			$html.= '<table border="1" bgcolor="#FFFF66">';
			$html.= '<tr><th>login</th> <th>Nom</th> <th>Prenom</th> <th>Telephone</th> <th>GSM</th> <th>Modif</th> <th>Suppr</th></tr>';
			
			$user=NEW User($pdo);		// instancie l'objet User avec $pdo (identifiants de la base de données)
			$data=$user->getUsers();	// lance la fonction getUsers de l'objet ci dessus
			while ($row=$data->fetch()){
				$html.='<tr><td>'.$row['login'].'</td>';
				$html.='<td>'.$row['nom'].'</td>';
				$html.='<td>'.$row['prenom'].'</td>';
				$html.='<td>'.$row['telephone'].'</td>';
				$html.='<td>'.$row['gsm'].'</td>';
				// $html.='<td><a href="?donnees=modifUser&idUser='.$row['idpersonne'].'&num='.$i.'">Modifier</a></td>';
				$html.='<td><a href="?donnees=modifUser&idpersonne='.$row['idpersonne'].'&num='.$i.'"onclick="return (confirm(\'Etes-vous sur de vouloir modifier cette personne\'))"><img src="images/Modifier42x48.png" alt= "Modif"></a></td>';
				$html.='<td><a href="?supprimerpersonne&idpersonne='.$row['idpersonne'].'"onclick="return (confirm(\'Etes-vous sur de vouloir supprimer cette personne\'))"><img src="images/supprimer45x45.png" alt= "supprimer"></a></td></tr>';
				$i++;
			}
			$html.='</table>';
			// $html.='<h2>OU</h2>';
			// $html.='<form method="POST" action="index.php?addUser=record"><table>';
			// $html.='<tr><th colspan="2"></th>Ajout d\'un utilisateur</th></tr>';
			// $html.='<tr><th>Login :</th><td><input type="text" name="nom"></td></tr>';
			// $html.='<tr><th>Password :</th><td><input type="password" name="password"></td></tr>';
			// $html.='<tr><td colspan="2"><input type="submit" name="bValider" value="Valider"></td></tr>';
			// $html.='</table></form>';
			break;
		case 'modifUser':
			$html='<h2>Modification d\'un utilisateur</h2>';
			$user = NEW User($pdo);
			$data=$user->getUserFromId($_GET['idpersonne']);
			$html.='<form method="POST" name="fModifUser" action="?donnees=afficheModifUser">';
			$html.='<table border="1" bgcolor="#FFFF66">';
			$html.='<tr><th>login</th> <th>Nom</th> <th>Prenom</th> <th>Telephone</th> <th>GSM</th></tr>';
			while($row=$data->fetch()){
				$html.='<tr><td><input type="text" name="login" value="'.$row['login'].'"></td>';
				$html.='<td><input type="text" name="nom" value="'.$row['nom'].'"></td>';
				$html.='<td><input type="text" name="nom" value="'.$row['prenom'].'"></td>';
				$html.='<td><input type="text" name="nom" value="'.$row['telephone'].'"></td>';
				$html.='<td><input type="text" name="nom" value="'.$row['gsm'].'"></td>';
				$html.='<td><input type="submit" value="Enregistrer">';
				$html.='<input type="hidden" name="login" value="'.$row['login'].'">';
				$html.='<input type="hidden" name="nom" value="'.$row['nom'].'">';
				$html.='<input type="hidden" name="prenom" value="'.$row['prenom'].'">';
				$html.='<input type="hidden" name="telephone" value="'.$row['telephone'].'">';
				$html.='<input type="hidden" name="gsm" value="'.$row['gsm'].'">';
				$html.='<input type="hidden" name="idpersonne" value="'.$row['idpersonne'].'"></td></tr>';
			}
			$html.='</table></form>';
			break;
		case 'afficheModifUser' :
			$user=NEW User($pdo);
			$user->updateUser($_POST['idpersonne'], $_POST['login']);
			$html='Modifications sauvegardées. <br />';
			$html.='<a href="?donnees=listepersonne">Retour liste utilisateurs</a>';
			break;
		case 'deco' :
			unset ($_SESSION['idpersonne']);
			session_destroy();
			header('Location: index.php?login');
			break;
		// ---------------------------------------------------------------------	
		// action en fonction du TITRE	
		case 'listetitre' :
			$requete=$pdo->prepare('SELECT idtitre, titre, datetitre FROM ttitres ORDER BY titre');
			$requete->execute();
			$html= '<center><table border="1" bgcolor="#FFFF66">';
			$html.= '<tr><th>Titre</th> <th>Date d\'inscription</th> <th>Modif</th> <th>Suppr</th></tr>';
			while ($donnees = $requete->fetch())
			{
				$html.= '<tr><td>'.$donnees['titre'].'</td> <td>'.$donnees['datetitre'].'</td>';
				$html.= '<td><a href="?donnees=modifiertitre&idtitre='.$donnees['idtitre'].'&titre='.$donnees['titre'].'"onclick="return (confirm(\'Etes-vous sur de vouloir modifier ce titre\'))"><img src="images/Modifier42x48.png" alt= "Modif"></a></td>';
				$html.= '<td><a href="index.php?supprimertitre&amp;idtitre='.$donnees['idtitre'].'&titre='.$donnees['titre'].'"onclick="return (confirm(\'Etes-vous sur de vouloir supprimer ce titre\'))"><img src="images/supprimer45x45.png" alt= "supprimer"></a></td></tr>';	
			}
			$html.= '</table>';
			$html.= '<a href="?donnees=ajoutertitre">Ajouter un titre</a></center>';
			$requete->closeCursor();	// ferme la requête au niveau du serveur mais permet de la rééxécuter
			break;
		case 'modifiertitre' :
			if (isset($_GET['titre']))
			{
				$_SESSION['idtitre']=$_GET['idtitre'];
				$_SESSION['titre']=$_GET['titre'];
				$html = '<center><form id="monformmodifiertitre" name="form1" method="POST"  action="?donnees=modifiertitre">';
				$html.= '<label>Titre :	<input type="text" name="modiftitre" value="'.$_GET['titre'].'" size="60" colspan="2" autofocus /> </label>';
				$html.= '<label><input type="submit" name="bModifierTitre" value="Modifier" /> </label>';
				$html.= '<label><input type="submit" name="bAnnuler" value="Annuler"  /> </label> </form></center>';
			}
			if (isset($_POST['bModifierTitre']))
			{
				$pdo->exec("UPDATE ttitres SET titre='".$_POST['modiftitre']."'WHERE idtitre='".$_SESSION['idtitre']."' ");
				$html = '<center>Le titre <strong>'.$_SESSION['titre'].'</strong> a été modifié en <strong>'.$_POST['modiftitre'].'</strong>.</br>Cliquez sur <a href="index.php">ACCUEIL</a> pour enlever ce message</center>';
			}
			break;
		case 'ajoutertitre' :
			$html = '<center><form id="monformajoutertitre" name="formajoutertitre" method="POST"  action="?donnees=ajoutertitre">';
			$html.= '<label>Titre :	<input type="text" name="newtitre"  size="60" colspan="2" autofocus /> </label>';
			$html.= '<label><input type="submit" name="bAjouterTitre" value="Ajouter" /> </label>';
			$html.= '<label><input type="submit" name="bAnnuler" value="Annuler"  /> </label> </form></center>';
			if (isset($_POST['bAjouterTitre']))
			{	
				// on execute la requete ajoutant le titre du formulaire
				$requeteajouttitre=$pdo->prepare("INSERT INTO ttitres SET titre='".$_POST['newtitre']."',datetitre=now()");
				$requeteajouttitre->execute();
				header('Location: index.php?donnees=listetitre'); 
			}
			if (isset($_POST['bAnnuler']))
				{
				header('Location: index.php'); 
				}
			break;
		//-----------------------------------------------------------------------
		// action en rapport avec la CATEGORIE
		case 'listecategorie' :
			$requete=$pdo->prepare('SELECT idcategorie, categorie FROM tcategories ORDER BY categorie');
			$requete->execute();
			$html= '<center><table border="1" bgcolor="#FFFF66">';
			$html.= '<tr><th>categorie</th> <th>Modif</th> <th>Suppr</th></tr>';
			while ($donnees = $requete->fetch())
			{
				$html.= '<tr><td>'.$donnees['categorie'].'</td>';
				$html.= '<td><a href="?donnees=modifiercategorie&idcategorie='.$donnees['idcategorie'].'&categorie='.$donnees['categorie'].'"onclick="return (confirm(\'Etes-vous sur de vouloir modifier cette categorie\'))"><img src="images/Modifier42x48.png" alt= "Modif"></a></td>';
				$html.= '<td><a href="index.php?supprimercategorie&amp;idcategorie='.$donnees['idcategorie'].'&categorie='.$donnees['categorie'].'"onclick="return (confirm(\'Etes-vous sur de vouloir supprimer cette categorie\'))"><img src="images/supprimer45x45.png" alt= "supprimer"></a></td></tr>';	
			}
			$html.= '</table>';
			$html.= '<a href="?donnees=ajoutercategorie">Ajouter une categorie</a></center>';
			$requete->closeCursor();
			break;
		case 'listecategorie2' :
			$html = '<center><table border="1" bgcolor="#FFFF66">';
			$html.= '<tr><th>Catégories</th><th colspan=2>Action</th><th>Nombre de titres</th></div>';
			$requete=$pdo->prepare ('SELECT * FROM tcategories GROUP BY idcategorie') or die (print_r($pdo->errorInfo()));
			$requete->execute();
			while ($donnees = $requete->fetch())
			{
				$html.= '<tr><td>'.$donnees['categorie'].'</td>';
			
				$html.= '<td><a href="?donnees=modifiercategorie&idcategorie='.$donnees['idcategorie'].'&categorie='.$donnees['categorie'].'"onclick="return (confirm(\'Etes-vous sur de vouloir modifier cette categorie\'))"><img src="images/Modifier42x48.png" alt= "Modif"></a></td>';
				$html.= '<td><a href="index.php?supprimercategorie&amp;idcategorie='.$donnees['idcategorie'].'&categorie='.$donnees['categorie'].'"onclick="return (confirm(\'Etes-vous sur de vouloir supprimer cette categorie\'))"><img src="images/supprimer45x45.png" alt= "supprimer"></a></td>';

				$requete2=$pdo->prepare ('SELECT COUNT(idtitre) AS NbrTitre FROM titreetcategorie WHERE idcategorie ="'.$donnees['idcategorie'].'"') or die (print_r($pdo->errorInfo()));
				$requete2->execute();
				while ($donnees = $requete2->fetch())
				{
					$html.= '<td><center>'.$donnees['NbrTitre'].'</center></td></tr>';
				}	
			}
			$html.= '</table>';
			$html.= '<a href="?donnees=ajoutercategorie">Ajouter une catégorie</a></center>';
			$requete->closeCursor();
			break;
		case 'ajoutercategorie' :
			$html = '<center><form id="monformajoutercategorie" name="formajoutercategorie" method="POST"  action="?donnees=ajoutercategorie">';
			$html.= '<label>Catégorie :	<input type="text" name="newcategorie"  size="60" colspan="2" autofocus /> </label>';
			$html.= '<label><input type="submit" name="bAjouterCategorie" value="Ajouter" /> </label>';
			$html.= '<label><input type="submit" name="bAnnuler" value="Annuler"  /> </label> </form></center>';
			if (isset($_POST['bAjouterCategorie']))
			{	
				// on execute la requete ajoutant la catégorie du formulaire
				$requeteajoutcategorie=$pdo->prepare("INSERT INTO tcategories SET categorie='".$_POST['newcategorie']."'");
				$requeteajoutcategorie->execute();
				header('Location: index.php?donnees=listecategorie2'); 
			}
			if (isset($_POST['bAnnuler']))
				{
				header('Location: index.php'); 
				}
			break;	
		}
	}
else
	{
	$html='<a href="index.php?login">S\'identifier</a>';
	}
//************************************************************************
//	Utilisation de 	IF à la place de CASE pour montrer la possibilité

	// appel de la fonction supprimertitre
	if (isset($_GET['supprimertitre']))
	{
		$title = NEW Title($pdo);
		$data =$title->supprimertitre($_GET['idtitre']);
		$html = 'La suppression a été correctement effectuée</br>';
		$html.= 'Le titre <strong>'.$_GET['titre'].'</strong> a été supprimé</br>';
	}
	// appel de la fonction supprimerpersonne
	if (isset($_GET['supprimerpersonne']))	
	{
		$user = NEW user($pdo);
		$data =$user->supprimerpersonne($_GET['idpersonne']);
		$html = 'La suppression a été correctement effectuée</br>';
		$html.= 'La personne avec l\'ID <strong>'.$_GET['idpersonne'].'</strong> a été supprimée</br>';		
	}
	// appel de la fonction supprimercategorie
	if (isset($_GET['supprimercategorie']))	
	{
		$categorie = NEW Category($pdo);
		$data =$categorie->supprimercategorie($_GET['idcategorie']);
		$html = 'La suppression a été correctement effectuée</br>';
		$html.= 'La catégorie avec l\'ID <strong>'.$_GET['idcategorie'].'</strong> a été supprimée</br>';		
	}	
	
	
	// if (isset($_GET['cat']))//partie affichage par categorie
	// {	
		// $requete=req_tri('categorie', $_GET['cat']);//fonction tri

		// $html = '<center><table border="1" >';
		// $html.= '<tr><th class="entete">Titres</th><th class="entete" >Durée</th><th class="entete" width="20%">Date d\'enregistrement</th><th class="entete" width="20%">Date de sortie</th><th class="entete" width="20%">Catégorie</th><th class="entete" width="13%">Support</th><th colspan=2><img src="image/parametre.gif" alt="parametre"></th></div>';
		// while ($donnees = $requete->fetch())
		// {
			// $req=$pdo->prepare('SELECT distinct typesupport FROM v_titre_cat4 WHERE titre="'.$donnees['titre'].'"') or die (print_r($pdo->errorInfo()));
			// $req->execute();

			// $result = $req->fetchAll(PDO::FETCH_COLUMN);

			// $typesupport = implode(" ", $result);
			
			// $html.= '<tr><td>'.$donnees['titre'].'</td>';
			// $html.= '<td>'.$donnees['duree'].'</td>';
			// $date=date_create ($donnees['dateinscription']);
			// $html.= '<td>'.date_format($date, "d-m-Y G:h:i").'</td>';
			// $sortie=date_create($donnees['datesortie']);
			// $html.= '<td>'.date_format($sortie, "d-m-Y").'</td>';
			// $html.= '<td>'.$donnees['categorie'].'</td>';
			// $html.= '<td>'.$typesupport.'</td>';
			// $html.= '<td><a href="updatetitre.php?id='.$donnees['idtitres'].'"><center><img src="image/modifier2.png" alt="modifier"></a></center></td>';
			// $html.= '<td class="cointableau"><a href="delete.php?titre='.$donnees['titre'].'" onclick="return(confirm(\'Etes-vous sur de vouloir supprimer cette entrée?\'))"><center><img src="image/supprimer2.png" alt="supprimer"></a></center></td></tr>';
			// }
			// $html.= '</table></center>';
			// $requete->closeCursor();
		// }

//****************************************************************************************	
	
if (isset($_SESSION['idpersonne']))		// on cache le menu si pas de session utilisateur
{
?>		
		<!-- Le menu -->
		<nav>
		<div class="containermenu">
            <ul id="nav">	<!-- principaux liens de navigation -->
				<!-- décommenter le lien ci dessous pour passer de version locale a en ligne: -->
                <li><a href="index.php">Accueil</a></li>
				<li><a href="#s1">Titres</a>
                    <span id="s1"></span>
                    <ul class="subs">
                        <li><a href="?donnees=listetitre">Liste des titres</a>
                            <ul>
                                <li><a href="?donnees=listetitre">afficher la liste des titres</a></li>
                            </ul>
                        </li>
                        <li><a href="#">gestion des titres</a>
                            <ul>
                                <li><a href="?donnees=ajoutertitre">Ajouter un titre</a></li>
                                <li><a href="?donnees=listetitre">Modifier  ou supprimer un titre</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="active"><a href="#s2">Personnes</a>
                    <span id="s2"></span>
                    <ul class="subs">
                        <li><a href="#">Liste des personnes</a>
                            <ul>
                                <li><a href="?donnees=listepersonne">afficher la liste des personnes</a></li>
                                <li><a href="#">Submenu y</a></li>
                            </ul>
                        </li>
                        <li><a href="#">gestion des personnes</a>
                            <ul>
                                <li><a href="?addUser=oui">Ajouter une personne</a></li>
								<li><a href="?donnees=modifier&idpersonne=<?php echo $_SESSION['idpersonne']; ?>">Modifier mon mot de passe</a></li>
								<li><a href="?donnees=listepersonne">Modifier ou supprimer une personne</a></li>
							</ul>
                        </li>
                    </ul>
                </li>
                <li><a href="#">Catégories</a>
					<span id="s3"></span>
                    <ul class="subs">
                        <li><a href="?donnees=listecategorie2">Liste des catégories</a>
                            <ul>
                                <li><a href="?donnees=listecategorie">afficher la liste des categories</a></li>
                                <li><a href="?donnees=listecategorie2">afficher le nombre de titres par categorie</a></li>
                            </ul>
                        </li>
                        <li><a href="#">gestion des catégories</a>
                            <ul>
                                <li><a href="?donnees=ajoutercategorie">Ajouter une catégorie</a></li>
                            </ul>
                        </li>
                    </ul>
				</li>
                <li><a href="#">Support</a></li>
                <li><a href="#">Type de support</a></li>
                <li><a href="index.php?donnees=deco" >Déconnexion</a></li>
            </ul>
        </div>
		</nav>

		<div class="containercorps">
			<!--  une section de la page: -->
			<section>
				<!--  informations complémentaires: -->
				<aside>
					<br /><br />
					<h1>À propos du site</h1>
					<p>C'est moi, Tanguy! Vous êtes ici dans la vidéothéque que le TP5 nous demande de faire</p>			
				</aside>
				<!-- un article de la section: -->
				<article>      
					<h1>Sélectionnez dans le menu ci dessous</h1>
					<p>afin d'afficher et gérer la vidéothéque de prêt de SUPPORT</p><br />
				</article>
			</section>
		</div>
<?php
}
$html.='';
echo $html;
?>		
        <div class="containerpieddepage">
			<footer>	<!-- le pied de page -->
				<p>
					<a href="http://jigsaw.w3.org/css-validator/check/referer">
						<img style="border:0;width:88px;height:31px"
							src="http://jigsaw.w3.org/css-validator/images/vcss"
							alt="CSS Valide !" /></a>
					<br />
					<object type="text/html" data="copyright.php" width="800px" height="100px"></object>
				</p>
			</footer>
        </div>
</body>
</html>