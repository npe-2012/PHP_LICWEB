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

$app->get('/locations', function (Http\Request $request) use ($app) {
	$locations = new Model\Locations();
    return $app->render('locations.php', array("locations" => $locations->findAll()));
});

$app->get('/locations/(\d+)', function (Http\Request $request, $id) use ($app) {
	$locations = new Model\Locations();
	$location = $locations->findOneById($id);
	
	if(!empty($location))
	{ 
		return $app->render('location.php',  array("location" => $location, "id" => $id));
	}
	throw new Exception\HttpException('404',"Location not found, Mind your own business!!");
    
});

// create location
$app->post('/locations', function (Http\Request $request) use ($app) {
	$locations = new Model\Locations();
	$locations->create($request->getParameter("name"));
    $app->redirect('/locations');
});

// update location
$app->put('/locations/(\d+)', function (Http\Request $request, $id) use ($app) {
	$locations = new Model\Locations();
	$location = $locations->findOneById($id);
	
	if(!empty($location))
	{ 
		$locations->update($id, $request->getParameter("name"));
		$app->redirect('/locations/'.$id);
	}
	throw new Exception\HttpException('404',"Location doesn't exist, Mind your own business!!");
    
});

// delete location
$app->delete('/locations/(\d+)', function (Http\Request $request, $id) use ($app) {
    $locations = new Model\Locations();
	$location = $locations->findOneById($id);
	
	if(!empty($location))
	{ 
		$locations->delete($id);
		$app->redirect('/locations');
	}
	throw new Exception\HttpException('404',"Location doesn't exist, Mind your own business!!");
});

return $app;
