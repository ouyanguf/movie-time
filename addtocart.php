#!/usr/local/bin/php

<?php
session_start();
if (!session_is_registered(curuserid)) {
    $reg = 0;
} else {
    $reg = 1;
}

$userid = $_SESSION['curuserid'];
$id = $_GET["MOVIE_ID"];
$qun = $_POST["quantity"];

putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");
$conn = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');

$q1 = "select * from movie where MOVIE_ID = $id";
$st1 = oci_parse($conn, $q1);
oci_execute($st1);
oci_fetch_object($st1);

$resultP = oci_result($st1, 'PRICE');

$subtotal = $qun * $resultP;


if ($qun) {
    $q2 = "select * from cart where USER_ID = $userid and MOVIE_ID = $id";
    $st2 = oci_parse($conn, $q2);
    oci_execute($st2);

    if (!oci_fetch_object($st2)) {
        $qi = "insert into cart values($qun, $subtotal, $userid, $id)";
        $sti = oci_parse($conn, $qi);
        oci_execute($sti);
        oci_free_statement($sti);
    } else {
        $qu = "update cart set AMOUNT = $qun, SUBTOTAL = $subtotal where USER_ID = $userid and MOVIE_ID = $id";
        $stu = oci_parse($conn, $qu);
        oci_execute($stu);
        oci_free_statement($stu);
    }
    oci_free_statement($st2);
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Add To Cart</title>
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

                            <!-- Search -->
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
            <div id="banner">
                <div class="5grid-layout">
                    <div class="row">
                        <div class="3u">

                            <!-- Movie Poster -->
                            <a href="http://www.cise.ufl.edu/~you/display.php?MOVIE_ID=<?php echo $id; ?>" class="bordered-feature-image"><img src="images/movie/<?php echo $id; ?>.jpg" alt="" onError="this.src='images/movie/default.jpg';" /></a>

                        </div>
                        <div class="3u">

                            <!-- Movie Name -->
                            <header> 
                                <h2 style="font-size:30px; text-align:center; position: relative; top: 25px;">
                                    <a href="http://www.cise.ufl.edu/~you/display.php?MOVIE_ID=<?php echo $id; ?>" style="text-decoration:underline; color:#FFF"><?php
                                    $resultT = oci_result($st1, 'TITLE');
                                    echo $resultT;
                                    ?></a>
                                </h2>
                                <h3 style="font-size:28px; text-align:center; position: relative; top: 40px;">
                                    <?php
                                    echo "$ $resultP";
                                    ?>
                                </h3>
                            </header>

                        </div>
                        <div class="3u">

                            <!-- Cart Info -->
                            <header>
                                <h2 style="font-size:30px; text-align:center; position: relative; top: 25px;">
                                    Order Subtotal: 
                                    <?php
                                    echo "$ $subtotal";
                                    ?>
                                </h2>
                                <h3 style="font-size:28px; text-align:center; position: relative; top: 40px;">
                                    <?php
                                    if ($qun == 1) {
                                        echo "$qun item in your Cart";
                                    } else {
                                        echo "$qun items in your Cart";
                                    }
                                    oci_free_statement($st1);
                                    ?>
                                </h3>
                            </header>	

                        </div>
                        <div class="3u">

                            <!-- Click Button -->
                            <a href="cart.php" class="button-big" style="position: relative; top: 40px; left: 50px;">Edit Your Cart</a>

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

                            <!-- Box #1 -->
                            <section>
                                <header>
                                    <h2>Who We Are</h2>
                                    <h3>We are NOT someone, we are THE ONE!</h3>
                                </header>
                                <a href="contact.php" class="feature-image"><img src="images/we.jpg" alt="" /></a>
                                <h3>
                                    Join us!
                                    </br>
                                    We make U wonder!
                                </h3>
                            </section>

                        </div>
                        <div class="4u">

                            <!-- Box #2 -->
                            <section>
                                <header>
                                    <h2>What We Do</h2>
                                    <h3>Still don't know what we do?</h3>
                                </header>
                                <ul class="check-list">
                                    <li>We MAKE!</li>
                                    <li>We BUILD!</li>
                                    <li>We CREATE!</li>
                                    <li>We make things POSSIBLE!</li>
                                    <li>We ENJOY!</li>
                                </ul>
                            </section>

                        </div>
                        <div class="4u">

                            <!-- Box #3 -->
                            <section>
                                <header>
                                    <h2>What People Are Saying</h2>
                                    <h3>Wanna say something?</h3>
                                </header>
                                <ul class="quote-list">
                                    <li>
                                        <img src="images/pic06.jpg" alt="" />
                                        <p>"GOD! This place is amazing!"</p>
                                        <span>Jane Doe, CEO of United Corp</span>
                                    </li>
                                    <li>
                                        <img src="images/pic07.jpg" alt="" />
                                        <p>"I can't believe my eyes!"</p>
                                        <span>John Doe, President of FakeBiz</span>
                                    </li>
                                    <li>
                                        <img src="images/pic08.jpg" alt="" />
                                        <p>"I'm gonna hire there guys! Right Now!"</p>
                                        <span>Mary Smith, CFO of Uni-Biz</span>
                                    </li>
                                </ul>
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

                          Instructed by <a href="http://www.cise.ufl.edu/~mschneid/">Prof. Markus Schneider</a></br>
                          Copyright ©2013 G6. All Rights Reserved.                            </br>
                           Copyrighted ©1999 - 2013 by Doug MacLean (Home Theater Info) &amp; Michael E. Carver (Michael's Movie Mayhem).</br>
                        </section>

                    </div>
                </div>
            </footer>
        </div>

        <!-- Copyright -->
        <div id="copyright">
            <a href="http://www.ufl.edu/" target="_blank">University of Florida</a> / <a href="http://www.cise.ufl.edu/" target="_blank">CISE</a>
        </div>
    </body>
</html>