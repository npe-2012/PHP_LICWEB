<h2>Location:</h2>
<ul>
		<li><?= $location['name'] ?></li>
</ul>
<form action="/locations/<?= $location['id'] ?>" method="POST">
    <input type="hidden" name="_method" value="PUT" />
    <input type="text" name="name" value="<?= $location['name'] ?>" />
    <input type="submit" value="Update" />
</form>
<form action="/locations/<?= $location['id'] ?>" method="POST">
    <input type="hidden" name="_method" value="DELETE" />
    <input type="submit" value="Delete" />
</form>
