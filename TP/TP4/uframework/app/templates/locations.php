<h2>Locations:</h2>
<ul>
	<?php foreach($locations as $val): ?>
		<?= "<li>".$val['id']." - ".$val['name']."</li>" ?>
	<?php endforeach; ?>
</ul>

<form method="POST" action="/locations">
	<label> Location name :</label>
	<input type="text" name="name"/>
	
	<input type="submit" value="Add new"/>
</form>
