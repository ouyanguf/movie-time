#!/usr/local/bin/php


<?php
session_start();
if (!session_is_registered(curuserid)) {
    header("location:login.php");
}

$id1 = $_POST["fromid"];
$id2 = $_POST["toid"];

putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");

$connection = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');

if (!$connection) {
    echo "No Connection to Datebase!!</br>";
}

$q_addfriend1 = "insert into ADD_FRIEND values('$id1', '$id2')";
$st1 = oci_parse($connection, $q_addfriend1);
oci_execute($st1);

$q_addfriend2 = "insert into ADD_FRIEND values('$id2', '$id1')";
$st2 = oci_parse($connection, $q_addfriend2);
oci_execute($st2);

header("location:frienddisplay.php?USER_ID=$id2");
?>