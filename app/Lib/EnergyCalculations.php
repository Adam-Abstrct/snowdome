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
	public $today;

	function __construct($info , $totalTillToday, $totalTillYesterday , $period , $dates , $weeks )
	{

		$this->generation = $info;
		$this->totalToday = $totalTillToday;
		$this->totalYesterday = $totalTillYesterday;
		$this->datePeriod = $period;
		$this->dates = $dates;
		$this->noWeeks = $weeks;

		// var_dump($this->totalToday , $this->totalYesterday);
		// die;

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

		$UTC = new DateTimeZone("UTC");
		$now = new DateTime('today', $UTC );
		$nowUTC = $now->format("U");

		$legend = [];
    $formattedDates = [];

		// var_dump($this->datePeriod);
		// die;


	    foreach ($this->datePeriod as $key => $dates) {
				$legend[] = $dates->format('d-M');
	      $formattedDates[] =  (int) $dates->format("U");
	    }



	    $selectedValues = [];
	    foreach ($this->generation->readings as $value) {

				if($value->timestamp == $nowUTC )
				{
					$selectedValues[] = round($this->totalToday - $this->totalYesterday);
				} else if(in_array($value->timestamp, $formattedDates))
	    	{
	    		$selectedValues[] = round($value->value, 2);
	    	}


	    }
			//
			// var_dump($selectedValues);
			// die;


	    return ['generated' => $selectedValues , 'legend' => $legend ];

	}

}
