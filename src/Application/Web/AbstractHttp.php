<?php
namespace Application\Web;

class AbstractHttp {
	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	const METHOD_DELETE = 'DELETE';
	const CONTENT_TYPE_HTML = 'text/html';
	const CONTENT_TYPE_JSON = 'application/json';
	const CONTENT_TYPE_FORM_URL_ENCODED = 'application/x-www-form-urlencoded';
	const HEADER_CONTENT_TYPE = 'Content-Type';
	const TRANSPORT_HTTP = 'http';
	const TRANSPORT_HTTPS = 'https';
	const STATUS_200 = '200';
	const STATUS_401 = '401';
	const STATUS_500 = '500';
	
	protected $uri; 	// i.e. http://xxx.com/yyy
	protected $method; // i.e. GET, PUT, POST, DELETE
	protected $headers; // HTTP headers
	protected $cookies; // cookies
	protected $metaData; // information about the transmission
	protected $transport; // i.e. http or https
	protected $data = array();

	public function setMethod($method)
	{
		$this->method = $method;
	}
	public function getMethod()
	{
		return $this->method ?? self::METHOD_GET;
	}
	
	public function getUri() {
		return $this->uri;
	}
	
	/* public function setUri($uri) {
		$this->uri = $uri;
		return $this;
	} */
	
	public function setUri($uri, array $params = NULL)
	{
		$this->uri = $uri;
		$first = TRUE;
		if ($params) {
			$this->uri .= '?' . http_build_query($params);
		}
	}
	
	public function getDataEncoded()
	{
		return http_build_query($this->getData());
	}
	
	
	/* public function getHeaders() {
		return $this->headers;
	}
	public function setHeaders($headers) {
		$this->headers = $headers;
		return $this;
	} */
	
	public function setHeaderByKey($key, $value)
	{
		$this->headers[$key] = $value;
	}
	public function getHeaderByKey($key)
	{
		return $this->headers[$key] ?? NULL;
	}
		
	public function getCookies() {
		return $this->cookies;
	}
	public function setCookies($cookies) {
		$this->cookies = $cookies;
		return $this;
	}
	/* public function getMetaData() {
		return $this->metaData;
	} */
	public function setMetaData($metaData) {
		$this->metaData = $metaData;
		return $this;
	}
	public function getMetaDataByKey($key)
	{
		return $this->metaData[$key] ?? NULL;
	}
	public function getTransport() {
		return $this->transport;
	}
	
	/*public function setTransport($transport) {
		$this->transport = $transport;
		return $this;
	}*/
	
	public function getData() {
		return $this->data;
	} 
	
	public function getDataByKey($key)
	{
		return $this->data[$key] ?? NULL;
	}
	
	public function setData($data) {
		$this->data = $data;
		return $this;
	}
	
	public function setTransport($transport = NULL)
	{
		if ($transport) {
			$this->transport = $transport;
		} else {
			if (substr($this->uri, 0, 5) == self::TRANSPORT_HTTPS) {
				$this->transport = self::TRANSPORT_HTTPS;
			} else {
				$this->transport = self::TRANSPORT_HTTP;
			}
		}
	}
}