<?php

$autoload = function($className)
{	
	if(!file_exists('./../cache.php'))
		file_put_contents('./../cache.php', "<?php return array();");
		
	$cache = require './../cache.php';
	$class = str_replace(array('_', '/', '\\'), '\\', $className);
	if(!empty($cache[$class]))
	{
		require_once __DIR__ . DIRECTORY_SEPARATOR .$cache[$class];
	}
	else
	{	
		if(file_exists(__DIR__ . DIRECTORY_SEPARATOR .'src/'.str_replace('\\', '/', $class).'.php'))
			$cache[$class] = 'src/'.str_replace('\\', '/', $class).'.php';
		else
			$cache[$class] = 'tests/'.str_replace('\\', '/', $class).'.php';
			
		file_put_contents('./../cache.php', "<?php return " . var_export($cache, true).";");
		require_once __DIR__ . DIRECTORY_SEPARATOR .$cache[$class];
	}
	
};
spl_autoload_register($autoload);
