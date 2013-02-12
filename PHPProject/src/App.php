<?php

use Exception\ExceptionHandler;
use Exception\HttpException;
use Routing\Route;
use View\TemplateEngineInterface;
use Http\Request;
use Http\Response;

class App
{
    

    /**
     * @var array
     */
    private $routes = array();

    /**
     * @var TemplateEngineInterface
     */
    private $templateEngine;

    /**
     * @var boolean
     */
    private $debug;

    /**
     * @var statusCode
     */
    private $statusCode;

    public function __construct(TemplateEngineInterface $templateEngine, $debug = false)
    {
        $this->templateEngine = $templateEngine;
        $this->debug          = $debug;

        $exceptionHandler = new ExceptionHandler($templateEngine, $this->debug);
        set_exception_handler(array($exceptionHandler, 'handle'));
    }

    /**
     * @param string $template
     * @param array  $parameters
     * @param int    $statusCode
     *
     * @return string
     */
    public function render($template, array $parameters = array(), $statusCode = 200)
    {
        $this->statusCode = $statusCode;

        return $this->templateEngine->render($template, $parameters);
    }

    /**
     * @param string   $pattern
     * @param callable $callable
     *
     * @return App
     */
    public function get($pattern, $callable)
    {
        $this->registerRoute(Request::GET, $pattern, $callable);

        return $this;
    }

    public function put($pattern, $callable)
    {
		$this->registerRoute(Request::PUT, $pattern, $callable);
		return $this;
	}
	
	public function post($pattern, $callable)
    {
		$this->registerRoute(Request::POST, $pattern, $callable);
		return $this;
	}
	
	public function delete($pattern, $callable)
    {
		$this->registerRoute(Request::DELETE, $pattern, $callable);
		return $this;
	}
	

    public function run(Request $request = null)
    {
		if($request === null)
			$request = Request::createFormGlobals();
			
        $method = $request->getMethod();
        $uri    = $request->getUri();

        foreach ($this->routes as $route) {
            if ($route->match($method, $uri)) {
                return $this->process($request, $route);
            }
        }

        throw new HttpException(404, 'Page Not Found');
    }

    /**
     * @param Route $route
     */
    private function process(Request $request, Route $route)
    {
        try {
            http_response_code($this->statusCode);
            $arguments = $route->getArguments();
            array_unshift($arguments, $request);
            $response = call_user_func_array($route->getCallable(), $arguments);
	
	    if(!$response instanceof Response){
	    	$response = new Response($response);
	    }
	    $response->send();
        } catch (HttpException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new HttpException(500, null, $e);
        }
    }

    /**
     * @param string   $method
     * @param string   $pattern
     * @param callable $callable
     */
    private function registerRoute($method, $pattern, $callable)
    {
        $this->routes[] = new Route($method, $pattern, $callable);
    }
    
    /**
     * Redirect a user to a page
     * @param $to the page to redirect the user
     * @param $statusCode status request code
     */
    public function redirect($to, $statusCode = 302)
    {
		http_response_code($statusCode);
		header(sprintf('Location: %s', $to));
		
		die;
	}
}
