<?php

$loader = require __DIR__ . '/../../vendor/autoload.php';
$loader->add('', __DIR__);

class LocationDataMapperTest extends PHPUnit_Framework_TestCase
{
	private $con;
	
	public function setUp()
	{
		$this->con = new \Model\Connection('sqlite::memory:');
        $this->con->exec(<<<SQL
							CREATE TABLE IF NOT EXISTS LOCATIONS(
								id INTEGER NOT NULL PRIMARY KEY,
								name VARCHAR(250) NOT NULL,
								created_at DATETIME
							);
SQL
);
	}
	
	public function testLocationPersist()
	{
		$mapper = new \Model\LocationDataMapper($this->con);
		
		$rows = $this->con->query('SELECT COUNT(*) FROM LOCATIONS')->fetch(\PDO::FETCH_NUM);
        $this->assertEquals(0, $rows[0]);
		
		$loc = new \Model\Location('Geneve', new \DateTime(null));
		
		$mapper->persist($loc);
		
		$rows = $this->con->query('SELECT COUNT(*) FROM LOCATIONS')->fetch(\PDO::FETCH_NUM);
        $this->assertEquals(1, $rows[0]);
	}
	
	public function testLocationUpdate()
	{
		$mapper = new \Model\LocationDataMapper($this->con);
		
		$loc = new \Model\Location('Geneve', new \DateTime(null));
		
		$id = $mapper->persist($loc);
		\Tools\LocationReflection::setPropertyLocation($loc, $id);
		
		$loc->setName('Miami');
		
		$mapper->persist($loc);
		
		$stmt = $this->con->prepare('SELECT * FROM LOCATIONS WHERE id = :id');
		$stmt->bindValue(':id', $id);
		$stmt->execute();
        $this->assertEquals('Miami', $stmt->fetchAll(\PDO::FETCH_ASSOC)[0]['name']);
		
	}
	
	
	
	/*public function testInsertNewLocation(){
		
		$queryWanted = "INSERT INTO LOCATIONS (NAME, CREATED_AT) VALUES(':name', ':date')";
		
		$date = new \DateTime('2013-01-01');
		$insertLocation = new \Model\Location("Paris", $date);
				

		$mock = $this->getMock('MockConnection');
			 
		$loc = new \Model\LocationDataMapper($mock);
		
		$loc->persist($insertLocation);
		
	}*/
}
