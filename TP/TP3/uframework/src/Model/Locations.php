<?php

namespace Model;

class Locations implements FinderInterface
{
	
	private static $URI_DATA_LOCATIONS = "./../src/Data/Locations.json";

		
	/**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll()
    {
		return array_unique($this->loadData());
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
		
		foreach($this->loadData() as $key => $val)
		{
			if( $key === intval($id))
			{
				$location = $val;
			}
		}
		
		if(!Empty($location ))
		{
			return $location ;
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
		$locations = $this->loadData();
		$locations[$this->nextId()]= $name;
		$locations = array_unique($locations);
		$this->saveData($locations);
		return $locations;
		
	}
	
	/**
     * update a location
     * @param mixed $id
     * @param mixed $name
     * @return mixed
     */
    public function update($id, $name)
    {
		$locations = $this->loadData();
		if(!empty($locations[$id]))
		{
			$locations[$id] = $name;
			$this->saveData($locations);
		}
	}
    
    
    /**
     * delete a location
     * @param mixed $id
     */
    public function delete($id)
    {
		$locations = $this->loadData();
		if(!empty($locations[$id]))
		{
			unset($locations[$id]);
			$this->saveData($locations);
		}
	}
	
    
     /**
     * Load data of csv file
     *
     * @return array
     */
    private function loadData()
    {
		return json_decode(file_get_contents(self::$URI_DATA_LOCATIONS));
	}
	
	private function saveData($locations)
	{
		file_put_contents(self::$URI_DATA_LOCATIONS, json_encode($locations));	
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
