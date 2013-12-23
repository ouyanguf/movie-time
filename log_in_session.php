#!/usr/local/bin/php

<?php
session_start();
$id = $_GET["userid"];
$_SESSION['curuserid'] = $id;

if ($id == 1) {
    header("Location:admin.php");
} else if (!empty($_SESSION['prev'])) {
    header("Location:" . $_SESSION['prev']);
} else {
    header("Location: index.php");
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Log In Session!</title>
    </head>
    <body>
    </body>
</html>
