#!/usr/bin/env php
<?php

$error=null;
$cities=array();
$row=0;


if (($handle = fopen("../data/country.csv","r")) !== FALSE)
{
	while (($data = fgetcsv($handle,20,";")) !== FALSE)
	{
		if($country === $data[1])
		{
			$cities[$row]=$data[0];
			$row++;
			echo $data[0];
		}
	}
	
	fclose($handle);

}
else
{
	$error="fichier introuvable";
}

$cities = array_unique($cities);


