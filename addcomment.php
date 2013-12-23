#!/usr/local/bin/php



<?php
session_start();
if (!session_is_registered(curuserid)) {
	$reg = 0;
    header("location:login.php");
}else{
	$reg = 1;
	}
	
	$id1 = $_POST["fromcomid"];
  	$id2 = $_POST["tocomid"];
	$commentcontent = $_POST["commenttext"];
  
  	putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");

       $connection = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');

      if (!$connection) {
        echo "No Connection to Datebase!!</br>";
      }
	  
	  $q_commentid = "select Max(COMMENT_ID) from MCOMMENT";
	  $statement_commentid = oci_parse($connection, $q_commentid);
	  oci_execute($statement_commentid);
	  $result1 = oci_fetch_array($statement_commentid, OCI_BOTH);
	  $insertid = $result1[0] + 1;
	 // oci_free_statement($statement_commentid);
	  
	  //echo "$id1, $id2, $insertid, $commentcontent";
	  
	  $q_addcomment = "insert into mcomment values('$id1', '$id2', '$insertid', current_timestamp, '$commentcontent')";
	  
	  $statement2 = oci_parse($connection, $q_addcomment);
	  oci_execute($statement2);
	  
	  
	  $q_test = "select * from mcomment where comment_id='$insertid'";
	  $statement_test = oci_parse($connection, $q_test);
	  oci_execute($statement_test);
	  $result_test = oci_fetch_array($statement_test, OCI_BOTH);
	  
	  echo "from: $result_test[0]";
	  echo "to: $result_test[1]";
	  echo "commentid: $result_test[2]";
	  echo "time: $result_test[3]";
	  echo "comment: $result_test[4]";

	  header("location:frienddisplay.php?USER_ID=$id2");
	 
	 

?>