<?php

namespace Tools;

class CommentReflection
{
	
	const ID = 'id';
	
	const CREATED_AT = 'created_at';
		
	
	public static function setPropertyComment(\Model\Comment $comment, $value, $attribute = self::ID)
	{
		$reflection = new \ReflectionClass('Tools\CommentReflection');
		$commentRef = new \ReflectionClass(get_class($comment));
		
		foreach($reflection->getConstants() as $constant)
		{
			if($attribute === $constant){
				$property = $commentRef->getProperty($constant);
				$property->setAccessible(true);
				$property->setValue($comment, $value);
				break;
			}
		}
	}
}
