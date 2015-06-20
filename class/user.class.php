<?php
class User
{
private $pdo;
// public $login='tanguy';
// public $password='autre chose';

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
		echo 'Erreur fnouvelUtilisateur: Login déjà existant.<br />';
		}
	}
	

	
private function checkDoublon($login)
	{
	$sql='SELECT COUNT(*) FROM tpersonnes WHERE login="'.$login.'"';
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
		// $sql='SELECT idpersonne, password FROM tpersonnes WHERE login="'.$loginCtrl.'"';
		// $reponse=$this->pdo->query($sql);
		// while ($row=$reponse->fetch())
			// {
				// $mdp=$row['password'];
				// $idUser=$row['idpersonne'];
			// }
		//*****************
		
		//REQUETE PREPAREE
		$sql='SELECT idpersonne, password FROM tpersonnes WHERE login=:loginCtrl';
		$req=$this->pdo->prepare($sql);
		$req->execute(array(
		'loginCtrl'=>$loginCtrl
		));
		while ($row=$req->fetch())
			{
				$mdp=$row['password'];
				$idUser=$row['idpersonne'];
			}
		if ((isset($mdp))&&($pwd==$mdp))	//si le mot de passe est bon
			{
				$response='Vous êtes identifié. <br />';
				// $response.='<a href="?donnees=modifier&idUser='.$idUser.'">Modifier mes données</a><br />';
				// $response.='<a href="?donnees=afficheListe">Lister les utilisateurs</a><br />';
				// $response.='<a href="?donnees=deco">Se déconnecter</a><br />';
				$_SESSION['idUser']=$idUser;	// création de la session utilisateur
			}
		else
			{
			$response='Erreur flogin: Erreur de login ou de mot de passe';
			}
		return $response;	
	}
	
public function getInfoUserById($idpersonne)	{
	$sql='SELECT login FROM tpersonnes WHERE idpersonne=:user';
	$req=$this->pdo->prepare($sql);
	$req->execute(array(
	'user' => $idpersonne
	));
	return $req;
}

public function recModifsUser($idpersonne,$login,$pwd,$nPwd,$nPwd2){
	$sql='SELECT password FROM tpersonnes WHERE idpersonne=:user';
	$req=$this->pdo->prepare($sql);
	$req->execute(array(
	'user' => $idpersonne
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
			'idUser' => $idpersonne
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
			'idUser' => $idpersonne
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
	$sql='SELECT idpersonne, login FROM tpersonnes WHERE idpersonne=:idUser';
	$req=$this->pdo->prepare($sql);
	$req->execute(array(
	'idUser' => $idpersonne
	));
	return $req;
}

public function updateUser($id,$login){
	$sql='UPDATE tpersonnes SET login=:login WHERE idpersonne=:idpersonne';
	$req=$this->pdo->prepare($sql);
	$req->execute(array(
	'login' => $login,
	'idpersonne' => $idpersonne
	));
}

public function supprimerpersonne($idpersonne)
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
public function modifierpersonne_v($idpersonne)
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
public function modifierpersonne_c($idpersonne)
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
public function ajouterpersonne_v()
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
public function ajouterpersonne_c()
{
		include ('connect/connexiontp5.php');
		if(isset($_POST['bEnregistrer']))
		{	
			$requeteajouttitre=$pdo->prepare("INSERT INTO tpersonnes SET nom='".$_POST['nom']."',prenom='".$_POST['prenom']."',adresse='".$_POST['adresse']."',codepostal='".$_POST['codepostal']."',localite='".$_POST['localite']."',telephone='".$_POST['telephone']."',gsm='".$_POST['gsm']."' ");
			$requeteajouttitre->execute();
		}
		header('Location: indexpersonne.php?ajoutfini'); 
}

}
?>