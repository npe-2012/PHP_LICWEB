<!-- DOCROOT/projects/tp1/view/city.php -->
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Liste des pays</title>
</head>
<body>
<h1>Liste des pays :</h1>

<?php foreach ($countries as $country):?>
<p>
 <a href="/tp1/villages.php?name=<?php echo $country; ?>"><?php echo $country; ?></a> 
</p>
	
<?php endforeach; ?>

</body>
</html>
