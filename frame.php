<?php
// liste des fonctions
// if (isset($_GET['indextitre']))
	// {
		// include ('indextitre.php');

	// }
// }
$menu=$_GET['menu'];
echo $menu.'++++++';
switch ($menu) // on indique sur quelle variable on travaille
{ 
    case 1: // dans le cas où $note vaut 0
        include ('indextitre.php');
    break;
    
    case 2: // dans le cas où $note vaut 5
        include ('indexpersonne.php');
    break;
    
    case 3: // dans le cas où $note vaut 7
        include ('indexcategorie.php');
    break;
    
    case 4: // etc. etc.
        echo "Tu as pile poil la moyenne, c'est un peu juste…";
    break;
    
    case 12:
        echo "Tu es assez bon";
    break;
   
    default:
        echo "Désolé, il s'est passé une erreur";
}

?>

