<?php 

namespace App\Lib;

/**
* 
*/
class SnowdomeAPI {
	

	public $apiResponse;
	public $url;
	public $dateFrom;
	public $dateTo;

	// function __construct(integer $df ,  integer $dt)
	// {
	// 	$this->dateFrom = $df;
	// 	$this->dateTo = $dt;

	// }
	// 
	public function __construct($dates)
	{
	
		$this->dateFrom = $dates['unixFrom'];
		$this->dateTo = $dates['unixTo'];
	}


	public function createAPIURl()
	{
		$url = 'http://ems-api.lightsource-re.co.uk/api/resources/readings/installation_id/7e0e0085-e34b-3bd1-fa92-56fb9192b898?start='.$this->dateFrom.'end='.$this->dateTo.'';	

	}

	public function sendAPICall()
	{
		//SEND CURL API
	}

	public function returnApiInfo()
	{
		$this->createAPiURL();
		$repsonse = $this->sendAPICall();

		return json_decode($response);
	}

	/**
	 * DEVELOPMENT FUNCTION NOT TO BE USED IN PRODUCTION
	 */
	public function loadTestJSON()
	{

		$json = file_get_contents('../../storage/snowdome-readings.json');

		return json_decode($json);

	}


}