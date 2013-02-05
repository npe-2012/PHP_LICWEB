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
		$locations = $this->loadData();
		$id = $this->nextId();
		$locations[intval($id)]= $name;
		$this->saveData($locations);
		return array('id' => $id, 'name' => $locations);
		
	}
	
	/**
     * update a location
     * @param mixed $id
     * @param mixed $name
     * @return array|null
     */
    public function update($id, $name)
    {
		$locations = $this->loadData();
		$id = intval($id);
		if(!empty($locations[$id]))
		{
			$locations[$id] = $name;
			$this->saveData($locations);
			return array('id' => $id, 'name' => $name);
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
		$locations = $this->loadData();
		$id = intval($id);
		if(!empty($locations[$id]))
		{
			unset($locations[$id]);
			$this->saveData($locations);
			return $locations;
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
