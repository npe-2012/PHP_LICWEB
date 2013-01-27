<?php

namespace Http;

class Request
{
	const GET    = 'GET';

    const POST   = 'POST';

    const PUT    = 'PUT';

    const DELETE = 'DELETE';
    
    public static $instance = null;
    
    private $parameters = array();
    
    /**
     * Static function
     * Return an instance of Request class
     * @return Request
     */
    public static function createFormGlobals()
    {
		if(self::$instance === null)
			self::$instance = new self($_GET, $_POST);
		return self::$instance;
	}
    
    
	/**
	 * Request's constructor
	 * @param $query An array of query string parameters($_GET)
	 * @param $request An array of  request paramters ($_POST)
	 */
    public function __construct(array $query = array(), array $request = array())
    {
		$this->parameters = array_merge($query, $request);
	}
    
    
    public function getParameter($name, $default = null)
    {
		if(!empty($this->parameters[$name]))
			return $this->parameters[$name];
		return $default;
	}
    
    /**
     * Return the request verb used
     *@return mixed
     */
    public function getMethod()
    {
		$method = $_SERVER['REQUEST_METHOD'];
		if(self::POST === $method)
			return $this->getParameter('_method', $method);
		return $method;
	}
	
	/**
     * Return the request URI used
     * Return a request uri without query string
     *@return mixed
     */
	public function getUri()
	{
		$uri = $_SERVER['REQUEST_URI'];
		if($pos = strpos($uri, '?'))
		{
			$uri = substr($uri, 0, $pos);
		}
		return $uri;
	}
}
