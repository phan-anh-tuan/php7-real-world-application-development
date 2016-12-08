<?php
namespace Application\Web;

class Request extends AbstractHttp {
	public function __construct($uri = NULL, $method = NULL, array $headers = NULL, array $data = NULL, array $cookies = NULL)
	{
		if (!$headers) $this->headers = $_SERVER ?? array();
		else $this->headers = $headers;

		if (!$uri) $this->uri = $this->headers['PHP_SELF'] ?? '';
		else $this->uri = $uri;
		
		if (!$method) $this->method = $this->headers['REQUEST_METHOD'] ?? self::METHOD_GET;
		else $this->method = $method;
		
		if (!$data) $this->data = $_REQUEST ?? array();
		else $this->data = $data;
		
		if (!$cookies) $this->cookies = $_COOKIE ?? array();
		else $this->cookies = $cookies;
		
		$this->setTransport();
	}
}