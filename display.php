#!/usr/local/bin/php

<?php
session_start();
if (!session_is_registered(curuserid)) {
    $reg = 0;
} else {
    $reg = 1;
}

$userid = $_SESSION['curuserid'];

putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");
$conn = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');

$id = $_GET["MOVIE_ID"];
$rate = $_POST['rating'];

if ($reg) {
    if ($rate) {
        $qs = "select score from rate where USER_ID = $userid and MOVIE_ID = $id";
        $sts = oci_parse($conn, $qs);
        oci_execute($sts);

        if (!oci_fetch_object($sts)) {

            $qr = "insert into rate values($userid, $id, $rate)";
            $str = oci_parse($conn, $qr);
            oci_execute($str);
            oci_free_statement($str);
        }
        oci_free_statement($sts);
    }
}
?>

<!DOCTYPE HTML>

<html>
    <head>
        <title>
            <?php
            $q1 = "select * from movie where MOVIE_ID = $id";
            $st1 = oci_parse($conn, $q1);
            oci_execute($st1);

            oci_fetch_object($st1);

            $resultT = oci_result($st1, 'TITLE');
            echo $resultT;
            ?>
        </title>

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <noscript><link rel="stylesheet" href="css/5grid/core.css" /><link rel="stylesheet" href="css/5grid/core-desktop.css" /><link rel="stylesheet" href="css/5grid/core-1200px.css" /><link rel="stylesheet" href="css/5grid/core-noscript.css" /><link rel="stylesheet" href="css/style.css" /><link rel="stylesheet" href="css/style-desktop.css" /></noscript>
        <script src="css/5grid/jquery.js"></script>
        <script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none&amp;mobileUI.titleBarHeight=55&amp;mobileUI.openerWidth=75&amp;mobileUI.openerText=&lt;"></script>
        <!--[if lte IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->
    </head>
    <body >

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
                                echo "<a href=UserProfile.php>Hi, There!</a>"; 
                                echo "<a href=http://www.cise.ufl.edu/~you/log_out_session.php>LogOut</a>";
                            } else {
                                echo "<a href=http://www.cise.ufl.edu/~you/login.php>LogIn</a>";
                                echo "<a href=http://www.cise.ufl.edu/~you/register.php>Register</a>";
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
                        <div class="4u">

                            <!-- Left Sidebar -->


                            <a href="#" class="bordered-feature-image"><img src="images/movie/<?php echo $id; ?>.jpg" alt="Missing Image" onError="this.src='images/movie/default.jpg';"/></a>

                            <section>
                                <header>
                                    <h2>Find this movie here:</h2>
                                </header>
                                <ul class="link-list">
                                    <li><a href="http://www.imdb.com/find?q=<?php echo $resultT; ?>" target="_black">IMDb</a></li>
                                    <li><a href="http://movies.msn.com/search/movies/?q=<?php echo $resultT; ?>" target="_black">MSN Movie</a></li>
                                    <li><a href="http://movie.douban.com/subject_search?search_text=<?php echo $resultT; ?>" target="_black">Dou Ban</a></li>
                                    <li><a href="http://www.movies.com/search-result?search=<?php echo $resultT; ?>" target="_black">Movie.com</a></li>
                                    <li><a href="http://search.mtime.com/search/?<?php echo $resultT; ?>" target="_black">Mtime</a></li>
                                </ul>
                            </section>
                        </div>
                        <div class="5u mobileUI-main-content">

                            <!-- Main Content -->
                            <section>
                                <header>
                                    <h2>
                                        <?php
                                        echo "$resultT";
                                        ?>
                                    </h2>
                                </header>
                                <h3>Movie Profile</h3>

                                <p>
                                <ul class="link-list">
                                    <?php
                                    $q2 = "select * from movie m, director d where m.MOVIE_ID = $id and m.DIRECTOR_ID = d.DIRECTOR_ID";
                                    $st2 = oci_parse($conn, $q2);
                                    $q3 = "select * from movie m, act a, actor ac where m.MOVIE_ID = $id and m.MOVIE_ID = a.MOVIE_ID and a.ACTOR_ID = ac.ACTOR_ID";
                                    $st3 = oci_parse($conn, $q3);

                                    oci_execute($st2);
                                    oci_execute($st3);



                                    echo "<li><h style=font-weight:bold;>Director:</h>&nbsp&nbsp&nbsp";
                                    while (oci_fetch_object($st2)) {
                                        $resultDF = oci_result($st2, 'FIRST');
                                        $resultDL = oci_result($st2, 'LAST');
                                        echo "$resultDF $resultDL / ";
                                    }
                                    echo "</li>";
                                    oci_free_statement($st2);




                                    echo "<li><h style=font-weight:bold;>Leading Actor:</h>&nbsp&nbsp&nbsp";
                                    while (oci_fetch_object($st3)) {
                                        $resultAF = oci_result($st3, 'FIRST');
                                        $resultAL = oci_result($st3, 'LAST');
                                        echo "$resultAF $resultAL / ";
                                    }
                                    echo "</li>";
                                    oci_free_statement($st3);


                                    $resultGR = oci_result($st1, 'GENRE');
                                    echo "<li><h style=font-weight:bold;>Genre:</h>&nbsp&nbsp&nbsp$resultGR</li>";


                                    $resultRY = oci_result($st1, 'R_YEAR');
                                    echo "<li><h style=font-weight:bold;>Release Year:</h>&nbsp&nbsp&nbsp$resultRY</li>";


                                    $resultCP = oci_result($st1, 'COMPANY');
                                    echo "<li><h style=font-weight:bold;>Company:</h>&nbsp&nbsp&nbsp$resultCP</li>";
									
									$resultBO = oci_result($st1, 'BOX');
                                    echo "<li><h style=font-weight:bold;>Box Office:</h>&nbsp&nbsp&nbsp$resultBO</li>";
                                    ?> 
                                </ul>
                                </p>

                                <p> 
                                <header>
                                    <h3>Story Line</h3>
                                </header>
                                <p>

                                    <?php
                                    $resultSL = oci_result($st1, 'STORYLINE');
                                    echo $resultSL;
                                    ?>							
                                </p>

                            </section>

                        </div>
                        <div class="3u">

                            <!-- Right Sidebar -->
                            <section>
                                <header>
                                    <h2>Movie Rating</h2>
                                    
                                    <h3 style="font-size: 1.5em;">
                                        <?php
                                        $q4 = "select AVG(score) A from rate where MOVIE_ID = $id group by MOVIE_ID";
                                        $st4 = oci_parse($conn, $q4);

                                        oci_execute($st4);
                                        oci_fetch_object($st4);

                                        $resultAS = oci_result($st4, 'A');
                                        echo number_format($resultAS, 1);

                                        oci_free_statement($st4);
                                        ?>
                                      
                                        <h style="color:#373f42;font-size:0.7em;position:relative;left:70px;">
                                        <?php
                                        $q5 = "select COUNT(USER_ID) C from rate where MOVIE_ID = $id group by MOVIE_ID";
                                        $st5 = oci_parse($conn, $q5);

                                        oci_execute($st5);
                                        oci_fetch_object($st5);

                                        $resultNP = oci_result($st5, 'C');
                                        echo "$resultNP People rated";

                                        oci_free_statement($st5);
                                        ?>
                                        <h>
                                    </h3>
                                </header>

                                <form action=http://www.cise.ufl.edu/~you/display.php?MOVIE_ID=<?php echo $id; ?> method=POST>
                                    <ul class=link-list>
                                        <li>&nbsp;&nbsp;&nbsp;10: &nbsp;&nbsp;<input type='radio' name='rating' value='10' /> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            5: &nbsp;&nbsp;&nbsp;<input type='radio' name='rating' value='5' />
                                        </li>
                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;9: &nbsp;&nbsp;&nbsp;<input type='radio' name='rating' value='9' /> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            4: &nbsp;&nbsp;&nbsp;<input type='radio' name='rating' value='4' />
                                        </li>
                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;8: &nbsp;&nbsp;&nbsp;<input type='radio' name='rating' value='8' /> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            3: &nbsp;&nbsp;&nbsp;<input type='radio' name='rating' value='3' />
                                        </li>
                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;7: &nbsp;&nbsp;&nbsp;<input type='radio' name='rating' value='7' /> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            2: &nbsp;&nbsp;&nbsp;<input type='radio' name='rating' value='2' />
                                        </li>
                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;6: &nbsp;&nbsp;&nbsp;<input type='radio' name='rating' value='6' /> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            1: &nbsp;&nbsp;&nbsp;<input type='radio' name='rating' value='1' />
                                        </li>
                                    </ul>
                                    <?php
                                    if (session_is_registered(curuserid)) {
                                        ?>
                                        <input style="padding: 0.5px 40px; font-size: 1.5em;" class="button-big" type="submit" value="Submit" />
                                    </form>
                                    <?php
                                } else {
                                    ?>
                                    <a style="padding: 5px 42px; font-size: 1.5em; color: #FFF8DC;" href="login.php" class="button-big">Submit</a>
                                    <?php
                                }
                                ?> 




                            </section>
                            <section>
                                <header>
                                    <h2> Buy Now!</h2>
                                    <h3> 
                                        <?php
                                        $resultP = oci_result($st1, 'PRICE');
                                        echo "$ $resultP";

                                        oci_free_statement($st1);
                                        ?>
                                    </h3> 
                                </header>
                                <p>
                                    <?php
                                    if (session_is_registered(curuserid)) {
                                        echo "<form action=http://www.cise.ufl.edu/~you/addtocart.php?MOVIE_ID=$id method=POST>";
                                        echo "Quantity: <select style=font-size:16px; name=quantity>";
                                        for ($i = 1; $i < 21; $i++) {
                                            echo "<option value=$i>$i</option>";
                                        }
                                        echo "</select>";
                                        ?>
                                    </p>
                                    <input  style="padding: 2px 42px; font-size: 1.5em;" class="button-big" type="submit" name="submit" value="Add To Cart" />
                                    <?php
                                } else {
                                    ?>		   
                                    <a style="padding: 5px 42px; font-size: 1.5em; color: #FFF8DC;" href="login.php" class="button-big">Add To Cart</a>
                                    <?php
                                }
                                ?> 
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