<?php

$autoload_map = array(
    'Coffee\Bali'        => 'Coffee/Bali.php',
    'Coffee\BlueMontain' => 'Coffee/BlueMontain.php',
    'Coffee\Sumatra'     => 'Coffee/Sumatra.php',
    'Soda\Lemonade'     => 'Soda/Lemonade.php',
    'Soda\Juice\Orange' => 'Soda/Juice/Orange.php',
    'Wine\Bordeaux'     => 'Wine/Bordeaux.php',
    'Wine\Chinon'       => 'Wine/Chinon.php',
);
$myautoloader = function($className) use ($autoload_map)
{
	require_once __DIR__ . DIRECTORY_SEPARATOR . $autoload_map[$className];
};

spl_autoload_register($myautoloader);
