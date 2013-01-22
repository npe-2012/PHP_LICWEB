<!-- DOCROOT/projects/tp1/view/cities.php -->
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>All cities</title>
</head>
<body>
	<h1>All cities</h1>
	<table>
		<?php foreach($cities as $city_id => $city): ?>
		<tr>
			<td><a href="/tp1/city.php?id=<?php echo $city_id; ?>"><?php echo $city["name"]; ?></a></td>
			<td><?php echo $city["country"]; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
</body>
</html>
