<?php
namespace Application\Web;

class Security {
	protected $filter = NULL;
	protected $validate = NULL;
	
	public function __construct() {
		$this->filter = [
				'striptags' => function($a) { return strip_tags($a);},
				'digits' => function($a) { return preg_replace('/[^0-9]/', '', $a);},
				'alpha' => function($a) { return preg_replace('/[^A-Za-z]/', '', $a);},
			];
		
		$this->validate = [
				'alnum' => function($a) { return ctype_alnum($a);},		
				'digits' => function($a) { return ctype_digit($a);},
				'alpha' => function($a) { return ctype_alpha($a);},
			];
	}
	
	public function __call($method, $params) {
		preg_match('/^(filter|validate)(.*?)$/i', $method, $matches);
		$prefix = $matches[1] ?? '';
		$function = strtolower($matches[2] ?? '');
		//echo 'calling '.$prefix . $function;
		if ($prefix && $function) {
			return $this->$prefix[$function]($params[0]);
		}
		return NULL;
	}
}