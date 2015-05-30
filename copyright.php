<?php
// instauration d'un compteur
define ('PAGE','indextitre.html');
$nombre=1;
if(file_exists(PAGE.'.txt')){
$nombre=file_get_contents(PAGE.'.txt');
if(is_numeric($nombre)){$nombre++;}
}
file_put_contents(PAGE.'.txt',$nombre);
//fin compteur

// affichage du compteur et du copyright
echo "<center><p>Copyright &copy; 2014-" . date("Y") . "  Tanguy iepsm.be</p><center>";
echo '<center>Page vue '.readfile(PAGE.'.txt').' fois.</center>';
?>
