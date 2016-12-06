<?php
namespace Application\Filter;

class Result {
	public $item; // (mixed)m filter data | (bool) result of validation
	public $message = array(); // [(string)message, (string) message]
	
	public function __construct($item,$message) {
		$this->item = $item;
		if (is_array($message)) {
			$this->message = $message;
		} else {
			$this->message = [$message];
		}
	}
	
	public function mergeResult(Result $result) {
		$this->item = $result->item;
		$this->mergeMessages($result);
	}
	
	public function mergeMessages(Result $result) {
		if (isset($result->message) && is_array($result->message)) {
			$this->message = array_merge($this->message,$result->message);
		}
	}
	
	public function mergeValidationResults(Result $result) {
		if ($this->item === TRUE) {
			$this->item = (bool)$result->item;
		}
		$this->mergeMessages($result);
	}
}