<?php
require __DIR__ . '/Application/Autoload/Loader.php';
Application\Autoload\Loader::init(__DIR__);
use Application\Parse\ConvertXml;

$wsdl = 'http://graphical.weather.gov/xml/SOAP_server/ndfdXMLserver.php?wsdl';
$xml = new SimpleXMLIterator($wsdl, 0, TRUE);
$convert = new ConvertXml();
var_dump($convert->xmlToArray($xml));