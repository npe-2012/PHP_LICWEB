#!/usr/bin/env php
<?php

$error=null;
$countries=array();
$row=0;

if (($handle = fopen("../data/country.csv","r")) !== FALSE)
{
	while (($data = fgetcsv($handle,20,";")) !== FALSE)
	{
		$countries[$row]=$data[1];
		$row++;
	}
	
	fclose($handle);

}
else
{
	$error="fichier introuvable";
}

$countries = array_unique($countries);


