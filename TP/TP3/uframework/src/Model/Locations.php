<?php
use Model\Connection;

namespace Model;

class Locations implements FinderInterface
{
	
	private static $URI_DATA_LOCATIONS = "./../src/Data/Locations.json";
	
	
	private $connection = null;
	
	
	public function __construct(Connection $con)
	{
		$this->connection = $con;
	}
		
	/**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll()
    {
		$callback = function($location)
		{
			$date = $location['created_at'];
			if(!empty($date)){
				$date = \DateTime::createFromForm('d/m/Y', $date);
			}
			
			return new Location($location['id'],$location['name'], $date);
		};
		return array_map($callback, $this->connection->findAll());
	}

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
		$location = $this->connection->findById($id);
		
		if(!empty($location)){
			
			$date = $location['created_at'];
			
			if(!empty($date)){
				$date = \DateTime::createFromForm('d/m/Y', $date);
			}
			
			return new Location($location['id'], $location['name'], $date);	
		}
		return null;
	}
	
	 /**
     * Add a location
     *
     * @param  mixed      $name
     * @return array
     */
	public function create($name, \DateTime $createdAt = null)
	{
		$query = 'INSERT INTO LOCATIONS(name, created_at) VALUES(:name, :date)';
		
		$this->connection->executeQuery($query, array(
			'name' => $name,
			'created_at' => $createdAt
		));
		return $this->findAll();
	}
	
	/**
     * update a location
     * @param mixed $id
     * @param mixed $name
     * @return array
     */
    public function update($id, $name)
    {
		$query = 'UPDATE LOCATIONS SET name = :name WHERE id = :id';
		$location = $this->connection->findById($id);
		
		if(!empty($location))
		{
			$location = $this->connection->executeQuery($query, array(
				'id' => $id,
				'name' => $name
			));
		}
		return $this->findOneById($id);
	}
    
    
    /**
     * delete a location
     * @param mixed $id
     * @return array
     */
    public function delete($id)
    {
		$query = 'DELETE FROM LOCATIONS WHERE id = :id';
		$location = $this->connection->findById($id);
		
		if(!empty($location))
		{
			$this->connection->executeQuery($query, array(
				'id' => $id
			));
		}
		return $this->findAll();
	}
}
