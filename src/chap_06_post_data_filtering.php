<?php
require __DIR__ . '/Application/Autoload/Loader.php';
Application\Autoload\Loader::init ( __DIR__ );
include __DIR__ . '/chap_06_post_data_config_messages.php';
include __DIR__ . '/chap_06_post_data_config_callbacks.php';

$assignments = [ 
		'*' => [ 
				[ 
						'key' => 'trim',
						'params' => [ ] 
				],
				[ 
						'key' => 'strip_tags',
						'params' => [ ] 
				] 
		],
		'first_name' => [ 
				[ 
						'key' => 'length',
						'params' => [ 
								'length' => 128 
						] 
				] 
		],
		'last_name' => [ 
				[ 
						'key' => 'length',
						'params' => [ 
								'length' => 128 
						] 
				] 
		],
		'city' => [ 
				[ 
						'key' => 'length',
						'params' => [ 
								'length' => 64 
						] 
				] 
		],
		'budget' => [ 
				[ 
						'key' => 'filter_float',
						'params' => [ ] 
				] 
		] 
];

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
		'budget' => '123.45',
];


$badData = [
		'first_name' => 'This+Name<script>bad tag</script>Valid!',
		'last_name' => 'ThisLastNameIsWayTooLong
Abcdefghijklmnopqrstuvwxyz0123456789
Abcdefghijklmnopqrstuvwxyz0123456789
Abcdefghijklmnopqrstuvwxyz0123456789
Abcdefghijklmnopqrstuvwxyz0123456789',
		//'address' => '', // missing
		'city' => 'ThisCityNameIsTooLong0123456789012345678901234
56789012345678901234567890123456789 ',
		//'state_province' => '',
		'postal_code' => '!"£$%^Non Alpha Chars',
		'phone' => ' 12345 ',
		'country' => 'XX',
		'email' => 'this.is@not@an.email',
		'budget' => 'XXX',
];		

$filter = new Application\Filter\Filter($config['filters'], $assignments);
$filter->setSeparator(PHP_EOL);
$filter->process($goodData);
echo $filter->getMessageString();
var_dump($filter->getItemsAsArray());
$filter->process($badData);
echo $filter->getMessageString();
var_dump($filter->getItemsAsArray());
		
		
		
		
		
		
		
		
		
		