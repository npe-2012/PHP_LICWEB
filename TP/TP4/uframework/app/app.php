<?php


$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('', __DIR__);


// Config
$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

$connnection = new \Model\Connection('mysql:host=localhost;dbname=uframework', 'uframework', 'uframework123');

/**
 * Index
 */
$app->get('/', function () use ($app) {
    $app->redirect('/locations');
});

$app->get('/locations', function (Http\Request $request) use ($app,$connnection) {
	
	$locations = new Model\Locations($connnection);
	
	if($request->guessBestFormat() === 'json'){
		
		$content = json_encode($locations->findAll());
		return new Http\Response($content, 200, array('Content-Type' => $request->guessBestFormat()));
		
	}
	
    return new Http\Response($app->render('locations.php', array("locations" => $locations->findAll())));
});

$app->get('/locations/(\d+)', function (Http\Request $request, $id) use ($app, $connnection) {
	
	$locations = new Model\Locations($connnection);
	$location = $locations->findOneById($id);
	
	if(!empty($location)){ 
		
		if($request->guessBestFormat() === 'json'){
			
			$content = json_encode($location);
			return new Http\Response($content, 200, array('Content-Type' => $request->guessBestFormat()));
			
		}
		
		return new Http\Response($app->render('location.php',  array("location" => $location)));
	}
	throw new Exception\NotFoundHttpException();
    
});

// create location
$app->post('/locations', function (Http\Request $request) use ($app, $connnection) {
	
	$locations = new Model\Locations($connnection);
	$newLocation = $request->getParameter('name');
	
	if(!empty($newLocation)){
		
		$content = $locations->create($newLocation);
		if($request->guessBestFormat() === 'json'){
			
			$content = json_encode($content);
			return new Http\Response($content, 201, array('Content-Type' => $request->guessBestFormat()));
			
		}
    	$app->redirect('/locations');
    	
	}
	throw new Exception\NotAcceptableHttpException();
});

// update location
$app->put('/locations/(\d+)', function (Http\Request $request, $id) use ($app, $connnection) {
	
	$locations = new Model\Locations($connnection);
	$location = $locations->findOneById($id);
	
	if(!empty($location)){ 
		
		$content = $locations->update($id, $request->getParameter("name"));
		if($request->guessBestFormat() === 'json'){
			
			$content = json_encode($content);
			return new Http\Response($content, 200, array('Content-Type' => $request->guessBestFormat()));
			
		}
		$app->redirect('/locations/'.$id);
		
	}
	throw new Exception\NotFoundHttpException();
    
});

// delete location
$app->delete('/locations/(\d+)', function (Http\Request $request, $id) use ($app, $connnection) {
    $locations = new Model\Locations($connnection);
	$location = $locations->findOneById($id);
	
	if(!empty($location)){ 
		
		$content = $locations->delete($id);
		if($request->guessBestFormat() === 'json'){
			
			$content = json_encode($content);
			return new Http\Response($content, 200, array('Content-Type' => $request->guessBestFormat()));
			
		}
		$app->redirect('/locations');
		
	}
	throw new Exception\NotFoundHttpException();
});

return $app;
