<?php

namespace Tools;

class LocationReflection
{
	
	const ID = 'id';
	
	const CREATED_AT = 'created_at';
	
	const COMMENTS = 'comments';
	
	
	public static function setPropertyLocation(\Model\Location $location, $value, $attribute = self::ID)
	{
		$reflection = new \ReflectionClass('Tools\LocationReflection');
		$locationRef = new \ReflectionClass(get_class($location));
		
		foreach($reflection->getConstants() as $constant)
		{
			if($attribute === $constant){
				$property = $locationRef->getProperty($constant);
				$property->setAccessible(true);
				$property->setValue($location, $value);
				break;
			}
		}
	}
}
