<?php
// instauration d'un compteur
// define ('PAGE','indextitre.html');
// $nombre=1;
// if(file_exists(PAGE.'.txt')){
// $nombre=file_get_contents(PAGE.'.txt');
// if(is_numeric($nombre)){$nombre++;}
// }
// file_put_contents(PAGE.'.txt',$nombre);
$monfichier = fopen('compteur.txt','a'); // ouvre un fichier et le crée s'il n'existe pas
fclose($monfichier);

$monfichier = fopen('compteur.txt','r+'); // ouvre un fichier en RW et se place au début de celui ci
$ligne = fgets($monfichier);

$nbaff = ($ligne == '') ? 0 : $ligne; // récupère le nombre d'affichage
$nbaff++;

fseek($monfichier, 0);
fputs($monfichier, $nbaff);

fclose($monfichier);

echo '<center>La page a été affichée '.$nbaff.' fois.</center>';
//fin compteur

// affichage du compteur et du copyright
echo '<font color="#ff0000">';		// met en rouge
echo "<center><p><strong>Copyright &copy; 2014-" . date("Y") . " / Tous droits réservés à Tanguy FILLETTE: </strong>";
echo '</font>';
echo '<a href="mailto:uneadressecourriel@jenaimepaslespam.com">Me contacter !</a></p><center>';

// echo '<center>Page vue '.readfile(PAGE.'.txt').' fois.</center>';
?>
