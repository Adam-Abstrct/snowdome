<?php 

namespace App\Lib;

use DateTime;
use DateTimeZone;
use DatePeriod;
use DateInterval;

/**
* 
*/
class CustomDateTime
{
	
	public $unixFrom;
	public $unixTo;
	public $toDate;
	public $fromDate;
	public $now;


	function __construct()
	{
		# code...
	}

	public function returnDates()
	{
		$this->getUnixFrom();
		$this->getUnixTo();
		return ['unixFrom' => $this->unixFrom , 'unixTo' => $this->unixTo , 'dateFrom' => $this->fromDate->format('d.m.y'), 'dateTo' => $this->toDate->format('d.m.y') ] ;
	}

	public function getUnixFrom()
	{
		$UTC = new DateTimeZone("UTC");
        $from_date = new DateTime('09/05/2016', $UTC ); 
        $from_date->setTime(12, 00);
        $this->fromDate = $from_date;
        $this->unixFrom = $from_date->format("U");
	}

	public function getUnixTo()
	{
		$UTC = new DateTimeZone("UTC");	
		$to_date = new DateTime('09/12/2016' , $UTC ); 
        $to_date->setTime(12, 00);
        $this->toDate = $to_date;
        $this->unixTo = $to_date->format("U");
	}

	public function setDatePeriod()
	{
	
        return new DatePeriod( $this->fromDate , new DateInterval( "P1D" ), $this->toDate);
	}

	

}