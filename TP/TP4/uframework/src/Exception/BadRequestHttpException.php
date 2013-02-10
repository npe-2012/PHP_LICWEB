<?php

namespace Exception;

class BadRequestHttpException extends HttpException
{
	public function __construct($message = "You can't access to this page, try it in json", \Exception $previous = null)
	{
		parent::__construct('400', $message, $previous);
	}
}
 
 
