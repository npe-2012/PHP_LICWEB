<?php


$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('', __DIR__);


// Config
$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

$connection = new \Model\Connection('mysql:host=localhost;dbname=uframework', 'uframework', 'uframework123');

/**
 * Index
 */
$app->get('/', function () use ($app) {
    $app->redirect('/locations');
});

$app->get('/locations', function (Http\Request $request) use ($app,$connection) {
	
	$locations = new Model\LocationFinder($connection);
	$locationsList = $locations->findAll();
	
	if(!empty($locationsList)){
		
		if($request->guessBestFormat() === 'json'){
			return new Http\JsonResponse($locationsList);
		}
	
		return new Http\Response($app->render('locations.php', array("locations" => $locationsList)));
	
	}
	throw new Exception\NotFoundHttpException("No locations found");
});

$app->get('/locations/(\d+)', function (Http\Request $request, $id) use ($app, $connection) {
	$locations = new Model\LocationFinder($connection);
	$location = $locations->findOneById($id);
	
	if(!empty($location)){ 
		
		if($request->guessBestFormat() === 'json'){
			return new Http\JsonResponse($location);
		}
		
		return new Http\Response($app->render('location.php',  array("location" => $location)));
	}
	throw new Exception\NotFoundHttpException();
    
});

// get comments for a locations
$app->get('/locations/(\d+)/comments', function(Http\Request $request, $id) use ($app, $connection) {
	$finder = new Model\LocationFinder($connection);
	$location = $finder->findOneById($id);
	
	if(!empty($location) && $request->guessBestFormat() == 'json'){
		return new Http\JsonResponse($finder->findCommentsByLocationId($location->getId()));
	}
	throw new Exception\NotFoundHttpException();
});

// create location
$app->post('/locations', function (Http\Request $request) use ($app, $connection) {
	
	$mapper = new Model\LocationDataMapper($connection);
	$locationName = $request->getParameter('name');
	$locationDate = new \DateTime(null);
	
	if(!empty($locationName)){
		
		$location = new Location($locationName, $locationDate);
		$mapper->persist($location);
		if($request->guessBestFormat() === 'json'){
			return new Http\JsonResponse($location->getId(), 201);
		}
		
    	$app->redirect('/locations');
    	
	}
	throw new Exception\BadRequestHttpException();
});

// update location
$app->put('/locations/(\d+)', function (Http\Request $request, $id) use ($app, $connection) {
	
	$finder = new Model\LocationFinder($connection);
	$mapper = new Model\LocationDataMapper($connection);
	$locationName = $request->getParameter("name");
	$location = $finder->findOneById($id);
	
	
	if(!empty($location) && !empty($locationName)){ 
		
		$location->setName($locationName);
		$mapper->persist($location);
		
		if($request->guessBestFormat() === 'json'){
			return new Http\JsonResponse($location);
		}
		$app->redirect('/locations/'.$id);
		
	}
	throw new Exception\NotFoundHttpException();
    
});

// delete location
$app->delete('/locations/(\d+)', function (Http\Request $request, $id) use ($app, $connection) {
    $finder = new Model\LocationFinder($connection);
    $mapper = new Model\LocationDataMapper($connection);
	$location = $finder->findOneById($id);
	
	if(!empty($location)){ 
		
		$mapper->remove($location);
		
		if($request->guessBestFormat() === 'json'){
			return new Http\JsonResponse(null, 204);
		}
		
		$app->redirect('/locations');
		
	}
	throw new Exception\BadRequestHttpException();
});

return $app;
