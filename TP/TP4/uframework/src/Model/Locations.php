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
		foreach($this->connection->find() as $val)
		{
		$callback = function($location){
			$createdAt = $location['created_at'];
			if(null !== $createdAt ){
				$createdAt = strtotime($createdAt);
			}
			
			return new \Model\Location($location['id'], $location['name'], $createdAt);
		};
		return array_map($callback, $this->connection->find());
	}

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
		$location = "";
		
		foreach(array_unique($this->loadData()) as $key => $val)
		{
			if( $key === intval($id))
			{
				$location = $val;
			}
		}
		
		if(!Empty($location ))
		{
			return array('id' => $id, 'name' => $location);
		}
		else
		{
			return null;
		}
	}
	
	 /**
     * Add a location
     *
     * @param  mixed      $name
     * @return array
     */
	public function create($name)
	{
		$query = 'INSERT INTO LOCATIONS(name) VALUES(:name)';
		
		return $this->connection->executeQuery($query, array('name' => $name));		
	}
	
	/**
     * update a location
     * @param mixed $id
     * @param mixed $name
     * @return array|null
     */
    public function update($id, $name)
    {
		$id = intval($id);
		$query = 'UPDATE LOCATIONS SET name = :name WHERE id = :id';
		$location = $this->find($id);
		if(!empty($location))
		{
			return $this->connection->executeQuery($query, array(
				'id' => $id,
				'name' => $name
			));
		}
		return null;
	}
    
    
    /**
     * delete a location
     * @param mixed $id
     * @return array|null
     */
    public function delete($id)
    {
		$id = intval($id);
		$query = 'DELETE FROM LOCATIONS WHERE id = :id';
		$location = $this->find($id);
		if(!empty($location))
		{
			return $this->connection->executeQuery($query, array(
				'id' => $id
			));
		}
		return null;
	}
	
    
     /**
     * Load data of csv file
     *
     * @return array
     */
    private function loadData()
    {
		return array_unique(json_decode(file_get_contents(self::$URI_DATA_LOCATIONS), true));
	}
	
	private function saveData($locations)
	{
		file_put_contents(self::$URI_DATA_LOCATIONS, json_encode(array_unique($locations), JSON_FORCE_OBJECT));	
	}
	
	private function lastId()
	{
		return count($this->loadData())-1;
	}
	
	private function nextId()
	{
		return count($this->loadData());
	}
}
