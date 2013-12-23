#!/usr/local/bin/php

<?php
require_once('calendar/tc_calendar.php');

header ( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); 
header ("Pragma: no-cache");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TriConsole : PHP Calendar Date Picker</title>
<script language="javascript" src="calendar/calendar.js"></script>
<link href="calendar/calendar.css" rel="stylesheet" type="text/css">
</head>

<body>
<form id="form1" name="form1" method="post" action="test_calendar_value.php">
<table border="0" cellspacing="0" cellpadding="2">
<tr>
<td>Date :</td>
<td><?php					
      $date3_default = "2013-04-15";
      $date4_default = "2013-04-21";

	  $myCalendar = new tc_calendar("date3", true, false);
	  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
	  $myCalendar->setDate(date('d', strtotime($date3_default))
            , date('m', strtotime($date3_default))
            , date('Y', strtotime($date3_default)));
	  $myCalendar->setPath("calendar/");
	  $myCalendar->setYearInterval(1970, 2020);
	  $myCalendar->setAlignment('left', 'bottom');
	  $myCalendar->setDatePair('date3', 'date4', $date4_default);
	  $myCalendar->writeScript();	  
	  
	  $myCalendar2 = new tc_calendar("date4", true, false);
	  $myCalendar2->setIcon("calendar/images/iconCalendar.gif");
	  $myCalendar2->setDate(date('d', strtotime($date4_default))
           , date('m', strtotime($date4_default))
           , date('Y', strtotime($date4_default)));
	  $myCalendar2->setPath("calendar/");
	  $myCalendar2->setYearInterval(1970, 2020);
	  $myCalendar2->setAlignment('left', 'bottom');
	  $myCalendar2->setDatePair('date3', 'date4', $date3_default);
	  $myCalendar2->writeScript();

	  ?></td>
<td><input type="button" name="button" id="button" value="Check the value" onclick="javascript:alert(this.form.date4.value);" /></td>
</tr>
</table>
<p>

<input type="submit" name="Submit" value="Submit" />
</p>
</form>
</body>
</html>