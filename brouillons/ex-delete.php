<?php
ex fichier
// header('Location: index.php'); 
// require('index.php');
if (isset($_GET['delete']))
{
include ('connexiontp5.php');
$idtitre=$_GET['idtitre'];
$pdo->exec("DELETE FROM ttitres WHERE idtitre=".$idtitre." ");


// $req=$pdo->query("DELETE FROM ttitres WHERE idtitre = ".$_GET['idtitre']." ");
//$req->execute();
	
// $req=$pdo->prepare('DELETE FROM ttitres WHERE idtitre=:idtitre');	
// $req->execute('idtitre'=>$idtitre);

// $req = "DELETE FROM ttitres WHERE idtitre='.$idtitre.' ";
// $pdo->exec($req);
}
?>
<html>
<head>
<meta charset="UTF-8"/>
<title>deletetp5</title>
</head>
<body>
<p>La suppression a été correctement effectuée</p>
<a href="index.php?suppression">Retour a la liste</a>
</body>
</html>
