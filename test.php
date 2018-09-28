<?php

use Pilipinews\Website\Pna\Scraper;

require 'vendor/autoload.php';

// $link = 'https://newsinfo.inquirer.net/937374/miaa-flights-cancellation-tropical-depression-odette-tuguegarao';
// $link = 'https://newsinfo.inquirer.net/1031092/mangkhut-intensifies-as-it-nears-par';
// $link = 'https://newsinfo.inquirer.net/1031695/pcg-marina-suspend-sea-voyage-in-areas-affected-by-ompong';
$link = 'https://newsinfo.inquirer.net/1032068/signal-no-3-raised-in-isabela-as-ompong-maintains-strength';

$article = (new Scraper)->scrape((string) $link);

file_put_contents('test.txt', $article->post());
