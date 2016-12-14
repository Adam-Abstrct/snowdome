<?php

namespace App\Src;

require_once __DIR__.'/../../vendor/autoload.php';

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

use App\Lib\CustomDateTime;
use App\Lib\SnowdomeAPI;
use App\Lib\EnergyCalculations;
use Exception;

$noWeeks = 7;

//Builds Unix Date Objects
$date = new CustomDateTime($noWeeks);
$dates = $date->returnDates();
$period = $date->setDatePeriod();

//Returns API info for given date range
try {
	$api = new SnowdomeAPI($dates);
	$token = $api->createAuthToken();
	$response = $api->createAPIURL($token);
	$lifetime = $api->getLifetimeGeneration($token);
} catch (Exception $e) {
	print_r($e->getMessage());
}

//Calculates Needed info from the response array given
$calculate = new EnergyCalculations($response , $period , $dates , $noWeeks);
$chart = $calculate->calculateChartInfo();

echo json_encode([
	'chart' => $chart,
	'lifetime_generation' => $lifetime
]);
