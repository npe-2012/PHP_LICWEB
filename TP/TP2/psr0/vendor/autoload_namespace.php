<?php

function myautoloader($className)
{
	require_once __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', '/', $className).'.php';
}

spl_autoload_register("myautoloader");
