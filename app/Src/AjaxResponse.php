<?php 

namespace App\Src;

require_once dirname(dirname(__FILE__)).'/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Lib\CustomDateTime;
use App\Lib\SnowdomeAPI;
use App\Lib\EnergyCalculations;




//Builds Unix Date Objects
$date = new CustomDateTime();
$dates = $date->returnDates();
$period = $date->setDatePeriod();


//Returns API info for given date range
$api = new SnowdomeAPI($dates);
$response = $api->loadTestJSON();
	
//Calculates Needed info from the response array given	
$calculate = new EnergyCalculations($response , $period , $dates);
$ajaxResponse = $calculate->returnAllCalculations();

echo $ajaxResponse;
