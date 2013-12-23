#!/usr/local/bin/php

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php

	$fromDate = isset($_REQUEST["date3"]) ? $_REQUEST["date3"] : "";
	$toDate = isset($_REQUEST["date4"]) ? $_REQUEST["date4"] : "";

	$fromDates = explode("-", $fromDate);
	$toDates = explode("-", $toDate);

	$fromYear = $fromDates[0];
	$fromMonth = $fromDates[1];
	$fromDay = $fromDates[2];

	$toYear = $toDates[0];
	$toMonth = $toDates[1];
	$toDay = $toDates[2];



	if($fromMonth == '01'){
		$fromMonthName = 'JAN';
	}if($fromMonth == '02'){
		$fromMonthName = 'FEB';
	}if($fromMonth == '03'){
		$fromMonthName = 'MAR';
	}if($fromMonth == '04'){
		$fromMonthName = 'APR';
	}if($fromMonth == '05'){
		$fromMonthName = 'MAY';
	}if($fromMonth == '06'){
		$fromMonthName = 'JUN';
	}if($fromMonth == '07'){
		$fromMonthName = 'JLY';
	}if($fromMonth == '08'){
		$fromMonthName = 'AUG';
	}if($fromMonth == '09'){
		$fromMonthName = 'SEP';
	}if($fromMonth == '10'){
		$fromMonthName = 'OCT';
	}if($fromMonth == '11'){
		$fromMonthName = 'NOV';
	}if($fromMonth == '12'){
		$fromMonthName = 'DEC';
	}

	if($toMonth == '01'){
		$toMonthName = 'JAN';
	}if($toMonth == '02'){
		$toMonthName = 'FEB';
	}if($toMonth == '03'){
		$toMonthName = 'MAR';
	}if($toMonth == '04'){
		$toMonthName = 'APR';
	}if($toMonth == '05'){
		$toMonthName = 'MAY';
	}if($toMonth == '06'){
		$toMonthName = 'JUN';
	}if($toMonth == '07'){
		$toMonthName = 'JLY';
	}if($toMonth == '08'){
		$toMonthName = 'AUG';
	}if($toMonth == '09'){
		$toMonthName = 'SEP';
	}if($toMonth == '10'){
		$toMonthName = 'OCT';
	}if($toMonth == '11'){
		$toMonthName = 'NOV';
	}if($toMonth == '12'){
		$toMonthName = 'DEC';
	}


	$fromDateName = $fromDay."-".$fromMonthName."-".$fromYear;
	$toDateName = $toDay."-".$toMonthName."-".$toYear;


	echo $fromDateName;
	
	echo "<br/>";

	echo $toDateName; 

?>
</body>
</html>