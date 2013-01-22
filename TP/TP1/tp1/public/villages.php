<?php
// DOCROOT/projects/tp1/public/city.php

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
$country = $_GET["name"];
if (!isset($country) || empty($country)) {
	// No id given or invalid id
	page_not_found();
}

include __DIR__ . '/../model/villages.php';
// include view
include __DIR__ . '/../view/villages.php';
