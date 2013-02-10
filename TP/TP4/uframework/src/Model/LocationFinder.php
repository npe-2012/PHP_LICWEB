<?php
use Model\Connection;

namespace Model;

class LocationFinder implements FinderInterface
{	
	private $connection = null;
	
	
	public function __construct(Connection $con)
	{
		$this->connection = $con;
	}
		
	/**
     * Returns all locations content into the DB
     * @return array 
     */
    public function findAll()
    {
		$callback = function($location)
		{
			$date = $location['created_at'];
			if(!empty($date)){
				$date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);
			}
			
			$loc = new Location($location['name'], $date);
			\Tools\LocationReflection::setPropertyLocation($loc, $location['id']);
			return $loc;
		};
		
		$query = "SELECT * FROM LOCATIONS";
		$stmt = $this->connection->prepare($query);
		$stmt->execute();
		return array_map($callback, $stmt->fetchAll(\PDO::FETCH_ASSOC));
	}

    /**
     * Retrieve an element by its id content into the DB
     * @param  $id The locations's id
     * @return null|Location
     */
    public function findOneById($id)
    {
		$query = "SELECT * FROM LOCATIONS WHERE id = :id";
		$stmt = $this->connection->prepare($query);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		$location = $stmt->fetch(\PDO::FETCH_ASSOC);
		
		if(!empty($location)){
			
			$date = $location['created_at'];
			
			if(!empty($date)){
				$date = new \DateTime($date);
			}
			
			$loc = new Location($location['name'], $date);
			\Tools\LocationReflection::setPropertyLocation($loc, $location['id']);
			\Tools\LocationReflection::setPropertyLocation($loc, $this->findCommentsByLocationId($id), \Tools\LocationReflection::COMMENTS);
			return $loc;
		}
		return null;
	}
	
	/**
	 * Retrieve the comments by the location's id into the DB
	 * @param $id The location's id
	 * @return null|array
	 */ 
	public function findCommentsByLocationId($id)
    {
		$callback = function($comment)
		{
			$date = $comment['created_at'];
			if(!empty($date)){
				$date = new \DateTime($date);
			}
			
			$com = new Comment($comment['username'], $comment['body'], $date);
			\Tools\CommentReflection::setPropertyComment($com, $comment['id']);
			return $com;
		};
		
        $query = 'SELECT * FROM COMMENTS WHERE LOCATION_ID = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $comments = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map($callback, $comments);
    }
}
