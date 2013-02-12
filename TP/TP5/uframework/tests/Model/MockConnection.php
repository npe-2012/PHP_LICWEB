<?php


class MockConnection extends \Model\Connection
{
	public function __construct()
	{
	}
	
	
	public function executeQuery($query, $parameters = array())
    	{
        	$stmt = $this->prepare($query);

        	foreach ($parameters as $name => $value) {
            		$stmt->bindValue(':' . $name, $value);
        	}

        	return $stmt->queryString;
    	}
} 
