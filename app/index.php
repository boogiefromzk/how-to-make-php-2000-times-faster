<?php

function fibonacci($number) 
{
    if ($number == 0) {
        return 0;
    } elseif ($number == 1) {
        return 1;
    } else {
        return fibonacci($number - 1) + fibonacci($number - 2);
    }
}

function fibonacci_loop($repeat, $number) 
{
    $result = 0;
    for ($i = 0; $i < $repeat; $i++) {
        $result = fibonacci($number);
    }
    return $result;
}

require_once "mylib.php";
$myLib = new MyLib();

echo '<pre>';

$repeat = 50;
$number = 32;

$startTime = microtime(true);
$myLib->fibonacci_loop($repeat, $number);
$executionTimeRust = microtime(true) - $startTime;

echo "Running fibonacci number calculation $repeat times for $number number."."\n";

echo "Fully on Rust execution time: <strong>$executionTimeRust</strong> sec."."\n";

$startTime = microtime(true);
for ($i = 0; $i < $repeat; $i++) { 
    $myLib->fibonacci($number);
}
$executionTimeRustPhp = microtime(true) - $startTime;

echo "Calling Rust function in PHP loop execution time: <strong>$executionTimeRustPhp</strong> sec."."\n";

$startTime = microtime(true);
fibonacci_loop($repeat, $number);
$executionTimePhp = microtime(true) - $startTime;

echo "Fully on PHP execution time: <strong>$executionTimePhp</strong> sec."."\n";

$boostFactor = $executionTimePhp/$executionTimeRust;
echo "Total boost: <strong>$boostFactor</strong> times." . "\n";
        
echo '</pre>';