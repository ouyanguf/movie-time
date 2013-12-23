#!/usr/local/bin/php

<?php
session_start();
$curuid = $_SESSION['curuserid'];

putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");
$conn = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');
?>

<!DOCTYPE HTML>

<html>
    <head>
        <title>cart</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <noscript><link rel="stylesheet" href="css/5grid/core.css" /><link rel="stylesheet" href="css/5grid/core-desktop.css" /><link rel="stylesheet" href="css/5grid/core-1200px.css" /><link rel="stylesheet" href="css/5grid/core-noscript.css" /><link rel="stylesheet" href="css/style.css" /><link rel="stylesheet" href="css/style-desktop.css" /></noscript>
        <script src="css/5grid/jquery.js"></script>
        <script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none&amp;mobileUI.titleBarHeight=55&amp;mobileUI.openerWidth=75&amp;mobileUI.openerText=&lt;"></script>
        <!--[if lte IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->
    </head>
    <body class="subpage">

        <!-- Header -->
        <div id="header-wrapper">
            <header id="header" class="5grid-layout">
                <div class="row">
                    <div class="12u">

                        <!-- Logo -->
                        <h1><a href="#" class="mobileUI-site-name">MovieTime</a></h1>

                        <!-- Nav -->
                        <nav class="mobileUI-site-nav">
                            <a href="index.php">Homepage</a>
                            <a href="ranking.php">TOPS</a>
                            <a href="find_friend.php">Movie Friend</a>
                            <a href="cart.php">My Cart</a>
                            <a href="UserProfile.php">My Time</a>
                        </nav>

                    </div>
                </div>
            </header>
        </div>

        <!-- Content -->
        <div id="content-wrapper">
            <div id="content">
                <div class="5grid-layout">
                    <div class="row">
                        <div class="9u">

                            <!-- Main Content -->
                            <section>
                                <section>
                                    <header>
                                        <h2>Shopping Cart</h2>
                                        <h3>You can still modify your cart before checking out.</br>Just enter the new amount and click UPDATE!  
                                        </h3>
                                    </header>
                                    <table width="768" height="48" border="1">
                                        <tr>
                                            <th width="50" ALIGN="LEFT"><h1><strong>No.</strong></h1></th>
                                        <th width="469" ALIGN="LEFT"><h1><strong>Items In the Cart</strong></h1></th>
                                        <th width="75" ALIGN="LEFT"><h1><strong>Price</strong></h1></th>
                                        <th width="50" ALIGN="LEFT"><h1><strong>Amount</strong></h1></th>
                                        </tr>


                                        <tr> 
                                        <form action="/~you/update.php" method="POST">
                                            <?php
                                            $q_get = "select M.TITLE,M.PRICE,M.MOVIE_ID,C.AMOUNT
                                                from CART C,MOVIE M
                                                where C.USER_ID = $curuid and
                                                M.MOVIE_ID=C.MOVIE_ID";
                                            $st_get = oci_parse($conn, $q_get);
                                            oci_execute($st_get);
                                            $i_get = 1;
                                            while (oci_fetch_object($st_get)) {

                                                $t = oci_result($st_get, 'TITLE');
                                                $p = oci_result($st_get, 'PRICE');
                                                $a = oci_result($st_get, 'AMOUNT');
                                                $send = oci_result($st_get, 'MOVIE_ID');
                                                echo "
                                                <tr>
                                                    <td><h1><strong>$i_get</strong></h1></td>
                                                    <td><h1><strong><a href=/~you/display.php?MOVIE_ID=$send>$t</a></strong></h1></td>
                                                    <td><h1><strong>$p</strong></h1></td>
                                                    <td><h1><strong>
                                                            <input name = $i_get type = 'text'  value = $a size='6'/>
                                                                </strong></h1></td>
                                                </tr>";
                                                $i_get++;
                                            }
                                            oci_free_statement($st_get);
                                            ?>
                                            </tr>
                                            <tr> 
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><input type = "submit" value = "UPDATE" style = "border-width:3px" size="15"></td>

                                            </tr>
                                        </form>	


                                    </table>  
                                    <p>
                                    </p>  

                                </section>
                                <section>
                                    <header>
                                        <h3><strong>Customers Who Bought Items in Your Cart Also Bought</strong></h3>
                                    </header>
                                    <ul class="link-list">
                                        <li><a href="#">item x</a></li>
                                        <li><a href = "#">item y</a></li>
                                    </ul>
                                </section>
                                <p>&nbsp;
                                </p>
                            </section>

                        </div>
                        <div class = "3u">

                            <!--Sidebar-->
                            <section>
                                <section>
                                    <header>
                                        <h2>Subtotal</h2>
                                    </header>
                                    <ul class = "link-list">
                                        <li class = "last-child">


                                            <?php
                                            $q2 = "select SUM(C.AMOUNT * M.PRICE) as SUB
                                                    from CART C,MOVIE M 
                                                    where C.USER_ID = $curuid and
                                                    M.MOVIE_ID=C.MOVIE_ID ";

                                            $st2 = oci_parse($conn, $q2);
                                            oci_execute($st2);
                                            oci_fetch($st2);
                                            $y = oci_result($st2, 'SUB');

                                            echo " <h2><em><strong>$ $y</strong><strong></strong></em></h2> ";
                                            oci_free_statement($st2);
                                            ?>									

                                        </li>
                                        <li>

                                            <input type="button" value="PROCESS TO CHECK OUT" style="border-width:3px">

                                        </li>
                                    </ul>
                                </section>
                            </section>
                            <!-- Links -->

                        </div>
                    </div>
                </div>

                <div style="display:none"><script src='http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language='JavaScript' charset='gb2312'></script></div>
                <div id="footer-wrapper">
                    <footer id="footer" class="5grid-layout">
                        <div class="row">
                            <div class="8u">
                                <!-- Links -->
                                <section>
                                    <h2>Important Links</h2>
                                    <div class="5grid">
                                        <div class="row">
                                            <div class="3u">
                                                <ul class="link-list last-child">
                                                    <li><a href="#">About Movie Time</a></li>
                                                    <li><a href="#">Help</a></li>
                                                    <li><a href="#">MSN Movie</a></li>
                                                </ul>
                                            </div>
                                            <div class="3u">
                                                <ul class="link-list last-child">
                                                    <li><a href="#">Site Map</a></li>
                                                    <li><a href="#">Yahoo Movie</a></li>
                                                    <li><a href="#">Disney Movie</a></li>
                                                </ul>
                                            </div>
                                            <div class="3u">
                                                <ul class="link-list last-child">
                                                    <li><a href="#">Contact Us</a></li>
                                                    <li><a href="#">IMDB</a></li>
                                                    <li><a href="#">Google Movie</a></li>
                                                </ul>
                                            </div>
                                            <div class="3u">
                                                <ul class="link-list last-child">
                                                    <li><a href="#">Tell us what you think</a></li>
                                                    <li><a href="#">Movies.com</a></li>
                                                    <li><a href="#">Douban.com</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="4u">
                                <!-- Blurb -->
                                <section>
                                    <h2>Information Box</h2>
                                    <p> need php </p>
                                </section>
                            </div>
                        </div>
                    </footer>
                </div>
                <div id="copyright">
                    <div id="copyright2"><a href="http://sc.chinaz.com/">University of Florida/CISE </a></div>
                    <a href="http://sc.chinaz.com/"></a> </div>
                <p>&nbsp;</p>
                </body>
                </html>