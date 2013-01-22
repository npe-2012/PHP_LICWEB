<?php
// DOCROOT/projects/tp1/public/city.php
include __DIR__ . '/../model/cities.php';

/**
 * render a 404 page
 */
function page_not_found()
{
	header("HTTP/1.0 404 Not Found");
	include __DIR__ . '/../view/404.html';
	die();
}

// retrieve id from url parameter
$city_id = $_GET["id"];
if (!isset($city_id) || !is_numeric($city_id) || !isset($cities[$city_id])) {
	// No id given or invalid id
	page_not_found();
}

// retrieve city from dataset
$city = $cities[$city_id];
// define some more variables
$title = sprintf("City %s", $city["name"]);

// include view
include __DIR__ . '/../view/city.php';
