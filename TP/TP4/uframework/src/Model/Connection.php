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

        return $stmt->execute();
    }
    
    public function find($id = null)
    {
		$query = "SELECT * FROM LOCATIONS";
		if(null !== $id)
		{
			$query += " WHERE id = :id";
		}
		
		$stmt = $this->prepare($query);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
} 
