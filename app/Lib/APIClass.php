<?php 

namespace App\Lib;
use DateTime;
use Exception;

/**
* 
*/
class SnowdomeAPI {
	

	public $apiResponse;
	public $url;
	public $dateFrom;
	public $dateTo;
	public $auth_token;

	// function __construct(integer $df ,  integer $dt)
	// {
	// 	$this->dateFrom = $df;
	// 	$this->dateTo = $dt;

	// }
	// 
	public function __construct($dates)
	{
		if(!isset($_SESSION) )
		{
			session_start();
		}


		$this->dateFrom = $dates['unixFrom'];
		$this->dateTo = $dates['unixTo'];
	}

	public function createAuthToken()
	{

		$ch = curl_init();

		$rt = $this->checkRememberStatus();

	
		if(isset($rt) && !empty($rt))
		{
			$data = [
				"grant_type" => "refresh_token",
				"refresh_token" => $rt
			];

		} else {
			$data = [
				"grant_type" => "password",
				"username" => "adam.johnson@impression.co.uk",
				"password" => "5nOwd0m3"
			];

		}

		$headers = [
			'Accept: application/json, text/plain, */*',
			'Content-Type: application/json'
		];

		curl_setopt($ch, CURLOPT_URL , "http://ems-api.lightsource-re.co.uk/auth/token");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, 3);
		curl_setopt($ch, CURLOPT_POSTFIELDS , json_encode($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($ch); 
		curl_close($ch);

 		$fields = json_decode($output);
 
 
		if(!isset($_SESSION['refresh_token']))
		{
			$now = new DateTime('NOW');
			$nutc = $now->format("U");

			$expireTime = new DateTime('tomorrow');
			$eutc = $expireTime->format("U");	

			$_SESSION['refresh_token'] = $fields->refresh_token;
 	 		$_SESSION['refresh_start'] = (int)  $nutc;
 		 	$_SESSION['refresh_expire'] = (int) $eutc;
		}
 
 		return $fields->access_token;


	}

	public function createAPIURl($token)
	{
		$url = 'http://ems-api.lightsource-re.co.uk/api/resources/readings/installation_id/7e0e0085-e34b-3bd1-fa92-56fb9192b898?start='.$this->dateFrom.'&end='.$this->dateTo.'&interval=86400';	


		//$url = 'http://ems-api.lightsource-re.co.uk/api/resources/readings/installation_id/7e0e0085-e34b-3bd1-fa92-56fb9192b898?start=1464220800&end=1475625600&interval=86400';	

		//86400

		$headers = [
			'Pragma: no-cache',
			'Origin: http://ems.lightsource-re.co.uk',
			'Accept-Encoding: gzip, deflate, sdch',
			'Accept-Language: en-US,en;q=0.8,ru;q=0.6',
			'Authorization: Bearer '.$token.'',
			'Accept: application/json, text/plain, */*',
			'Cache-Control: no-cache',
			'Connection: keep-alive',
			'Referer: http://ems.lightsource-re.co.uk/pulse/module/Portfolios/record/7d87e3b9-973e-abcf-7459-573b34b2b5c8/Overview'
		];


		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL , $url );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($ch); 
		curl_close($ch);
		$unzipped = gzdecode($output);
		$decoded = json_decode($unzipped);

		// print_r("<pre>");
		// var_dump($decoded);
		// print_r("</pre>");
		

		//  die;

	
		if($decoded->http_status != 200) {
			throw new Exception("Could not connect to external API");
		} else {
			return $decoded;
		}

	}


	public function checkRememberStatus()
	{

		$now = new DateTime('NOW');
		$nutc = $now->format("U");


		if(!isset($_SESSION['refresh_token']) && empty($_SESSION['refresh_token']))
		{
			return null;
		} 

		if(isset($_SESSION['refresh_token'])) {
			
			if((int)$nutc < (int)$_SESSION['refresh_expire'] )
			{
				return $_SESSION['refresh_token'];
			} else {
				$_SESSION = array();
				return null;
			}

		} 
	
	}


	public function returnApiInfo()
	{
		$this->createAPiURL();
		$repsonse = $this->sendAPICall();

		return json_decode($response);
	}

}