<?php

namespace Exception;

class NotAcceptableHttpException extends HttpException
{
	public function __construct($message = 'Incorrect parameter', \Exception $previous = null)
	{
		parent::__construct('406', $message, $previous);
	}
}
