<?php

namespace Http;

class Request
{
	const GET    = 'GET';

    const POST   = 'POST';

    const PUT    = 'PUT';

    const DELETE = 'DELETE';
    
    private $parameters;
        
    
	/**
	 * Request's constructor
	 * @param $query An array of query string parameters($_GET)
	 * @param $request An array of  request paramters ($_POST)
	 */
    public function __construct(array $query = array(), array $request = array())
    {
		$this->parameters = array_merge($query, $request);
	}
    
    /**
     * Static function
     * Return an instance of Request class
     * @return Request
     */
    public static function createFormGlobals()
    {
		if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json'){
				
				$data    = file_get_contents('php://input');
                $request = @json_decode($data, true);
                $request = array_merge($request, array("_method" => $_SERVER['REQUEST_METHOD']));			
				
		}
		else{
			$request = $_POST;
		}
		return new self($_GET, $request);
	}
    
    
    public function getParameter($name, $default = null)
    {
		if(!empty($this->parameters[$name])){
			return $this->parameters[$name];
		}
		return $default;
	}
    
    /**
     * Return the request verb used
     *@return mixed
     */
    public function getMethod()
    {
		$method = $_SERVER['REQUEST_METHOD'];
		if(self::POST === $method){
			return $this->getParameter('_method', $method);
		}
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
		if($pos = strpos($uri, '?')){
			$uri = substr($uri, 0, $pos);
		}
		return $uri;
	}

	public function guessBestFormat()
	{
		if(isset($_SERVER['HTTP_ACCEPT'])){
			$negotiator = new \Negotiation\FormatNegotiator();
			return $negotiator->getBest($_SERVER['HTTP_ACCEPT'], ['html','json', '*/*']);
		}
	}
}
