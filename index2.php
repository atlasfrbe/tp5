<?php

session_start();
include ('class/user.class.php');
include ('connect/connexiontp5.php');
// print_r($_SESSION);
echo '<br />';
// echo md5('1234');
//************
function htm($data)
	{
	$rep=htmlentities($data, ENT_QUOTES, "UTF-8");
	return $rep;
	}
//************

if (isset($_GET['addUser']))
	{
	if ($_GET['addUser']=="oui")
		{
		$html='<form method="POST" action="index2.php?addUser=record"><table>';
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

else if (isset($_GET['login']))
	{
	if((isset($_POST['login']))&&(isset($_POST['pwd'])))
		{
		$user=new User($pdo);
		$html=$user->login($_POST['login'],md5($_POST['pwd']));
		}		
	else if (!isset($_SESSION['idUser']))
		{
		$html='<form method="POST" name="formLogin" action="?login"><table>';
		$html.='<tr><th>Login</th><td><input type="text" name="login"></td></tr>';
		$html.='<tr><th>Password</th><td><input type="password" name="pwd"></td></tr>';
		$html.='<tr><td colspan="2"><input type="submit" name="bsubmitLogin" value="Se connecter"></td></tr>';
		$html.='</table></form>';			
		}
	else
		{
		$html='Vous êtes identifié. <br />';
		$html.='<a href="?donnees=modifier&idUser='.$_SESSION['idpersonne'].'">Modifier mes données</a><br />';
		$html.='<a href="?donnees=afficheListe">Lister les utilisateurs</a><br />';	
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
			$html.='<h2>OU</h2>';
			$html.='<form method="POST" action="index.php?addUser=record"><table>';
			$html.='<tr><th colspan="2"></th>Ajout d\'un utilisateur</th></tr>';
			$html.='<tr><th>Login :</th><td><input type="text" name="nom"></td></tr>';
			$html.='<tr><th>Password :</th><td><input type="password" name="password"></td></tr>';
			$html.='<tr><td colspan="2"><input type="submit" name="bValider" value="Valider"></td></tr>';
			$html.='</table></form>';
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
			
			header('Location: index2.php?login');
			break;
		}
	}

	
	
else
	{
	$html='<a href="index2.php?login">S\'identifier</a>';
	}

if (isset($_SESSION['idUser']))
{
	$html.='<br /><a href="?donnees=deco">Se déconnecter</a>';
}
echo $html;

//**********************
?>