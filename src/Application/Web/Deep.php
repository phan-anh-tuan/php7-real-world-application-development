<?php
namespace Application\Web;

class Deep {
	protected $domain;
	
	protected function getDomain($url) {
		if (!$this->domain) {
			$this->domain = parse_url($url, PHP_URL_HOST);
		}
		return $this->domain;
	}
	
	public function scan($url, $tag) {
		$vac = new Hoover();
		$scan = $vac->getAttribute($url, 'href', $this->getDomain($url));
		foreach($scan as $subSite) {
			yield from $vac->getTags($subSite, $tag);
		}
		return count($scan);
	}
}