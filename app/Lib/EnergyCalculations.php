<?php

namespace App\Lib;

use DateTimeZone;
use DateTime;
use DateInterval;
use DatePeriod;


/**
*
*/
class EnergyCalculations
{
	public $generation;
	public $consumption;
	public $datePeriod;
	public $noWeeks;

	function __construct($info , $period , $dates , $weeks )
	{
		$this->generation = $info;
		// $this->results = $info;
		$this->datePeriod = $period;
		$this->dates = $dates;
		$this->noWeeks = $weeks;
	}

	/**
	 * Returns Information for the man chart
	 *
	 * - takes to/from date and date period
	 * - creates unix date period
	 * - loops through generated readings array and finds matching unix timestamps
	 * - loops through generated consumption array and finds matching unix timestamps
	 * - returns json encoded array of generation, consumption & legend
	 *
	 *
	 * @return Array Json encoded Array
	 */
	public function calculateChartInfo()
	{

	    $legend = [];
	    $formattedDates = [];

	    foreach ($this->datePeriod as $key => $dates) {
	      if($key%7 == 0) {
					$legend[] = $dates->format('d-M');
	    	}
	      $formattedDates[] =  (int) $dates->format("U");
	    }

	    $selectedDates = [];
	    foreach ($this->generation->readings as $value) {
	    	if(in_array($value->timestamp, $formattedDates))
	    	{
	    		$selectedValues[] = round($value->value, 2);
	    	}
	    }

	    $newArray = [];
	    $key = 0;
	    $weeklyValue = 0;
	    for ($i=0; $i < count($selectedValues) ; $i++) {
	    	$weeklyValue += $selectedValues[$i];

	    	if($i%7 == 0 && $i !== 0) {
				$newArray[$key] = $weeklyValue;
				$weeklyValue = 0;
				$key++;
	    	}
	    }

	    return ['generated' => $newArray , 'legend' => $legend ];

	}

}
