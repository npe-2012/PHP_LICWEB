<?php

namespace Model;

class Connection extends \PDO
{
	public function executeQuery($query, $parameters = array())
    {
        $stmt = $this->prepare($query);

        foreach ($parameters as $name => $value) {
            $stmt->bindValue(':' . $name, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function findAll()
    {
		$query = "SELECT * FROM LOCATIONS";
		$stmt = $this->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function findById($id)
	{
		$query = "SELECT * FROM LOCATIONS WHERE id = :id";
		$stmt = $this->prepare($query);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
} 
