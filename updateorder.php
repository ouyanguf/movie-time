#!/usr/local/bin/php


<?php
session_start();

$curuid = $_SESSION['curuserid'];
$movieidarray = array();

putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");
$conn = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');

$q_get = "select USER_ID,MOVIE_ID,AMOUNT,SUBTOTAL
          from CART
          where USER_ID = $curuid";

$st_get = oci_parse($conn, $q_get);
oci_execute($st_get);


while (oci_fetch_object($st_get)) {

    $uid = oci_result($st_get, 'USER_ID');
    $mid = oci_result($st_get, 'MOVIE_ID');
    $amount = oci_result($st_get, 'AMOUNT');
    $sub = oci_result($st_get, 'SUBTOTAL');
	
	array_push($movieidarray, $mid);
	
	$_SESSION['idarray'] = $movieidarray;

    $q_insert = " insert into MORDER 
		              values ($uid,$mid,$amount,$sub,current_timestamp) ";

    $st_insert = oci_parse($conn, $q_insert);
    oci_execute($st_insert);
    oci_free_statement($st_insert);

    $q_inv = "update movie
        set inventory=inventory-$amount 
        where movie_id = $mid";
    $st_inv = oci_parse($conn, $q_inv);
    oci_execute($st_inv);
    oci_free_statement($st_inv);

    $q_delete = " delete from CART
                        where USER_ID = $curuid ";

    $st_delete = oci_parse($conn, $q_delete);
    oci_execute($st_delete);
    oci_free_statement($st_delete);
}

print_r($_SESSION['idarray']);
header("location:Thankyou.php"); ?>