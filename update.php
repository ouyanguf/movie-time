#!/usr/local/bin/php

<?php
session_start();
$curuid = $_SESSION['curuserid'];

putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");
$conn = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');

$q_get = "select M.MOVIE_ID,C.AMOUNT
          from CART C,MOVIE M
          where C.USER_ID = $curuid and
          M.MOVIE_ID=C.MOVIE_ID";
$st_get = oci_parse($conn, $q_get);
oci_execute($st_get);

$i_get = 1;
while (oci_fetch_object($st_get)) {
    $id = oci_result($st_get, 'MOVIE_ID');
    $new = $_POST["$i_get"];

    if ($new) {
        $q_update = "update CART
            set AMOUNT = $new
            where USER_ID = $curuid and
            MOVIE_ID= $id";
        $st_update = oci_parse($conn, $q_update);
        oci_execute($st_update);
        oci_free_statement($st_update);
    } else {
        $q_delete = "delete from cart
            where USER_ID = $curuid and
            MOVIE_ID= $id";
        $st_delete = oci_parse($conn, $q_delete);
        oci_execute($st_delete);
        oci_free_statement($st_delete);
    }
    $i_get++;
}
oci_free_statement($st_get);

header("location:cart.php");
?>

<html>
    <body></body>
</html>