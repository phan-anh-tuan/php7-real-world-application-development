<?php
namespace Application\Form\Element;
use Application\Form\Generic;

class Radio extends Generic {
	const DEFAULT_AFTER = TRUE;
	const DEFAULT_SPACER = '&nbps;';
	const DEFAULT_OPTION_KEY = 0;
	const DEFAULT_OPTION_VALUE = 'Choose';
	
	protected $after = self::DEFAULT_AFTER;
	protected $spacer = self::DEFAULT_SPACER;
	protected $options = array();
	protected $selectedKey = DEFAULT_OPTION_KEY;
	
	
	public function setOptions(array $options,
			$selectedKey = self::DEFAULT_OPTION_KEY,
			$spacer = self::DEFAULT_SPACER,
			$after = TRUE)
	{
		$this->after = $after;
		$this->spacer = $spacer;
		$this->options = $options;
		$this->selectedKey = $selectedKey;
	}
	
	public function getInputOnly() {
		$output = '';
		$count = 1;
		$baseId = $this->attributes['id'];
		foreach ($this->options as $key => $value) {
			$this->attributes['id'] = $baseId . $count++;
			$this->attributes['value'] = $key;
			if ($key == $this->selectedKey) {
				$this->attributes['checked'] = '';
			} else {
				if (isset($this->attributes['checked'])) {
					unset($this->attributes['checked']);
				}
			}
			if ($this->after) {
				$html = parent::getInputOnly() . $value; 
			} else {
				$html = $value . parent::getInputOnly();
			}
			$output .= $this->spacer . $html;
		}
		return $output;
	}
	
}