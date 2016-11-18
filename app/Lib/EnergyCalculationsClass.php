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
	public $results;
	public $generation;	
	public $consumption;
	public $datePeriod;
	public $noWeeks;
	
	function __construct($info , $period , $dates , $weeks )
	{
		$this->results = $info->data->records;
		$this->datePeriod = $period;
		$this->dates = $dates;
		$this->noWeeks = $weeks;

	}


	/**
	 * Returns all calculations that will later be returned via ajax
	 * @return Array Json Encoded array for javascript
	 */
	public function returnAllCalculations()
	{

		$this->returnGeneration();
		$this->calculateC02Saved();
		$cars = $this->calculatecars();
		$houses = $this->calculateHousesPowered();
		$green = $this->calculateGreenEnergy();
		$chart = $this->calculateChartInfo();

		return json_encode(['chart' => $chart , 'C02' => $this->co2Saved , 'cars' => $cars , 'houses' => $houses , 'green' => $green , 'df' => $this->dates['dateFrom'] , 'dt' => $this->dates['displayTo'] ]);

	}

	/**
	 * Returns Generation and Consumption to be used later
	 * @return [type] [description]
	 */
	public function returnGeneration()
	{
		foreach ($this->results as $value) {
			
			if($value->name == 'Generation (kWh)')
			{
				$this->generation = $value;
			}

		}

	}

	/**
	 * Calculates C02 
	 *
	 * Formula = generation(total) X -0.542 / 1000
	 * 
	 * @return [type] [description]
	 */
	public function calculateC02Saved()
	{
		$C02 = $this->generation->total;
		$this->co2Saved = round(($C02 * 0.517 / 1000) / ($this->noWeeks/52) , 0) ;
	}

	/**
	 * Calculates Trees Planted
	 *
	 * Formula = total x 0.542 / 22.5
	 *
	 * 
	 * @return [type] [description]
	 */
	public function calculateCars()
	{
		$cars = $this->co2Saved / 4.5;
		return number_format($cars, 0);

	}

	/**
	 * Calculates Houses Powered
	 *
	 * Formula = total / (2500/12)
	 * 
	 * @return [type] [description]
	 */
	public function calculateHousesPowered()
	{
		$houses = $this->co2Saved / 3.1;
		return round($houses);
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

	/**
	 * [calculateGreenEnergy description]
	 * @return [type] [description]
	 */
	public function calculateGreenEnergy() 
	{
		$total = $this->generation->total;
		$estimate = $total * (52/$this->noWeeks) / 1000;

		return round($estimate, 2);

	}

}