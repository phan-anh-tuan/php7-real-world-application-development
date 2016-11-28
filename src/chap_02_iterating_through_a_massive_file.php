<?php
require __DIR__ . '/Application/Autoload/Loader.php';
\Application\Autoload\Loader::init(__DIR__);

define('MASSIVE_FILE',__DIR__ . '/../data/story.txt');

try {
	$largeFile = new Application\Iterator\LargeFile(MASSIVE_FILE);
	$iterator = $largeFile->getIterator();
	$words = 0;
	
	foreach ($iterator as $line) {
		$words +=  str_word_count($line);
	}
	echo str_repeat('-', 52) . PHP_EOL;
	printf("%-40s : %8d\n", "Total words", $words);
	printf("%-40s : %8d\n", "Average words per line", $words/$iterator->getReturn());
	echo str_repeat('-', 52) . PHP_EOL;
} catch (Throwable $e) {
	$e->getMessage();
}

