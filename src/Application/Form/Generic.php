<?php
namespace Application\Form;

class Generic {
	const ROW = 'row';
	const FORM = 'form';
	const INPUT = 'input';
	const LABEL = 'label';
	const ERRORS = 'errors';
	const TYPE_FORM = 'form';
	const TYPE_TEXT = 'text';
	const TYPE_EMAIL = 'email';
	const TYPE_RADIO = 'radio';
	const TYPE_SUBMIT = 'submit';
	const TYPE_SELECT = 'select';
	const TYPE_PASSWORD = 'password';
	const TYPE_CHECKBOX = 'checkbox';
	const DEFAULT_TYPE = self::TYPE_TEXT;
	const DEFAULT_WRAPPER = 'div';
	
	protected $name;
	protected $type = self::DEFAULT_TYPE;
	protected $label	= '';
	protected $errors = array();
	protected $wrappers;
	protected $attributes; 	// HTML form attributes
	protected $pattern = '<input type="%s" name="%s" %s>';
	
	public function __construct($name, $type, $label = '', array $wrappers = array(), array $attributes = array(), array $errors = array()) 
	{
		$this->name = $name;
		if ($type instanceof Generic) {
			$this->type = $type->getType();
			$this->label = $type->getLabelValue();
			$this->errors = $type->getErrorsArray();
			$this->wrappers = $type->getWrappers();
			$type->attributes = $type->getAttributes();
		} else {
			$this->type = $type;
			$this->label = $label;
			$this->errors = $errors;
			if ($wrappers) {
				$this->wrappers = $wrappers;
			} else {
				$this->wrappers[self::INPUT]['type'] = self::DEFAULT_WRAPPER;
				$this->wrappers[self::LABEL]['type'] = self::DEFAULT_WRAPPER;
				$this->wrappers[self::ERRORS]['type'] = self::DEFAULT_WRAPPER;
			}
			$this->attributes = $attributes;
			//var_dump($this->attributes);
		}
		$this->attributes['id'] = $name;
	}
	
	public function getWrapperPattern($type) {
		$pattern = '<' . $this->wrappers[$type]['type'];
		foreach ($this->wrappers[$type] as $key => $value) {
			if ($key != 'type') {
					$pattern .= ' ' . $key . '="' . $value .'"';
			}
		}
		$pattern .= '>%s</' . $this->wrappers[$type]['type'] . '>';
		return $pattern;
	}
	
	public function getLabel() {
		return sprintf($this->getWrapperPattern(self::LABEL),$this->label);		
	}
	
	public function getAttribs() {
		$attribs = '';
		foreach($this->attributes as $key => $value) {
			if ($value) {
				if ($key == 'value') {
					if (is_array($value)) {
						foreach($value as $k=>$i) {
							$value[$k] = htmlspecialchars($i);
						}
					} else {
						$value = htmlspecialchars($value);
					}
				} elseif ($key == 'href') {
					$value = urlencode($value);	
				} 
				$attribs .= $key . '="' . $value .'" ';
			} else {
				//var_dump($key . ' ' . $value);
				$attribs .= $key . ' ';
			}
		}
		//var_dump($attribs);
		return trim($attribs);
	}
	
	public function getInputOnly() {
		return sprintf($this->pattern,$this->type,$this->name,$this->getAttribs());
	}
	
	public function getInputWithWrapper() {
		return sprintf($this->getWrapperPattern(self::INPUT),$this->getInputOnly());
	}
	
	public function getErrors() {
		if (!$this->errors || count($this->errors) == 0) return '';
		$html = '<ul>';
		$pattern = '<li>%s</li>';
		foreach($this->errors as $error)
			$html .= sprintf($pattern,$error);
		$html .= '</ul>';
		return sprintf($this->getWrapperPattern(self::ERRORS),$html);
	}
	
	public function setSingleAttribute($key, $value)
	{
		$this->attributes[$key] = $value;
	}
	
	public function addSingleError($error)
	{
		$this->errors[] = $error;
	}
	
	public function setPattern($pattern)
	{
		$this->pattern = $pattern;
	}
	
	public function setName($name)
	{
		$this->name = $name;
	}
	public function getName()
	{
		return $this->name;
	}
		
	public function setType($type)
	{
		$this->type = $type;
	}
	public function getType()
	{
		return $this->type;
	}
	
	public function setLabel($lable)
	{
		$this->label = $lable;
	}
	
	public function getLabelValue()
	{
		return $this->label;
	}
	
	public function setErrors($errors) {
		$this->errors = $errors;
	}
	
	public function getErrorsArray()
	{
		return $this->errors;
	}
	
	public function setWrappers($wrappers) {
		$this->wrappers = $wrappers;
	}
	
	public function getWrappers() {
		return $this->wrappers;
	}

	public function setAttributes($attributes) {
		$this->attributes = $attributes;
	}
	
	public function getAttributes() {
		return $this->attributes;
	}
	
	public function render($renderInputWithWrapper = true) {
		if ($renderInputWithWrapper) {
			return $this->getLabel() . $this->getInputWithWrapper() . $this->getErrors();
		}
		return $this->getLabel() . $this->getInputOnly() . $this->getErrors();
	}
}
