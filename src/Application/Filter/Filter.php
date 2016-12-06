<?php

namespace Application\Filter;

class Filter extends AbstractFilter {
	public function process(array $data) {
		if (! (isset ( $this->assignments ) && count ( $this->assignments ))) {
			return NULL;
		}
		foreach ( $data as $key => $value ) {
			$this->results [$key] = new Result ( $value, array () );
		}
		
		$toDo = $this->assignments;
		if (isset($toDo['*'])) {
			$this->processGlobalAssignment($toDo['*'], $data);
			unset($toDo['*']);
		}
		
		foreach ($toDo as $key => $assignment) {
			$this->processAssignment($assignment, $key);
		}
	}
	
	protected function processGlobalAssignment($assignment, $data) {
		foreach ($assignment as $callback) {
			if ($callback == NULL) continue;
			foreach ($data as $k => $v) {
				$result = $this->callbacks[$callback['key']]($this->results[$k]->item, $callback['params']);
				$this->results[$k]->mergeResult($result);
			}
		}
	}
	
	protected function processAssignment($assignment, $key)
	{
		foreach ($assignment as $callback) {
			if ($callback === NULL) continue;
			$result = $this->callbacks[$callback['key']]($this->results[$key]->item,$callback['params']);
			$this->results[$key]->mergeResult($result);
		}
	}
}