<?php
session_start();
include ('class/user.class.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<title> TP5 de Tanguy </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css" />
<!-- <style type="text/css">

</style> -->
</head>

<body>
<center><h3>Videotheque de Tanguy</h3><center>
    <!-- Le menu -->
<form id="myForm" action="" method="post" onsubmit="return false">
	<div class="menu">
		<div id="nav">
			<ul>
				<li><a href="#" onclick="return toggle('pg0')">TITRES</a></li>
				<li><a href="#" onclick="return toggle('pg1')">PERSONNES</a></li>
				<li><a href="#" onclick="return toggle('pg2')">CATEGORIES</a></li>
				<li><a href="#" onclick="return toggle('pg3')">SUPPORTS</a></li>
				<li><a href="#" onclick="return toggle('pg4')">TYPE DE SUPPORT</a></li>
			</ul>
		</div>
     <!-- Le corps -->
		<div id="pg">
			<div id="pg0" class="pg"> <h1 class="h1"> <object type="text/html" data="indextitre.php" width="800px" height="600px"></object></h1> </div>
			<div id="pg1" class="pg"> <h1 class="h1"> <object type="text/html" data="indexpersonne.php" width="800px" height="600px"></object> </h1> </div>
			<div id="pg2" class="pg"> <h1 class="h1"> CCCC page </h1> </div>
			<div id="pg3" class="pg"> <h1 class="h1"> DDDD page </h1> </div>
			<div id="pg4" class="pg"> <h1 class="h1"> EEEE page </h1> </div>
		</div>
	<!-- pied de page -->
		<object type="text/html" data="copyright.php" width="800px" height="100px"></object>
	</div>
</form>
<script type="text/javascript">
function toggle(IDS) {
  var sel = document.getElementById('pg').getElementsByTagName('div');
  for (var i=0; i<sel.length; i++) { 
    if (sel[i].id != IDS) { sel[i].style.display = 'none'; }
  }
  var status = document.getElementById(IDS).style.display;
  if (status == 'block') { document.getElementById(IDS).style.display = 'none'; }
                    else { document.getElementById(IDS).style.display = 'block'; }
  return false;
}
</script>
<!-- source du script: http://www.webdeveloper.com/forum/showthread.php?273153-change-the-page-content-by-clicking-on-menu-option#top -->
    <!-- Le pied de page -->
    
    <footer id="pied_de_page">
	
    </footer>
</body>
</html>
<?php  ?>