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


	function __construct($weeks)
	{
		$this->noWeeks = $weeks;
	}

	public function returnDates()
	{
		$this->getUnixFrom();
		$this->getUnixTo();
		$this->setDisplayDate();
		return ['unixFrom' => $this->unixFrom , 'unixTo' => $this->unixTo , 'dateFrom' => $this->fromDate->format('d.m.y'), 'dateTo' => $this->displayDate->format('d.m.y') , 'displayTo' => $this->displayTo->format('d.m.y') ] ;
	}

	public function getUnixFrom()
	{
		$UTC = new DateTimeZone("UTC");
        $from_date = new DateTime('last sunday', $UTC ); 
        $from_date->modify('-'.$this->noWeeks.' weeks');
        $from_date->setTime(00, 00);
        $this->fromDate = $from_date;
        $this->unixFrom = $from_date->format("U");
	}

	public function getUnixTo()
	{
		$UTC = new DateTimeZone("UTC");	
		$to_date = new DateTime('last sunday' , $UTC ); 
        $to_date->setTime(00, 00);
        $this->toDate = $to_date->modify('+1 day'); 
        $this->displayTo = $to_date;
        $this->unixTo = $to_date->format("U");
	}

	public function setDisplayDate()
	{
		$UTC = new DateTimeZone("UTC");	
		$display_date = new DateTime('Today' , $UTC ); 
		$this->displayDate = $display_date->modify('-1 day');	
	}

	public function setDatePeriod()
	{
        return new DatePeriod( $this->fromDate , new DateInterval( "P1D" ), $this->toDate);
	}

	

}