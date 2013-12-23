#!/usr/local/bin/php

<?php
session_start();
if (!session_is_registered(curuserid)) {
    $reg = 0;
} else {
    $reg = 1;
}
putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");
$conn = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');
?>

<!DOCTYPE HTML>


<html>
    <head>
        <title>Ranking</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <noscript><link rel="stylesheet" href="css/5grid/core.css" /><link rel="stylesheet" href="css/5grid/core-desktop.css" /><link rel="stylesheet" href="css/5grid/core-1200px.css" /><link rel="stylesheet" href="css/5grid/core-noscript.css" /><link rel="stylesheet" href="css/style.css" /><link rel="stylesheet" href="css/style-desktop.css" /></noscript>
        <script src="css/5grid/jquery.js"></script>
        <script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none&amp;mobileUI.titleBarHeight=55&amp;mobileUI.openerWidth=75&amp;mobileUI.openerText=&lt;"></script>
        <!--[if lte IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->
    </head>
    <body>

        <!-- Header -->
        <div id="header-wrapper">
            <header id="header" class="5grid-layout">
                <div class="row">
                    <div class="12u">

                        <!-- Logo -->
                        <h1><a href="/~you/index.php" class="mobileUI-site-name"><strong>MovieTime</strong></a></h1>

                        <nav class="mobileUI-site-nav" style="position:absolute; top: 0px; right: 0px; font-size: 15px;">
                            <?php
                            if ($reg) {
                                echo "<a href=UserProfile.php>Hi, There! | <a href=http://www.cise.ufl.edu/~you/log_out_session.php>LogOut</a>";
                            } else {
                                echo "<a href=http://www.cise.ufl.edu/~you/login.php>LogIn</a>";
                                echo "|<a href=http://www.cise.ufl.edu/~you/register.php>Register</a>";
                            }
                            ?>
                        </nav>

                        <!-- Nav -->
                        <nav class="mobileUI-site-nav">
                            <a href="index.php">Homepage</a>
                            <a href="ranking.php">TOPS</a>
                            <a href="friendlist.php">Movie Friend</a>
                            <a href="cart.php">My Cart</a>
                            <a href="UserProfile.php">My Time</a>
                        </nav>

                    </div>
                </div>
            </header>
            <div id="banner" style="margin: 2px; padding: 2px;">
                <div class="5grid-layout">
                    <div class="row">
                        <div class="12u">

                            <!-- Banner Copy -->
                            <form style="text-align:right;" action="http://www.cise.ufl.edu/~you/search_result.php" method="post">
                                <input style="height: 25px; vertical-align:middle;" type="text" name="s_content" size="50" value="" />&nbsp;&nbsp;&nbsp;&nbsp;
                                <select style="vertical-align:middle;font-size:23px;" name="domain">
                                    <option value="title">Movie Title</option>
                                    <option value="r_year">Release Year&nbsp;&nbsp;&nbsp;</option>
                                    <option value="company">Company</option>
                                    <option value="genre">Genre</option>
                                    <option value="director">Director</option>
                                    <option value="actor">Actor</option>
                                </select> &nbsp;&nbsp;&nbsp;
                                <input  style="padding: 1px 20px; font-size: 1em; vertical-align:middle;" class="button-big" type="submit" name="submit" value="Search" />
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>



        <!-- Content -->
        <div id="content-wrapper">
            <div id="content">
                <div class="5grid-layout">
                    <div class="row">
                        <div class="4u">

                            <!-- Rank by user rating score -->
                            <section>
                                <header>
                                    <h2>Rank by user rating score:</h2>										
                                </header>
                                <?php
                                //Rank by score

                                $q1 = "select m.movie_id, m.title, AVG(r.score) as avs
               from movie m, rate r
               where m.movie_id=r.movie_id
               group by m.title, m.movie_id
               order by avs desc";
                                $st1 = oci_parse($conn, $q1);
                                oci_execute($st1);
                                echo "<table border=1>
                        <tr>
                        <th width=35 align=center>Rank</th>
                        <th align=center>MOVIE TITLE</th>
                        <th align=right>Score</th>
                        </tr>
                        ";
                                $i = 1;
                                while (oci_fetch_object($st1) and $i <= 15) {
                                    $t = oci_result($st1, 'TITLE');
                                    $a = number_format(oci_result($st1, 'AVS'), 1);
                                    $send = oci_result($st1, 'MOVIE_ID');
                                    echo "<tr>
                        <td align=center>$i</td>
                        <td><a href=/~you/display.php?MOVIE_ID=$send>$t</a></td>
                        <td align=right>$a</td>
                        </tr>";
                                    $i++;
                                }
                                echo "</table>";
                                oci_free_statement($st1);
                                ?>
                            </section>

                        </div>
                        <div class="4u">

                            <!-- Rank by Boxing: -->
                            <section>
                                <header>
                                    <h2>Rank by Box Office:</h2>											
                                </header>
                                <?php
//Rank by Boxing
                                $box = "select m.movie_id, m.title, box/1000000 as b
               from movie m
               order by box desc";
                                $s_box = oci_parse($conn, $box);
                                oci_execute($s_box);
                                echo "<table border=1>
                        <tr>
                        <th width=35 align=center>Rank</th>
                        <th align=center>MOVIE TITLE</th>
                        <th align=right>Box</th>
                        </tr>
                        ";
                                $ib = 1;
                                while (oci_fetch_object($s_box) and $ib <= 10) {
                                    $t = oci_result($s_box, 'TITLE');
                                    $b = number_format(oci_result($s_box, 'B'), 1, '.', ',');
                                    $send = oci_result($s_box, 'MOVIE_ID');
                                    echo "<tr>
                        <td align=center>$ib</td>
                        <td><a href=/~you/display.php?MOVIE_ID=$send>$t</a></td>
                        <td align=right>$b/M</td>
                        </tr>";
                                    $ib++;
                                }
                                echo "</table>";
                                oci_free_statement($s_box);
                                ?>

                            </section>

                        </div>
                        <div class="4u">

                            <!-- Rank by sales: -->
                            <section>
                                <header>
                                    <h2>Rank by sales:</h2>											
                                </header>
                                <?php
//Rank by Movie Sale Income
                                $sql_income = "select m.movie_id, m.title, sum(o.subtotal) as total_in
               from movie m, morder o
               where m.movie_id=o.movie_id
               group by m.movie_id, m.title
               order by total_in desc";
                                $st_income = oci_parse($conn, $sql_income);
                                oci_execute($st_income);
                                echo "<table border=1>
                        <tr>
                        <th width=35 align=center>Rank</th>
                        <th align=center>MOVIE TITLE</th>
                        <th align=right>Total</th>
                        </tr>
                        ";
                                $i_income = 1;
                                while (oci_fetch_object($st_income) and $i_income <= 15) {
                                    $t = oci_result($st_income, 'TITLE');
                                    $in = number_format(oci_result($st_income, 'TOTAL_IN'), 1, '.', ',');

                                    $send = oci_result($st_income, 'MOVIE_ID');
                                    echo "<tr>
                        <td align=center>$i_income</td>
                        <td><a href=/~you/display.php?MOVIE_ID=$send>$t</a></td>
                        <td align=right>$in</td>
                        </tr>";
                                    $i_income++;
                                }
                                echo "</table>";
                                oci_free_statement($st_income);
                                ?>

                            </section>

                        </div>
                    </div>
                </div>
            </div>
        </div>






        <!-- Another big DIV -->


        <div id="content-wrapper">
            <div id="content">
                <div class="5grid-layout">
                    <div class="row">
                        <div class="6u">
                            <!-- Rank by sales AMOUNT: -->
                            <section>
                                <header>
                                    <h2>Rank by sales AMOUNT:</h2>											
                                </header>

                                <?php
//Rank by Movie Sale Amount

                                $sql_amount = "select m.movie_id, m.title, sum(o.amount) as total_amount
               from movie m, morder o
               where m.movie_id=o.movie_id
               group by m.movie_id, m.title
               order by total_amount desc";
                                $st_amount = oci_parse($conn, $sql_amount);
                                oci_execute($st_amount);
                                echo "<table border=1>
                        <tr>
                        <th width=35 align=center>Rank</th>
                        <th align=center>MOVIE TITLE</th>
                        <th align=right>Total Sale</th>
                        </tr>
                        ";
                                $i_amount = 1;
                                while (oci_fetch_object($st_amount) and $i_amount <= 15) {
                                    $t = oci_result($st_amount, 'TITLE');
                                    $a = oci_result($st_amount, 'TOTAL_AMOUNT');
                                    $send = oci_result($st_amount, 'MOVIE_ID');
                                    echo "<tr>
                        <td align=center>$i_amount</td>
                        <td><a href=/~you/display.php?MOVIE_ID=$send>$t</a></td>
                        <td align=right>$a</td>
                        </tr>";
                                    $i_amount++;
                                }
                                echo "</table>";
                                oci_free_statement($st_amount);
                                ?>
                            </section>

                        </div>
                        <div class="6u">

                            <!-- Rank by Year -->
                            <section>
                                <header>
                                    <h2>Rank by Year:</h2>										
                                </header>
                                <?php
//Rank by release year

                                $ryear = "select m.movie_id, m.title, m.r_year
               from movie m
               where m.r_year<2020
               order by r_year desc";
                                $s_r = oci_parse($conn, $ryear);
                                oci_execute($s_r);
                                echo "<table border=1>
                        <tr>
                        <th align=center width=35>Rank</th>
                        <th align=center>MOVIE TITLE</th>
                        <th align=right>Year</th>
                        </tr>
                        ";
                                $ir = 1;
                                while (oci_fetch_object($s_r) and $ir <= 10) {
                                    $t = oci_result($s_r, 'TITLE');
                                    $y = oci_result($s_r, 'R_YEAR');
                                    $send = oci_result($s_r, 'MOVIE_ID');
                                    echo "<tr>
                        <td align=center>$ir</td>
                        <td><a href=/~you/display.php?MOVIE_ID=$send>$t</a></td>
                        <td align=right>$y</td>
                        </tr>";
                                    $ir++;
                                }
                                echo "</table>";
                                oci_free_statement($s_r);
                                ?>
                            </section>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--Footer-->
        <div id = "footer-wrapper">
            <footer id = "footer" class = "5grid-layout">
                <div class = "row">
                    <div class = "8u">

                        <!--Links-->
                        <section>
                            <h2>Important Links</h2>
                            <div class = "5grid">
                                <div class = "row">
                                    <div class = "3u">
                                        <ul class = "link-list last-child">
                                            <li><a href = "#">About Movie Time </a></li>
                                            <li><a href = "#">Help </a></li>
                                            <li><a href = "http://movies.msn.com/" target = "_blank">MSN Movie</a></li>

                                        </ul>
                                    </div>
                                    <div class = "3u">
                                        <ul class = "link-list last-child">
                                            <li><a href = "/~you/site_map.html">Site Map</a></li>
                                            <li><a href = "http://movies.yahoo.com/" target = "_blank">Yahoo Movie </a></li>
                                            <li><a href = "http://movies.disney.com/" target = "_blank">Disney Movie</a></li>

                                        </ul>
                                    </div>
                                    <div class = "3u">
                                        <ul class = "link-list last-child">
                                            <li><a href = "/~you/contact.php">Contact us</a></li>
                                            <li><a href = "http://www.imdb.com/" target = "_blank">IMDB</a></li>
                                            <li><a href = "http://www.google.com/movies" target = "_blank">Google Movie</a></li>

                                        </ul>
                                    </div>
                                    <div class = "3u">
                                        <ul class = "link-list last-child">
                                            <li><a href = "/~you/contact.php">Tell us what you think</a></li>
                                            <li><a href = "http://www.movies.com/" target = "_blank">Movies.com</a></li>
                                            <li><a href = "http://www.mtime.com/">Mtime</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>
                    <div class = "4u">

                        <!--Blurb-->
                        <section>
                            <h2>Information Box</h2>
                            
                            <p>Copyright ©2013 G6. All Rights Reserved.

                            </p>
                        </section>

                    </div>
                </div>
            </footer>
        </div>

        <!--Copyright-->
        <div id = "copyright">
            <a href = "http://www.ufl.edu/" target = "_blank">University of Florida</a> / <a href = "http://www.cise.ufl.edu/" target = "_blank">CISE</a>
        </div>

        <div style = "display:none"><script src = 'http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language = 'JavaScript' charset = 'gb2312'></script></div>
    </body>
</html>

<?php
oci_close($conn);
?>