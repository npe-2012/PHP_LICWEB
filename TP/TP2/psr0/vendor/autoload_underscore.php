<?php

function myautoloader($className)
{
	require_once __DIR__ . DIRECTORY_SEPARATOR . str_replace('_', '/', $className).'.php';
}

spl_autoload_register("myautoloader");
