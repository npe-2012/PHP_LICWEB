<?php

require __DIR__ . '/../autoload.php';

// Config
$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

/**
 * Index
 */
$app->get('/', function () use ($app) {
    return $app->render('index.php');
});

$app->get('/locations', function () use ($app) {
	$locations = new Model\Locations();
    return $app->render('locations.php', array("locations" => $locations->findAll()));
});

$app->get('/locations/(\d+)', function ($id) use ($app) {
	$locations = new Model\Locations();
	$location = $locations->findOneById($id);
	
	if(empty($location))
	{ 
		throw new Exception\HttpException('404',"Location not found, keep your bunsiness!!");
	}
    return $app->render('location.php',  array("location" => $location));
});


//@TODO
$app->post('/locations', function ($name) use ($app) {
	$locations = new Model\Locations();
    return $app->render('locations.php', array("locations" => $locations->addLocation($name)));
});

//@TODO
$app->put('/locations/(\d+)', function ($id) use ($app) {
	$locations = new Model\Locations();
	$location = $locations->findOneById($id);
	
	if(empty($location))
	{ 
		throw new Exception\HttpException('404',"Location not found, keep your bunsiness!!");
	}
    return $app->render('location.php', array("location" => $location));
});

//@TODO
$app->delete('/locations/(\d+)', function ($id) use ($app) {
    return $app->render('location.php');
});

return $app;
