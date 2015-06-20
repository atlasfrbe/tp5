<?php
session_start();
include ('connect/connexiontp5.php');
include ('class/user.class.php');
include ('class/title.class.php');
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
if (isset($_GET['addUser']))
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
	else if (!isset($_SESSION['idUser']))	// si pas de session utilisateur
		{
		$html='<center><form method="POST" name="formLogin" action="?login"><table>';
		$html.='<tr><th>Login</th><td><input type="text" name="login"></td></tr>';
		// pas d'autofocus pour ne pas aider les bots
		$html.='<tr><th>Password</th><td><input type="password" name="pwd"></td></tr>';
		$html.='<tr><td colspan="2"><input type="submit" name="bsubmitLogin" value="Se connecter"></td></tr>';
		$html.='</table></form></center>';			
		}
	else
		{
		$html='<center>Vous êtes identifié.</center><br />';
		$html.='<a href="?donnees=modifier&idUser='.$_SESSION['idUser'].'">Modifier mon mot de passe</a><br />';
		// $html.='<a href="?donnees=afficheListe">Lister les utilisateurs</a><br />';	
		// $html.='<a href="?donnees=deco">Se déconnecter</a><br />';
		}
	}

else if (isset($_GET['donnees']))
	{
	$action=$_GET['donnees'];
	switch ($action)
		{
		case 'modifier':
			$user = NEW User($pdo);
			$data=$user->getInfoUserById($_GET['idUser']);
			$html='<form method="POST" name="formModifUser" action="?donnees=recModifs&idUser='.$_GET['idUser'].'"><table>';
			$html.='<tr><th>Login</th><th>Ancien mot de passe</th><th>Nouveau mot de passe</th><th>Nouveau mot de passe (vérif.)</th></tr>';
			while ($row=$data->fetch())
				{
				$html.='<tr><td><input type="text" name="login" value="'.$row['login'].'"></td><td><input type="password" name="oldPwd"></td><td><input type="password" name="newPwd"></td><td><input type="password" name="newPwd2"></td>';
				}
			$html.='<tr><td colspan="4"><input type="submit" value="Modifier"></td></tr>';
			$html.='</table></form>';
			break;
		case 'recModifs':
			$user = NEW User($pdo);
			$data=$user->recModifsUser($_GET['idUser'], $_POST['login'], md5($_POST['oldPwd']), $_POST['newPwd'], $_POST['newPwd2']);
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
		case 'afficheListe':
			$i=0;
			$html='<h3>Liste des utilisateurs</h3>';
			$html.='<table>';
			$html.='<tr><th>Login</th><th>Action</th></tr>';
			$user=NEW User($pdo);
			$data=$user->getUsers();
			while ($row=$data->fetch()){
				$html.='<tr><td>'.$row['login'].'</td><td><a href="?donnees=modifUser&idUser='.$row['idpersonne'].'&num='.$i.'">Modifier</a></td></tr>';
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
			$data=$user->getUserFromId($_GET['idUser']);
			$html.='<form method="POST" name="fModifUser" action="?donnees=afficheModifUser"><table>';
			while($row=$data->fetch()){
				$html.='<tr><td><input type="text" name="login" value="'.$row['login'].'"></td><td><input type="submit" value="Enregistrer"><input type="hidden" name="idUser" value="'.$row['idpersonne'].'"></td></tr>';
			}
			$html.='</table></form>';
			break;
		case 'afficheModifUser' :
			$user=NEW User($pdo);
			$user->updateUser($_POST['idUser'], $_POST['login']);
			$html='Modifications sauvegardées. <br />';
			$html.='<a href="?donnees=afficheListe">Retour liste utilisateurs</a>';
			break;
		case 'deco' :
			unset ($_SESSION['idUser']);
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
				$requeteajouttitre=$pdo->prepare("INSERT INTO ttitres SET titre='".$_POST['newtitre']."',datetitre=now()");
				$requeteajouttitre->execute();
				header('Location: index.php?donnees=listetitre'); 
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
	// appel de la fonction supprimertitre
	if (isset($_GET['supprimertitre']))
		{
			$title = NEW Title($pdo);
			$data=$title->supprimertitre($_GET['idtitre']);
			$html = 'La suppression a été correctement effectuée</br>';
			$html.= 'Le titre <strong>'.$_GET['titre'].'</strong> a été supprimé</br>';
		}
	// au retour de la fonction supprimer:
	// if (isset($_GET['suppression']))
	// {
		// while ($donnees = $requete->fetch())
		// {
			// echo 'Le titre <strong>'.$donnees['titre'].'</strong> a été supprimé</br>';
		// }
	// }
	// appel des fonctions ajoutertitre
	// if (isset($_GET['ajoutertitre_m']))
		// {
			// ajoutertitre_v();
		// }
	// if (isset($_GET['ajoutertitre_c']))
		// {
			// ajoutertitre_c();
		// }
//****************************************************************************************	
	
if (isset($_SESSION['idUser']))		// on cache le menu si pas de session utilisateur
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
                                <li><a href="indexpersonne.php">afficher la liste des personnes</a></li>
                                <li><a href="#">Submenu y</a></li>
                            </ul>
                        </li>
                        <li><a href="#">gestion des personnes</a>
                            <ul>
                                <li><a href="?donnees=modifier&idUser='<?php echo $_SESSION['idUser']; ?>'">Modifier mon mot de passe</a></li>
                                <li><a href="#">Submenu y</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="#">Catégories</a>
					<span id="s3"></span>
                    <ul class="subs">
                        <li><a href="#">Liste des catégories</a>
                            <ul>
                                <li><a href="#">afficher la liste des categories</a></li>
                                <li><a href="#">Submenu y</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Mon histoire</a>
                            <ul>
                                <li><a href="#">Submenu x</a></li>
                                <li><a href="#">Submenu y</a></li>
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
					<p>afin d'afficher et gérer la vidéothéque</p><br />
				</article>
			</section>
		</div>
<?php
}
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