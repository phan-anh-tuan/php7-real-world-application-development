<?php
namespace Application\Web;

use DOMDocument;

class Hoover {
	protected $content = NULL; //content of a website
	
	public function getContent($url) {
		if (!$this->content) {
			if (stripos($url, 'http') !== 0) {
				$url = 'http://' . $url;
			}
			
			$this->content = new \DOMDocument('1.0','utf-8');
			$this->content->preserveWhiteSpace = FALSE;
			//@ used to suppress warning generated from improperly configured web page
			$this->content->loadHTMLFile($url);
		}
		return $this->content;
	}
}