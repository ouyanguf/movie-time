#!/usr/local/bin/php

<?php
session_start();
session_destroy();
header("location:index.php");
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Log Out Session!</title>
    </head>
    <body>
    </body>
</html>