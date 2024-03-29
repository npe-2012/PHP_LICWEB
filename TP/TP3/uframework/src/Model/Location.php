<?php

namespace Model;


class Location
{
	private $id;
	
	private $name;
	
	private $createdAt;
	
	
	public function __construct($id, $name, \DateTime $createdAt = null)
	{
		$this->id = $id;
		$this->name = $name;
		$this->createdAt = $createdAt;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function setName($name)
	{
		$this->name = $name;
	}
	
	public function getCreatedAt()
	{
		return $this->createdAt;
	}
} 
