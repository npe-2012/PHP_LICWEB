<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Villes de <?php echo $country; ?></title>
	</head>
	<body>
		<h1>Liste villes de <?php echo $country; ?></h1>
		<?php foreach($cities as $city): ?>
			<p><?php echo $city; ?></p>
		<?php endforeach; ?>
	</body>
</html>
