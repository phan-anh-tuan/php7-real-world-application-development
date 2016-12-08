<?php
define('DEFAULT_ORIGIN', 'New York City');
define('DEFAULT_DESTINATION', 'Redondo Beach');
define('DEFAULT_FORMAT', 'json');
$apiKey = include __DIR__ . '/google_api_key.php';

require __DIR__ . '/Application/Autoload/Loader.php';

Application\Autoload\Loader::init(__DIR__);

use Application\Web\Request;
use Application\Web\Client\Curl;
use Application\Web\Client\Streams;

$start = $_GET['start'] ?? DEFAULT_ORIGIN;
$end = $_GET['end'] ?? DEFAULT_DESTINATION;
$start = strip_tags($start); 
$end = strip_tags($end);

$request = new Request('https://maps.googleapis.com/maps/api/directions/json',
						Request::METHOD_GET,
						NULL,
						['origin' => $start, 'destination' => $end, 'key' => $apiKey],
						NULL);
//$received = Curl::send($request);
$received = Streams::send($request);
var_dump($received->getData());
$routes = $received->getData()->routes[0];
include __DIR__ . '/chap_07_simple_rest_client_google_maps_template.php';






