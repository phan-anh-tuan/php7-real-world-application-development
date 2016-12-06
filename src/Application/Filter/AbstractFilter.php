<?php

namespace Application\Filter;

use UnexpectedValueException;

abstract class AbstractFilter {
	const BAD_CALLBACK = 'Must implement CallbackInterface';
	const DEFAULT_SEPARATOR = '<br>' . PHP_EOL;
	const MISSING_MESSAGE_KEY = 'item.missing';
	const DEFAULT_MESSAGE_FORMAT = '%20s : %60s';
	const DEFAULT_MISSING_MESSAGE = 'Item Missing';
	protected $separator; // used for message display
	protected $callbacks;
	protected $assignments;
	protected $missingMessage;
	protected $results = array ();
	public function __construct(array $callbacks, array $assignments, $separator = NULL, $message = NULL) {
		$this->setCallbacks($callbacks);
		$this->setAssignments($assignments);
		$this->setSeparator($separator ?? self::DEFAULT_SEPARATOR);
		$this->setMissingMessage($message ?? self::DEFAULT_MISSING_MESSAGE);
	}
	public function getCallbacks() {
		return $this->callbacks;
	}
	public function getOneCallback($key) {
		return $this->callbacks [$key] ?? NULL;
	}
	public function setCallbacks(array $callbacks) {
		foreach ( $callbacks as $key => $item ) {
			$this->setOneCallback ( $key, $item );
		}
	}
	public function setOneCallback($key, $item) {
		if ($item instanceof CallbackInterface) {
			$this->callbacks [$key] = $item;
		} else {
			throw new UnexpectedValueException ( self::BAD_CALLBACK );
		}
	}
	public function removeOneCallback($key) {
		if (isset ( $this->callbacks [$key] ))
			unset ( $this->callbacks [$key] );
	}
	public function getResults()
	{
		return $this->results;
	}
	public function getItemsAsArray()
	{
		$return = array();
		if ($this->results) {
			foreach ($this->results as $key => $result)
				$return[$key] = $result->item;
		}
		return $return;
	}	
	public function getMessages() {
		if ($this->result) {
			foreach($this->result as $key=>$result) {
				if ($result->message) yield  from $result->message;
			}
		} else {
			return array();
		}
	}
	public function getMessageString($width = 80, $format = NULL)
	{
		if (!$format) $format = self::DEFAULT_MESSAGE_FORMAT . $this->separator;
		$output = '';
		if ($this->results) {
			foreach ($this->results as $key => $value) {
				if ($value->message) {
					foreach ($value->message as $message) {
						$output .= sprintf($format, $key, trim($message));
					}
				}
			}
		}
		return $output;
	}
	public function setMissingMessage($message)
	{
		$this->missingMessage = $message;
	}
	public function setSeparator($separator)
	{
		$this->separator = $separator;
	}
	public function getSeparator()
	{
		return $this->separator;
	}
	public function getAssignments()
	{
		return $this->assignments;
	}
	public function setAssignments(array $assignments)
	{
		$this->assignments = $assignments;
	}
}