<?php
require __DIR__ . '/Application/Autoload/Loader.php';
Application\Autoload\Loader::init ( __DIR__ );
include __DIR__ . '/chap_06_post_data_config_messages.php';
include __DIR__ . '/chap_06_post_data_config_callbacks.php';

$assignments = [ 
		'first_name' => [ 
				[ 
						'key' => 'length',
						'params' => [ 
								'min' => 1,
								'max' => 128 
						] 
				],
				[ 
						'key' => 'alnum',
						'params' => [ 
								'allowWhiteSpace' => TRUE 
						] 
				],
				[ 
						'key' => 'required',
						'params' => [ ] 
				] 
		],
		'last_name' => [ 
				[ 
						'key' => 'length',
						'params' => [ 
								'min' => 1,
								'max' => 128 
						] 
				],
				[ 
						'key' => 'alnum',
						'params' => [ 
								'allowWhiteSpace' => TRUE 
						] 
				],
				[ 
						'key' => 'required',
						'params' => [ ] 
				] 
		],
		'address' => [ 
				[ 
						'key' => 'length',
						'params' => [ 
								'max' => 256 
						] 
				] 
		],
		'city' => [ 
				[ 
						'key' => 'length',
						'params' => [ 
								'min' => 1,
								'max' => 64 
						] 
				] 
		],
		'state_province' => [ 
				[ 
						'key' => 'length',
						'params' => [ 
								'min' => 1,
								'max' => 32 
						] 
				] 
		],
		
		'postal_code' => [ 
				[ 
						'key' => 'length',
						'params' => [ 
								'min' => 1,
								'max' => 16 
						] 
				],
				[ 
						'key' => 'alnum',
						'params' => [ 
								'allowWhiteSpace' => TRUE 
						] 
				],
				[ 
						'key' => 'required',
						'params' => [ ] 
				] 
		],
		'phone' => [ 
				[ 
						'key' => 'phone',
						'params' => [ ] 
				] 
		],
		'country' => [ 
				[ 
						'key' => 'in_array',
						'params' => $countries 
				],
				[ 
						'key' => 'required',
						'params' => [ ] 
				] 
		],
		'email' => [ 
				[ 
						'key' => 'email',
						'params' => [ ] 
				],
				[ 
						'key' => 'length',
						'params' => [ 
								'max' => 250 
						] 
				],
				[ 
						'key' => 'required',
						'params' => [ ] 
				] 
		],
		'budget' => [ 
				[ 
						'key' => 'float',
						'params' => [ ] 
				] 
		] 
]
;

$goodData = [ 
		'first_name' => 'Your Full',
		'last_name' => 'Name',
		'address' => '123 Main Street',
		'city' => 'San Francisco',
		'state_province' => 'California',
		'postal_code' => '94101',
		'phone' => '+1 415-555-1212',
		'country' => 'US',
		'email' => 'your@email.address.com',
		'budget' => '123.45' 
];

$badData = [ 
		'first_name' => 'This+Name<script>bad tag</script>Valid!',
		'last_name' => 'ThisLastNameIsWayTooLong
Abcdefghijklmnopqrstuvwxyz0123456789
Abcdefghijklmnopqrstuvwxyz0123456789
Abcdefghijklmnopqrstuvwxyz0123456789
Abcdefghijklmnopqrstuvwxyz0123456789',
		// 'address' => '', // missing
		'city' => 'ThisCityNameIsTooLong0123456789012345678901234
56789012345678901234567890123456789 ',
		// 'state_province' => '',
		'postal_code' => '!"£$%^Non Alpha Chars',
		'phone' => ' 12345 ',
		'country' => 'XX',
		'email' => 'this.is@not@an.email',
		'budget' => 'XXX' 
];

$validator = new Application\Filter\Validator ( $config ['validators'], $assignments );
$validator->setSeparator ( PHP_EOL );
$validator->process ( $badData );
echo $validator->getMessageString ( 40, '%14s : %-26s' . PHP_EOL );
var_dump ( $validator->getItemsAsArray () );
$validator->process ( $goodData );
echo $validator->getMessageString ( 40, '%14s : %-26s' . PHP_EOL );
var_dump ( $validator->getItemsAsArray () );