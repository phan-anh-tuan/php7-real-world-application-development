<?php
use Application\Filter\ {
	Result, 
	Messages, 
	CallbackInterface
};
$config = [ 
		'filters' => [ 
				'trim' => new class () implements CallbackInterface {
					public function __invoke($item, $params): Result {
						$changed = array ();
						$filtered = trim ( $item );
						if ($filtered !== $item)
							$changed[] = Messages::$messages ['trim'];
						return new Result ( $filtered, $changed );
					}
				},
				'strip_tags' => new class () implements CallbackInterface {
					public function __invoke($item, $params): Result {
						$changed = array ();
						$filtered = strip_tags ( $item );
						if ($filtered !== $item)
							$changed[] = Messages::$messages ['strip_tags'];
						return new Result ( $filtered, $changed );
					}
				},
				// params: (int) length
				'length' => new class () implements CallbackInterface
				{
					public function __invoke($item, $params) : Result
					{
						$changed  = array();
						$filtered = substr($item, 0, $params['length']);
						if ($filtered !== $item) $changed[] = Messages::$messages['filter_length'];
						return new Result($filtered, $changed);
					}
				},
				// params: none
				'filter_float' => new class () implements CallbackInterface
				{
					public function __invoke($item, $params) : Result
					{
						$changed  = array();
						$filtered = (float) $item;
						if ($filtered !== $item) $changed[] = Messages::$messages['filter_float'];
						return new Result($filtered, $changed);
					}
				}
		] 
];