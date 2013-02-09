<?php

namespace Model;

class LocationDataMapper implements DataMapperInterface
{
	private $connection;
	
	/**
	 * @param $con Connection object
	 */
	public function __construct(Connection $con)
	{
		$this->connection = $con;
	}
	
	/**
	 * Insert or update a object Location into the DB
	 * @param $location Location object tp insert or update
	 * @return boolean True if insert or update was realized without error else false
	 */
	public function persist($location)
	{
		if(!$location instanceof Location){
			return false;
		}
		
		if($this->isNew($location)){
			
			$query = 'INSERT INTO LOCATIONS (NAME, CREATED_AT) VALUES(:name, :date)';
			$stmt = $this->connection->executeQuery($query, array(
				'name' => $location->getName(),
				'date' => $location->getCreatedAt()->format('Y-m-d H:i:s')
			));
			
			\Tools\LocationReflection::setPropertyLocation($location,$this->connection->LastInsertId());
			
			return $stmt;
		}
		else{
			
			$query = 'UPDATE LOCATIONS SET NAME = :name WHERE ID = :id';
			$stmt = $this->connection->executeQuery($query, array(
				'id' => $location->getId(),
				'name' => $location->getName()
			));
			
			return $stmt;
		}
	}
	
	/**
	 * Remove a object Location into the DB
	 * @param $location Location object to remove
	 * @return boolean True if delete was realized without error else false
	 */
	public function remove($location)
	{
		if(!$location instanceof Location){
			return false;
		}
		
		$query = 'DELETE FROM LOCATIONS WHERE ID = :id';
		$stmt = $this->connection->executeQuery($query, array(
			'id' => $location->getId()
		));
		return $stmt;
	}
	
	/**
	 * Permit to define is the Location object is new
	 * @param $location Location object
	 * @return boolean True if the Location object is new else false
	 */
	private function isNew(Location $location)
	{
		return null === $location->getId();
	}
}
