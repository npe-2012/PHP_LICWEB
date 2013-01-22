<?php

namespace Model;

class Locations implements FinderInterface
{
	
	private static $URI_DATA_LOCATIONS = "./../src/Data/Locations.csv";

		
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
	public function addLocation($name)
	{
		$locations = $this->loadData();
		$locations[$this->lastId()+1]= $name;
		$this->saveData($locations);
		return $locations;
		
	}
    
     /**
     * Load data of csv file
     *
     * @return array
     */
    private function loadData()
    {
		$locations=array();

		if (($handle = fopen(self::$URI_DATA_LOCATIONS,"r")) !== FALSE)
		{
			while (($data = fgetcsv($handle,20,";")) !== FALSE)
			{
				$locations[$data[0]]=$data[1];
			}
			fclose($handle);
		}		
		return $locations;
	}
	
	private function saveData($locations)
	{
		file_put_contents(self::$URI_DATA_LOCATIONS, " <?php return ".var_export($locations,true).";");
	}
	
	private function lastId()
	{
		return count($this->loadData())-1;
	}
}
