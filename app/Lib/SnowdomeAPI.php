<?php

namespace App\Lib;
use DateTime;
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

	// function __construct(integer $df ,  integer $dt)
	// {
	// 	$this->dateFrom = $df;
	// 	$this->dateTo = $dt;

	// }
	//
	public function __construct($dates)
	{
		ini_set('error_reporting', E_ALL);


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

	public function createAPIURL($token)
	{
		$url = 'http://ems-api.lightsource-re.co.uk/api/resources/readings/installation_id/7e0e0085-e34b-3bd1-fa92-56fb9192b898?start='.$this->dateFrom.'&end='.$this->dateTo.'&interval=86400';

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
		// $unzipped = gzdecode($output);
		// var_dump($unzipped);
		$decoded = json_decode($output);



		if($decoded->http_status != 200) {
			throw new Exception("Could not connect to external API");
		} else {
			return $decoded->data->records[4]; // Generation (kWh)
		}

	}

	public function getLifetimeGeneration($token)
	{
		$url = 'http://ems-api.lightsource-re.co.uk/api/resources/readings/installation_id/7e0e0085-e34b-3bd1-fa92-56fb9192b898?start=1420070400&interval=86400';

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
		// $unzipped = gzdecode($output);
		$decoded = json_decode($output);
		// var_dump("<pre>");
		// var_dump($decoded->data->records[2]);
		// var_dump("</pre>");
		// die;

		if($decoded->http_status != 200) {
			throw new Exception("Could not connect to external API");
		} else {
			return $decoded->data->records[2]->total + 53457.47; // Generation (kWh)
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


	public function createFTPAccess()
	{
		$conn_id = ftp_connect("ftp.lightsource-re.co.uk") or die("Could not connect to $ftp_server");
		$login_result = ftp_login($conn_id, "asldashboard", "ieC5phieeebei2Ni");
		ftp_pasv($conn_id, true);
		$contents = ftp_nlist($conn_id, ".");
		return ['contents' => $contents , 'conn_id' => $conn_id ];
	}

	public function configureFTPPattern()
	{
		$now = date('YmdH');
		// We only get the first part of the minute variable as the
		// regex picks up the rest below!
		$minute_start = (date('i') >= 30 ? "3" : "0" );
		return "/^[0-9a-zA-Z\-\_]+{$now}{$minute_start}[0-9]{3}\.csv/";
	}


	public function returnFTPData()
	{

		$contents = $this->createFTPAccess();
		$pattern = $this->configureFTPPattern();


		$results = preg_grep($pattern, $contents['contents']);


		if ($results) {
		  $filenames = array_values($results);
		  $filename = $filenames[0];


		  ob_start();
		  $file = ftp_get($contents['conn_id'], "php://output", $filename, FTP_BINARY);
		  $file_contents = ob_get_contents();
		  ob_end_clean();

		  $install_id_pattern = "/^.*\b10067001\b.*$/m";
		  preg_match($install_id_pattern, $file_contents, $row_matches);


		  if ($row_matches && count($row_matches) == 1) {
		    $generation_data = explode(",", $row_matches[0]);
		    $total_generation_watts = $generation_data[3];
		    $total_generation = $total_generation_watts /1000;

				return $total_generation ;

		  }
		} else {

		}
	}


	public function returnApiInfo()
	{
		$this->createAPiURL();
		$repsonse = $this->sendAPICall();

		return json_decode($response);
	}

}
