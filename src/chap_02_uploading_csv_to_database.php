<?php
define('DB_CONFIG_FILE', '/../config/db.config.php');
define('CSV_FILE', '/../data/prospects.csv');
require __DIR__ . '/Application/Autoload/Loader.php';
Application\Autoload\Loader::init(__DIR__);


$connection = new Application\Database\Connection(include __DIR__ . DB_CONFIG_FILE);
$sql = 'INSERT INTO `prospects`(`Name`,`Address`,`Floors`,`Donated last year`,`Contact`) VALUES (?,?,?,?,?)';
$statement = $connection->pdo->prepare($sql);

$iterator = (new Application\Iterator\LargeFile(__DIR__ . CSV_FILE))->getIterator('Csv');

foreach ($iterator as $row) {
	if($row) {
		echo implode(',', $row) . PHP_EOL;
		$statement->execute($row);
	}
}
