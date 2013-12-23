#!/usr/local/bin/php

<?php
session_start();
if (!session_is_registered(curuserid)) {
    $reg = 0;
} else {
    $reg = 1;
}
?>

<!DOCTYPE HTML>

<html>
    <head>
        <title>Search Result</title>
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
                                <select style="vertical-align:middle;font-size:22px;" name="domain">
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
                        <div class="12u">

                            <!-- Main Content -->
                            <section>
                                <header>
                                    <h2>Search Result</h2>
                                </header>
                                <p>
                                    <?php
                                    $domain = $_POST['domain'];
                                    $content = $_POST['s_content'];
                                    $lcontent = strtolower($content);

                                    putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");
                                    $conn = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');

                                    switch ($domain) {
                                        case title:
                                            $q1 = "select * from movie
                                                    where lower($domain) like lower('$content%') or lower($domain) like lower('% $content%')
                                                    order by $domain";
                                            $st1 = oci_parse($conn, $q1); //or $domain like '$lcontent%'
                                            oci_execute($st1);
                                            if (!oci_fetch_object($st1)) {
                                                echo "Sorry! No records found!";
                                            } else {
                                                oci_execute($st1);
                                                echo "<table border=1>
                                                        <tr align=left>
                                                        <th width=10>No.</th>
                                                        <th width=100>MOVIE TITLE</th>
                                                        </tr>
                                                        ";
                                                $i = 1;
                                                while (oci_fetch_object($st1) and $i <= 1000) {
                                                    $t = oci_result($st1, 'TITLE');
                                                    $send = oci_result($st1, 'MOVIE_ID');
                                                    echo "<tr>
                        <td>$i</td>
                        <td><a href=/~you/display.php?MOVIE_ID=$send>$t</a></td>
                        </tr>";
                                                    $i++;
                                                }
                                                echo "</table>";
                                                oci_free_statement($st1);
                                            }
                                            break;
                                        case company:
                                            $q1 = "select *
                    from movie 
                    where lower($domain) like lower('$content%') or lower($domain) like lower('% $content%')
                    order by $domain, title";
                                            $st1 = oci_parse($conn, $q1);
                                            oci_execute($st1);
                                            if (!oci_fetch_object($st1)) {
                                                echo "Sorry! No records found!";
                                            } else {
                                                oci_execute($st1);
                                                echo "<table border=1>
                        <tr align=left>
                        <th width=10>No.</th>
                        <th width=100>MOVIE TITLE</th>
                        <th width=30>COMPANY NAME</th>
                        </tr>
                        ";
                                                $i = 1;
                                                while (oci_fetch_object($st1) and $i <= 1000) {
                                                    $t = oci_result($st1, 'TITLE');
                                                    $c = oci_result($st1, 'COMPANY');
                                                    $send = oci_result($st1, 'MOVIE_ID');
                                                    echo "
                        <tr>
                        <td>$i</td>
                        <td><a href=/~you/display.php?MOVIE_ID=$send>$t</a></td>
                        <td>$c</td>  
                        </tr>";
                                                    $i++;
                                                }
                                                echo "</table>";
                                                oci_free_statement($st1);
                                            }
                                            break;
                                        case genre:
                                            $q1 = "select * 
                    from movie 
                    where lower($domain) like lower('$content%') or lower($domain) like lower('%$content%')
                    order by $domain, title";
                                            $st1 = oci_parse($conn, $q1);
                                            oci_execute($st1);
                                            if (!oci_fetch_object($st1)) {
                                                echo "Sorry! No records found!";
                                            } else {
                                                oci_execute($st1);
                                                echo "<table border=1>
                        <tr align=left>
                        <th width=10>No.</th>
                        <th width=100>MOVIE TITLE</th>
                        <th width=40>GENRE</th>
                        </tr>
                        ";
                                                $i = 1;
                                                while (oci_fetch_object($st1) and $i <= 1000) {
                                                    $t = oci_result($st1, 'TITLE');
                                                    $g = oci_result($st1, 'GENRE');
                                                    $send = oci_result($st1, 'MOVIE_ID');
                                                    echo "
                        <tr>
                        <td>$i</td>
                        <td><a href =/~you/display.php?MOVIE_ID=$send>$t</a></td>
                        <td>$g</td>
                        </tr > ";
                                                    $i++;
                                                }
                                                echo "</table>";
                                                oci_free_statement($st1);
                                            }
                                            break;
                                        case r_year:
                                            $q1 = "select *
                                from movie
                                where to_char($domain,'9999') like '%$content'
                                order by title";
                                            $st1 = oci_parse($conn, $q1);
                                            oci_execute($st1);
                                            if (!oci_fetch_object($st1)) {
                                                echo "Sorry!No records found!";
                                            } else {
                                                oci_execute($st1);
                                                echo "<table border = 1>
                        <tr align=left>
                        <th width=10>No.</th>
                        <th width=100>MOVIE TITLE</th>
                        <th width=20>RELEASE YEAR</th>
                        </tr>
                        ";
                                                $i = 1;
                                                while (oci_fetch_object($st1) and $i <= 1000) {
                                                    $t = oci_result($st1, 'TITLE');
                                                    $y = oci_result($st1, 'R_YEAR');
                                                    $send = oci_result($st1, 'MOVIE_ID');
                                                    echo "
                        <tr>
                        <td>$i</td>
                        <td><a href =/~you/display.php?MOVIE_ID=$send>$t</a></td>
                        <td>$y</td>
                        </tr> ";
                                                    $i++;
                                                }
                                                echo "</table>";
                                                oci_free_statement($st1);
                                            }
                                            break;
                                        case director:
                                            $q1 = "select m.TITLE, d.FIRST, d.LAST, d.SEX, m.MOVIE_ID
                                from movie m, director d
                                where d.DIRECTOR_ID = m.DIRECTOR_ID AND
                                (lower(d.FIRST) like lower('$content%') OR lower(d.LAST) like lower('$content%') or lower(d.first) like lower('% $content%') or lower(d.last) like lower('% $content%'))
                                order by first, last";
                                            $st1 = oci_parse($conn, $q1);
                                            oci_execute($st1);
                                            if (!oci_fetch_object($st1)) {
                                                echo "Sorry!No records found!";
                                            } else {
                                                oci_execute($st1);
                                                echo "<table border = 1>
                        <tr align=left>
                        <th width=10>No.</th>
                        <th width=100>MOVIE TITLE</th>
                        <th width=30>DIRECTOR NAME</th>
                        <th width=20>SEX</th>
                        </tr>
                        ";
                                                $i = 1;
                                                while (oci_fetch_object($st1) and $i <= 1000) {
                                                    $t = oci_result($st1, 'TITLE');
                                                    $n = oci_result($st1, 'FIRST') . " " . oci_result($st1, 'LAST');
                                                    $s = oci_result($st1, 'SEX');
                                                    $send = oci_result($st1, 'MOVIE_ID');
                                                    echo "
                        <tr>
                        <td>$i</td>
                        <td><a href =/~you/display.php?MOVIE_ID=$send>$t</a></td>
                        <td>$n</td>
                        <td>$s</td>
                        </tr>
                        ";
                                                    $i++;
                                                }
                                                echo "</table>";
                                                oci_free_statement($st1);
                                            }
                                            break;
                                        case actor:
                                            $q1 = "select movie.movie_id, movie.title, first, last, sex
                                from movie, actor, act
                                where movie.movie_id = act.movie_id AND
                                actor.actor_id = act.actor_id AND
                                (lower(actor.first) like lower('$content%') or lower(actor.last) like lower('$content%') or lower(actor.first) like lower('% $content%') or lower(actor.last) like lower('% $content%'))
                                order by first, last";
                                            $st1 = oci_parse($conn, $q1);
                                            oci_execute($st1);
                                            if (!oci_fetch_object($st1)) {
                                                echo "Sorry!No records found!";
                                            } else {
                                                oci_execute($st1);
                                                echo "<table border = 1>
                        <tr align=left>
                        <th width=10>No.</th>
                        <th width=100><h3>MOVIE TITLE</h3></th>
                        <th width=30><h3>ACTOR NAME</h3></th>
                        <th width=20><h3>SEX</h3></th>
                        </tr>
                        ";
                                                $i = 1;
                                                while (oci_fetch_object($st1) and $i <= 1000) {
                                                    $t = oci_result($st1, 'TITLE');
                                                    $n = oci_result($st1, 'FIRST') . " " . oci_result($st1, 'LAST');
                                                    $s = oci_result($st1, 'SEX');
                                                    $send = oci_result($st1, 'MOVIE_ID');
                                                    echo "
                        <tr>
                        <td>$i</td>
                        <td><a href =/~you/display.php?MOVIE_ID=$send>$t</a></td>
                        <td>$n</td>
                        <td>$s</td>
                        </tr>
                        ";
                                                    $i++;
                                                }
                                                echo "</table>";
                                                oci_free_statement($st1);
                                            }
                                            break;
                                    }
                                    oci_close($conn);
                                    ?>
                                </p>

                            </section>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
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
                                            <li><a href="#">About Movie Time </a></li>
                                            <li><a href="#">Help </a></li>
                                            <li><a href="http://movies.msn.com/" target="_blank">MSN Movie</a></li>

                                        </ul>
                                    </div>
                                    <div class="3u">
                                        <ul class="link-list last-child">
                                            <li><a href="/~you/site_map.html">Site Map</a></li>
                                            <li><a href="http://movies.yahoo.com/" target="_blank">Yahoo Movie </a></li>
                                            <li><a href="http://movies.disney.com/" target="_blank">Disney Movie</a></li>

                                        </ul>
                                    </div>
                                    <div class="3u">
                                        <ul class="link-list last-child">
                                            <li><a href="/~you/contact.php">Contact us</a></li>
                                            <li><a href="http://www.imdb.com/" target="_blank">IMDB</a></li>
                                            <li><a href="http://www.google.com/movies" target="_blank">Google Movie</a></li>

                                        </ul>
                                    </div>
                                    <div class="3u">
                                        <ul class="link-list last-child">
                                            <li><a href="/~you/contact.php">Tell us what you think</a></li>
                                            <li><a href="http://www.movies.com/" target="_blank">Movies.com</a></li>
                                            <li><a href="http://www.mtime.com/">Mtime</a></li>

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
                            <p>This page was last updated:  Apr-05 19:15 by GROUP 6.</p>
                            <p>Copyright ©2013 G6. All Rights Reserved.

                            </p>
                        </section>

                    </div>
                </div>
            </footer>
        </div>

        <!-- Copyright -->
        <div id="copyright">
            <a href="http://www.ufl.edu/" target="_blank">University of Florida</a> / <a href="http://www.cise.ufl.edu/" target="_blank">CISE</a>
        </div>

        <div style="display:none"><script src='http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language='JavaScript' charset='gb2312'></script></div>
    </body>
</html>