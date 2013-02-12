<?php

$loader = require __DIR__ . '/../../vendor/autoload.php';
$loader->add('', __DIR__);

class LocationAPITest extends PHPUnit_Framework_TestCase
{
	public $client;
	
	public function setUp()
	{
		$this->client = new \Goutte\Client();
	}
	
	public function testGETLocations()
	{
		$client->request('GET', 'http://uframework/locations', array('Content-Type' => 'application/json'));
		$response = $client->getResponse();
		$this->assertEquals(200, $response->getStatus());
		$this->assertEquals('text/application', $response->getHeader('Content-Type'));
	}
} 
