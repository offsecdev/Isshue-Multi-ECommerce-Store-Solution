<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Occational {
	function dateConvert($date){

		list($month,$day,$year) = explode('-',$date);
		$day = $day+1;
		$day = $day-1;
		switch ($month)
		{
			case "01":
				$month = 'JAN';
				break;
			case "02":
				$month = 'FEB';
				break;
			case "03":
				$month = 'MAR';
				break;
			case "04":
				$month = 'APR';
				break;
			case "05":
				$month = 'MAY';
				break;
			case "06":
				$month = 'JUN';
				break;
			case "07":
				$month = 'JUL';
				break;
			case "08":
				$month = 'AUG';
				break;
			case "09":
				$month = 'SEP';
				break;
			case "10":
				$month = 'OCT';
				break;
			case "11":
				$month = 'NOV';
				break;
			case "12":
				$month = 'DEC';
				break;
		}
		$final_date = $day.' - '.$month.' - '.$year;
		return $final_date;
	}
}