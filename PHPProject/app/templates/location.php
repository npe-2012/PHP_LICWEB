<h2>Location:</h2>
<ul>
		<li><?= $location->getName() ?></li>
</ul>
<form action="/locations/<?= $location->getId() ?>" method="POST">
    <input type="hidden" name="_method" value="PUT" />
    <input type="text" name="name" value="<?= $location->getName() ?>" />
    <input type="submit" value="Update" />
</form>
<form action="/locations/<?= $location->getId() ?>" method="POST">
    <input type="hidden" name="_method" value="DELETE" />
    <input type="submit" value="Delete" />
</form>
