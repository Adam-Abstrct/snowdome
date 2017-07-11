<?php

namespace App\Src;

require_once __DIR__.'/../../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Lib\CustomDateTime;
use App\Lib\SnowdomeAPI;
use App\Lib\EnergyCalculations;
use Exception;

$noDays = 28;

//Builds Unix Date Objects
$date = new CustomDateTime($noDays);
$dates = $date->returnDates();
$period = $date->setDatePeriod();

//Returns API info for given date range
try {
	$api = new SnowdomeAPI($dates);
	$token = $api->createAuthToken();

	// $totalTillToday = $api->returnFTPData(); // returns current totalTillToday
	$response = $api->createAPIURL($token); // gets daily data for a week
	$totalTillToday = $api->getDifference($token);
	 // gets lifetime date until yesterday

} catch (Exception $e) {
	print_r($e->getMessage());
}

//Calculates Needed info from the response array given
$calculate = new EnergyCalculations($response , $totalTillToday , $period , $dates , $noDays);
$data  = $calculate->calculateChartInfo();
$chart = $data['chart'];
$lifetime = $data['lifetime'];

echo json_encode([
	'chart' => $chart,
	'lifetime_generation' => $lifetime
]);
