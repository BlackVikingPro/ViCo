<?php
ini_set('display_errors', 'On');

include '../counter.php';

$vico = new ViCo();
$vico->ViewCounter('localhost', 9000);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Realtime Viewers!</title>
</head>
<body>

<center>
	<h1>Realtime Viewers! <small>By: <a href="https://twitter.com/BlackVikingPro" style="color: red;">@BlackVikingPro</a></small></h1>
</center>

</body>
</html>