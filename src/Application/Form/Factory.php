<?php
namespace Application\Form;

class Factory
{
	protected $elements;
	public function getElements()
	{
		return $this->elements;
	}
	// remaining code
	
	public static function generate(array $config)
	{
		$form = new self();
		foreach ($config as $key => $p) {
			$p['errors'] = $p['errors'] ?? array();
			$p['wrappers'] = $p['wrappers'] ?? array();
			$p['attributes'] = $p['attributes'] ?? array();
			$form->elements[$key] = new $p['class']
			(
				$key,
				$p['type'],
				$p['label'],
				$p['wrappers'],
				$p['attributes'],
				$p['errors']
			);
			if (isset($p['options'])) {
				list($a,$b,$c,$d) = $p['options'];
				switch ($p['type']) {
					case Generic::TYPE_RADIO:
					case Generic::TYPE_CHECKBOX :
						$form->elements[$key]->setOptions($a,$b,$c,$d);
						break;
					case Generic::TYPE_SELECT:
						$form->elements[$key]->setOptions($a,$b);
						break;
					default:
						$form->elements[$key]->setOptions($a,$b);
						break;
				}
			}
		}
		return $form;
	}
	
	protected function getWrapperPattern($wrapper)
	{
		$type = $wrapper['type'];
		unset($wrapper['type']);
		$pattern = '<' . $type;
		foreach ($wrapper as $key => $value) {
			$pattern .= ' ' . $key . '="' . $value . '"';
		}
		$pattern .= '>%s</' . $type . '>';
		return $pattern;
	}
}