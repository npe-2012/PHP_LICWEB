<?php

$autoload = function($className)
{	
	
	$cache = require __DIR__ . DIRECTORY_SEPARATOR . 'cache.php';
	$class = str_replace(array('_', '/', '\\'), '\\', $className);
	if(!empty($cache[$class]))
	{
		require_once __DIR__ . DIRECTORY_SEPARATOR . $cache[$class];
	}
	else
	{	
		$cache[$class] = str_replace('\\', '/', $class).'.php';
		file_put_contents('./vendor/cache.php', "<?php return " . var_export($cache, true).";");
		require_once __DIR__ . DIRECTORY_SEPARATOR . $cache[$class];
	}
	
};
spl_autoload_register($autoload);
