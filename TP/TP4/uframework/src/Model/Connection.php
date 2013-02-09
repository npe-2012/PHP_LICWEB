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
} 
