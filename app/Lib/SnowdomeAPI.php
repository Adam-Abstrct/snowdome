<?php

namespace App\Lib;
use DateTime;
use DateTimeZone;
use Exception;


date_default_timezone_set("Europe/London");
ini_set( 'date.timezone', 'Europe/London' );

/**
*
*/
class SnowdomeAPI {


	public $apiResponse;
	public $url;
	public $dateFrom;
	public $dateTo;
	public $auth_token;

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

		curl_setopt($ch, CURLOPT_URL , "https://ems-api.lightsource-re.co.uk/auth/token");
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

	public function createAPIURL($token)
	{
		$url = 'https://ems-api.lightsource-re.co.uk/api/resources/readings/installation_id/7e0e0085-e34b-3bd1-fa92-56fb9192b898?start='.$this->dateFrom.'&end='.$this->dateTo.'&interval=86400';

		$headers = [
			'Pragma: no-cache',
			'Origin: https://ems.lightsource-re.co.uk',
			'Accept-Encoding: gzip, deflate, sdch',
			'Accept-Language: en-US,en;q=0.8,ru;q=0.6',
			'Authorization: Bearer '.$token.'',
			'Accept: application/json, text/plain, */*',
			'Cache-Control: no-cache',
			'Connection: keep-alive',
			'Referer: https://ems.lightsource-re.co.uk/pulse/module/Portfolios/record/7d87e3b9-973e-abcf-7459-573b34b2b5c8/Overview'
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL , $url );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		// $unzipped = gzdecode($output);
		// var_dump($unzipped);

		$decoded = json_decode($output);

		if($decoded->http_status != 200) {
			throw new Exception("Could not connect to external API");
		} else {
			return $decoded->data->records[2]; // Generation (kWh)
		}

	}

	public function getDifference($token)
	{

		// need midnight last night utc
		// need now utc
		//

		$UTC = new DateTimeZone("UTC");
		$from  = new DateTime('Today' , $UTC );
		$end  = new DateTime('now' , $UTC );
		$url = 'https://ems-api.lightsource-re.co.uk/api/resources/reading_snapshots/measurement_id/3d06063b-81ed-704e-25f7-5718fcd7c3b8?start='.$from->format('U').'&end='.$end->format('U');

		// https://ems-api.lightsource-re.co.uk/api/resources/reading_snapshots/installation_id/7e0e0085-e34b-3bd1-fa92-56fb9192b898?start=1489795200&end=1489968000

		$headers = [
			'Pragma: no-cache',
			'Origin: https://ems.lightsource-re.co.uk',
			'Accept-Encoding: gzip, deflate, sdch',
			'Accept-Language: en-US,en;q=0.8,ru;q=0.6',
			'Authorization: Bearer '.$token,
			'Accept: application/json, text/plain, */*',
			'Cache-Control: no-cache',
			'Connection: keep-alive',
			'Referer: https://ems.lightsource-re.co.uk/pulse/module/Portfolios/record/7d87e3b9-973e-abcf-7459-573b34b2b5c8/Overview'
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL , $url );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		// $unzipped = gzdecode($output);
		$decoded = json_decode($output);

		if($decoded->http_status != 200) {
			throw new Exception("Could not connect to external API");
		} else {
			return $decoded->data->records[0]->readings; // Generation (kWh)
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
