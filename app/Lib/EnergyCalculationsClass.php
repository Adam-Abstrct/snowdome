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
	
	function __construct($info , $period , $dates )
	{
		$this->results = $info->data->records;
		$this->datePeriod = $period;
		$this->dates = $dates;

	}


	/**
	 * Returns all calculations that will later be returned via ajax
	 * @return Array Json Encoded array for javascript
	 */
	public function returnAllCalculations()
	{

		$this->returnGeneration();

		$chart = $this->calculateChartInfo();
		$c02 = $this->calculateC02Saved();
		$trees = $this->calculateTreesPlanted();
		$houses = $this->calculateHousesPowered();
		$green = $this->calculateGreenEnergy();

		return json_encode(['chart' => $chart , 'C02' => $c02 , 'trees' => $trees , 'houses' => $houses , 'green' => $green , 'df' => $this->dates['dateFrom'] , 'dt' => $this->dates['dateTo'] ]);

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

			if($value->name == 'Consumption (kWh)')
			{
				$this->consumption = $value;
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
		return $saved = round($C02 * 0.542 / 1000 , 3) ;
	}

	/**
	 * Calculates Trees Planted
	 *
	 * Formula = total x 0.542 / 22.5
	 *
	 * 
	 * @return [type] [description]
	 */
	public function calculateTreesPlanted()
	{
		$total = $this->generation->total * 0.542;
		$trees = round($total / 22.5) ;

		return $trees;

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
		$total = $this->generation->total;
		$calculate = 2500/12;
		$houses = $total / $calculate;

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

        foreach ($this->datePeriod as $dates) {
            $legend[] = $dates->format('M-d');
            $formattedDates[] = $dates->format("U");
        }   

        $selectedDates = [];
        foreach ($this->generation->readings as $value) {
        	if(in_array($value->timestamp, $formattedDates))
        	{
        		$selectedValues[] = round($value->value, 2);
        	}	
        }

        $selectedDates = [];
        foreach ($this->consumption->readings as $value) {
        	if(in_array($value->timestamp, $formattedDates))
        	{
        		if($value->value !== null) {
        			$consumptionValues[] = round($value->value,2);
        		} else {
        			$consumptionValues[] = 0;
        		}	
        	}	
        }

   
        return ['generated' => $selectedValues , 'consumption' => $consumptionValues , 'legend' => $legend ];

	}

	/**
	 * [calculateGreenEnergy description]
	 * @return [type] [description]
	 */
	public function calculateGreenEnergy() 
	{
		$total = $this->generation->total;

		return round($total / 1000 , 2);

	}

}