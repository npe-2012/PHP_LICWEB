<?php

namespace Exception;

class ForbiddenHttpException extends HttpException
{
	public function __construct($message = "You can't access to this page, try it in json", \Exception $previous = null)
	{
		parent::__construct('403', $message, $previous);
	}
}
 
