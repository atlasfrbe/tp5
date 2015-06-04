<?php

class User
{
private $pdo;
// public $login='tanguy';
// public $password='1234';

public function __construct($dbPdo)
	{
	$this->pdo=$dbPdo;
	}
	
public function nouvelUtilisateur($login,$password)
	{
	$loginControle=$this->checkDoublon($login);
	if ($loginControle)
		{
		$variable='INSERT INTO tpersonnes (login, password) VALUES ("'.$login.'", "'.$password.'")';
		$this->pdo->exec($variable);
		echo 'Entrée en bdd réussie.<br />';
		}
		
	else
		{
		echo 'Login déjà existant.<br />';
		}
	}
	

	
private function checkDoublon($login)
	{
	$sql='SELECT COUNT(*) FROM users WHERE login="'.$login.'"';
	$rep=$this->pdo->query($sql);
	while ($row=$rep->fetch())
		{
		$count=$row['COUNT(*)'];
		}
	if ($count=='0')
		{
		return true;
		}
	else return false;
	}
	
public function login($loginCtrl,$pwd)
	{
		//REQUETE DIRECTE
		// $sql='SELECT id, password FROM users WHERE login="'.$loginCtrl.'"';
		// $reponse=$this->pdo->query($sql);
		// while ($row=$reponse->fetch())
			// {
				// $mdp=$row['password'];
				// $idUser=$row['id'];
			// }
		//*****************
		
		//REQUETE PREPAREE
		$sql='SELECT id, password FROM users WHERE login=:loginCtrl';
		$req=$this->pdo->prepare($sql);
		$req->execute(array(
		'loginCtrl'=>$loginCtrl
		));
		while ($row=$req->fetch())
			{
				$mdp=$row['password'];
				$idUser=$row['id'];
			}
		if ((isset($mdp))&&($pwd==$mdp))
			{
				$response='Vous êtes identifié. <br />';
				$response.='<a href="?donnees=modifier&idUser='.$idUser.'">Modifier mes données</a><br />';
				$response.='<a href="?donnees=afficheListe">Lister les utilisateurs</a><br />';
				// $response.='<a href="?donnees=deco">Se déconnecter</a><br />';
				$_SESSION['idUser']=$idUser;
			}
		else
			{
			$response='Erreur de login ou de mot de passe';
			}
		return $response;	
	}
	
public function getInfoUserById($id)	{
	$sql='SELECT login FROM tpersonnes WHERE id=:user';
	$req=$this->pdo->prepare($sql);
	$req->execute(array(
	'user' => $id
	));
	return $req;
}

public function recModifsUser($id,$login,$pwd,$nPwd,$nPwd2){
	$sql='SELECT password FROM tpersonnes WHERE id=:user';
	$req=$this->pdo->prepare($sql);
	$req->execute(array(
	'user' => $id
	));
	while ($row=$req->fetch()){
		$passInBDD=$row['password'];
	}
	if($pwd==$passInBDD){
		// echo $pwd.' - '.$nPwd.' - '.$nPwd2;
		if(($nPwd!='')AND($nPwd==$nPwd2)){	
			// echo '<h1>'.$nPwd.'</h1>';
			$sql='UPDATE tpersonnes SET login=:login, password=:nPwd WHERE idpersonne=:idUser';
			$req=$this->pdo->prepare($sql);
			$req->execute(array(
			'login' => $login,
			'nPwd' => md5($nPwd),
			'idUser' => $id
			));
			return 1;
			}
		else if(($nPwd!='')AND($nPwd!=$nPwd2)){
			return 3;
			}
		else{
			$sql='UPDATE tpersonnes SET login=:login WHERE idpersonne=:idUser';
			$req=$this->pdo->prepare($sql);
			$req->execute(array(
			'login' => $login,
			'idUser' => $id
			));
			return 1;
		}
	}
	else return 2;
}

public function getUsers(){
	$sql='SELECT idpersonne, login FROM tpersonnes';
	return $this->pdo->query($sql);
}

public function getUserFromId($id){
	$sql='SELECT idpersonne, login FROM tpersonnes WHERE id=:idUser';
	$req=$this->pdo->prepare($sql);
	$req->execute(array(
	'idUser' => $id
	));
	return $req;
}

public function updateUser($id,$login){
	$sql='UPDATE tpersonnes SET login=:login WHERE idpersonne=:id';
	$req=$this->pdo->prepare($sql);
	$req->execute(array(
	'login' => $login,
	'idpersonne' => $id
	));
}


}
?>