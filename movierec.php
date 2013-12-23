#!/usr/local/bin/php

<?php
session_start();
if (!session_is_registered(curuserid)) {
    $reg = 0;
    header("location:login.php");
} else {
    $reg = 1;
}

$userid = $_SESSION['curuserid'];

putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");
$conn = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');
?>

<!DOCTYPE HTML>


<html>
    <head>
        <title>Movie Recommendation</title>
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
                                echo "<a href=UserProfile.php>Hi, There!<a href=http://www.cise.ufl.edu/~you/log_out_session.php>LogOut</a>";
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
                        <div class="6u">

                            <!-- Movie Recommendation By Preference -->
                            <section>
                                <header>
                                    <h2>Movie you may prefer:</h2>										
                                </header>
                                <?php
                                
                                //Movie rec by preference

                                $q1 = "Select title, score, movie_id
                                       From (Select m.title,r.score, m.movie_id
                                             From movie m, rate r 
                                             Where r.movie_id = m.movie_id and m.genre = 
											                    (Select p.g_name 
																 From prefer p 
																 Where p.user_id = $userid and p.prank=1) 
                                             and r.user_id = $userid
                                             Order by r.score desc)";
                                $st1 = oci_parse($conn, $q1);
                                oci_execute($st1);
								$q2 = "Select title, score, movie_id
                                       From (Select m.title,r.score, m.movie_id
                                             From movie m, rate r 
                                             Where r.movie_id = m.movie_id and m.genre = 
											                    (Select p.g_name 
																 From prefer p 
																 Where p.user_id = $userid and p.prank=2) 
                                             and r.user_id = $userid
                                             Order by r.score desc)";
								$st2 = oci_parse($conn, $q2);
                                oci_execute($st2);
							    $q3 = "Select title, score, movie_id
                                       From (Select m.title,r.score, m.movie_id
                                             From movie m, rate r 
                                             Where r.movie_id = m.movie_id and m.genre = 
											                    (Select p.g_name 
																 From prefer p 
																 Where p.user_id = $userid and p.prank=3) 
                                             and r.user_id = $userid
                                             Order by r.score desc)";
								$st3 = oci_parse($conn, $q3);
                                oci_execute($st3);
								echo "<h3>First Choice</h3>";
                        echo "<table border=1>
                        <tr>
                        <th width=35 align=center>Rank</th>
                        <th width=400 align=center>Movie Title</th>
                        <th align=right>Score</th>
                        </tr>";
                                $i = 1;
                                while (oci_fetch_object($st1) and $i <= 5) {
                                    $t1 = oci_result($st1, 'TITLE');
                                    $send1 = oci_result($st1, 'MOVIE_ID');
                                    $s1 = oci_result($st1, 'SCORE');
                                    echo "<tr>
                        <td align=center>$i</td>
                        <td align=center><a href=/~you/display.php?MOVIE_ID=$send1>$t1</a></td>
                        <td align=right>$s1</td>
                        </tr>";
                                    $i++;
                                }
								echo "</table>";
								
								echo "<h3>Second Choice</h3>";
                        echo "<table border=1>
                        <tr>
                        <th width=35 align=center>Rank</th>
                        <th width=400 align=center>Movie Title</th>
                        <th align=right>Score</th>
                        </tr>";
								 $j = 1;
                                while (oci_fetch_object($st2) and $j <= 5) {
                                    $t2 = oci_result($st2, 'TITLE');
                                    $send2 = oci_result($st2, 'MOVIE_ID');
                                    $s2 = oci_result($st2, 'SCORE');
                                    echo "<tr>
                        <td align=center>$j</td>
                        <td align=center><a href=/~you/display.php?MOVIE_ID=$send2>$t2</a></td>
                        <td align=right>$s2</td>
                        </tr>";
                                    $j++;
                                }
								echo "</table>";
								
								echo "<h3>Third Choice</h3>";
                        echo "<table border=1>
                        <tr>
                        <th width=35 align=center>Rank</th>
                        <th width=400 align=center>Movie Title</th>
                        <th align=right>Score</th>
                        </tr>";
								 $k = 1;
                                while (oci_fetch_object($st3) and $k <= 5) {
                                    $t3 = oci_result($st3, 'TITLE');
                                    $send3 = oci_result($st3, 'MOVIE_ID');
                                    $s3 = oci_result($st3, 'SCORE');
                                    echo "<tr>
                        <td align=center>$k</td>
                        <td align=center><a href=/~you/display.php?MOVIE_ID=$send3>$t3</a></td>
                        <td align=right>$s3</td>
                        </tr>";
                                    $k++;
                                }
                                echo "</table>";
                                oci_free_statement($st1);
								oci_free_statement($st2);
								oci_free_statement($st3);
                                ?>
                            </section>
                            
                            <!-- Movie recommendation in the same city: -->
                            <section>
                                <header>
                                    <h2>Favorite Movie In Your City:</h2>											
                                </header>
                                <?php
                                $q4 = "select m.title t, count(r.user_id) c, m.movie_id i
                                       from rate r, movie m
                                       where r.user_id in (select user_id 
                                                           from muser u 
                                                           where u.city = (select city 
                                                                           from muser 
                                                                           where user_id = $userid))
                                             and r.score >= 8 
                                             and r.movie_id = m.movie_id
                                       group by m.title, m.movie_id
                                       order by count(user_id) desc";
                                $st4 = oci_parse($conn, $q4);
                                oci_execute($st4);
                                echo "<table border=1>
                                  <tr>
                                  <th width=35 align=center>Rank</th>
                                  <th width=400 align=center>Title</th>
                                  <th align=right>Like</th>

                                  </tr>
                                  ";
                                $ib = 1;
                                while (oci_fetch_object($st4) and $ib <= 10) {
                                    $t4 = oci_result($st4, 'T');
                                    $c4 = oci_result($st4, 'C');
                                    $send4 = oci_result($st4, 'I');
                                    echo "<tr>
                                  <td align=center>$ib</td>
                                  <td align=center><a href=/~you/display.php?MOVIE_ID=$send4>$t4</a></td>
                                  <td align=right>$c4</td>
                                  </tr>";
                                    $ib++;
                                }
                                echo "</table>";
                                oci_free_statement($st4);
                                ?>

                            </section>

                        </div>
                        
                        <div class="6u">

                            <!-- Movie Recommendation By friends rating: -->
                            <section>
                                <header>
                                    <h2>Friends favorite movies by rating:</h2>											
                                </header>
                                <?php
                                //Recommendation By friends rating
                                $q5 = "
                                        select m.title t, count(r.user_id) c, m.movie_id i
                                        from rate r, movie m 
                                        where r.user_id in (select to_id from add_friend where from_id = $userid)
                                              and score >= 8 
                                              and r.movie_id = m.movie_id
                                              group by m.title, m.movie_id
                                              order by count(r.user_id) desc ";
                                $st5 = oci_parse($conn, $q5);
                                oci_execute($st5);
                                echo "<table border=1>
                        <tr>
                        <th width=35 align=center>Rank</th>
                        <th align=center>Title</th>
                        <th align=right>Favorite</th>
                        </tr>
                        ";
                                $i_income = 1;
                                while (oci_fetch_object($st5) and $i_income <= 10) {
                                    $t5 = oci_result($st5, 'T');
                                    $c5 = oci_result($st5, 'C');
                                    $send5 = oci_result($st5, 'I');
                                    echo "<tr>
                        <td align=center>$i_income</td>
                        <td><a href=/~you/display.php?MOVIE_ID=$send5>$t5</a></td>
                        <td align=right>$c5</td>
                        </tr>";
                                    $i_income++;
                                }
                                echo "</table>";
                                oci_free_statement($st5);
                                ?>

                            </section>
                            
                            <!-- Movie Recommendation By friends order: -->
                            <section>
                                <header>
                                    <h2>Friends favorite movies by order:</h2>											
                                </header>
                                <?php
                                //Recommendation By friends order
                                $q6 = "
                                        select m.title t, count(o.user_id) c, m.movie_id i
                                        from morder o, movie m 
                                        where o.user_id in (select to_id from add_friend where from_id = $userid)
                                              and o.movie_id = m.movie_id 
                                        group by m.title, m.movie_id
                                        order by count(o.user_id) desc ";
                                $st6 = oci_parse($conn, $q6);
                                oci_execute($st6);
                                echo "<table border=1>
                        <tr>
                        <th width=35 align=center>Rank</th>
                        <th align=center>Title</th>
                        <th align=right>Favorite</th>
                        </tr>";
                                $a = 1;
                                while (oci_fetch_object($st6) and $a <= 15) {
                                    $t6 = oci_result($st6, 'T');
                                    $c6 = oci_result($st6, 'C');
                                    $send6 = oci_result($st6, 'I');
                                    echo "<tr>
                        <td align=center>$a</td>
                        <td><a href=/~you/display.php?MOVIE_ID=$send6>$t6</a></td>
                        <td align=right>$c6</td>
                        </tr>";
                                    $a++;
                                }
                                echo "</table>";
                                oci_free_statement($st6);
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
                            <p>This page was last updated: Apr-05 19:15 by GROUP 6.</p>
                            <p>Copyright Â©2013 G6. All Rights Reserved.

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

    </body>
</html>

<?php
oci_close($conn);
?>