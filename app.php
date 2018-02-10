<?php
require('vendor/autoload.php');

if (!isset($argv[1]) || !is_numeric($argv[1])) {
    throw new \Exception('Missing or bad income value');
}

$calculator = new TaxCalculator();
$total = $calculator
    ->addEdge(new Edge(0, 50000000, 5))
    ->addEdge(new Edge(50000000, 250000000, 15))
    ->addEdge(new Edge(250000000, 500000000, 25))
    ->addEdge(new Edge(null, 500000000, 30))
    ->getTax((float)$argv[1]);

exit("Tax is $total");
;