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

	function __construct($info , $totalTillToday, $period , $dates , $weeks )
	{

		$this->generation = $info;
		$data = $this->configureTotal($totalTillToday);
		$this->difference = $data['difference'];
		$this->totalGen = $data['total'];
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

		$UTC = new DateTimeZone("UTC");
		$now = new DateTime('today', $UTC );
		$nowUTC = $now->format("U");

		$legend = [];
    $formattedDates = [];


    foreach ($this->datePeriod as $key => $dates) {
			$legend[] = $dates->format('d-M');
      $formattedDates[] =  (int) $dates->format("U");
    }

    $selectedValues = [];
    foreach ($this->generation->readings as $value) {

			if($value->timestamp == $nowUTC )
			{
				$selectedValues[] = round($this->difference,2);
			} else if(in_array($value->timestamp, $formattedDates))
    	{
    		$selectedValues[] = round($value->value, 2);
    	}
    }

	    return ['chart'=>['generated' => $selectedValues , 'legend' => $legend], 'lifetime' => $this->totalGen ];

	}

	/**
	 * [configureTotal description]
	 * @return [type] [description]
	 */
	public function configureTotal($array)
	{
		$firstEl =  array_values(array_slice($array, 0))[0];
		$lastEl = array_values(array_slice($array, -1))[0];
		$difference = $lastEl->value - $firstEl->value;

		return ['difference' => $difference , 'total' => $lastEl->value ];

	}

}
