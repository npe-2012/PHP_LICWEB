<?php 

namespace Exception;

class NotFoundHttpException extends HttpException
{
	public function __construct($message = 'Location not found', \Exception $previous = null)
	{
		parent::__construct('404', $message, $previous);
	}
}
