#!/usr/local/bin/php

<?php
session_start();
if (!session_is_registered(curuserid)) {
    header("location:login.php");
} else {
    $reg = 1;
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Administrator</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <noscript><link rel="stylesheet" href="css/5grid/core.css" /><link rel="stylesheet" href="css/5grid/core-desktop.css" /><link rel="stylesheet" href="css/5grid/core-1200px.css" /><link rel="stylesheet" href="css/5grid/core-noscript.css" /><link rel="stylesheet" href="css/style.css" /><link rel="stylesheet" href="css/style-desktop.css" /></noscript>
        <script src="css/5grid/jquery.js"></script>
        <script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none&amp;mobileUI.titleBarHeight=55&amp;mobileUI.openerWidth=75&amp;mobileUI.openerText=&lt;"></script>


    </head>

    <body>

        <!-- Header -->
        <div id="header-wrapper">
            <header id="header" class="5grid-layout">
                <div class="row">
                    <div class="12u">

                        <!-- Logo -->
                        <h1><a href="/~you/index.php" class="mobileUI-site-name"><strong>MovieTime</strong></a></h1>

                        <nav class="mobileUI-site-nav" style="position:absolute; top: 1px; right: 1px; font-size: 15px;">
                            <?php
                            if ($reg) {
                                echo "<a href=UserProfile.php>Hi, There!|<a href=http://www.cise.ufl.edu/~you/log_out_session.php>LogOut</a>";
                            } else {
                                echo "<a href=http://www.cise.ufl.edu/~you/login.php>LogIn</a>|<a href=http://www.cise.ufl.edu/~you/register.php>Register</a>";
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
            <div id="banner">
                <div class="5grid-layout">
                    <div class="row">
                        <div class="12u">
                            <section>
                                <!-- Search as user-->
                                <form action="http://www.cise.ufl.edu/~you/search_result.php" method="post">
                                    <p>Search As User&nbsp;&nbsp&nbsp;
                                        <input type="text" name="s_content" size="50" value="" />
                                        &nbsp;&nbsp;&nbsp;
                                        by
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <select style="font-size:30px;" name="domain">
                                            <option value="title">Movie Title</option>
                                            <option value="r_year">Release Year&nbsp;&nbsp;&nbsp;</option>
                                            <option value="company">Company</option>
                                            <option value="genre">Genre</option>
                                            <option value="director">Director</option>
                                            <option value="actor">Actor</option>
                                        </select> 
                                        &nbsp;&nbsp;
                                        <input  style="padding: 0.3px 46px; font-size: 0.8em;position:relative; left:45px;" class="button-big" type="submit" name="submit" value="GO ON !" />
                                    </p>
                                </form> 
                            </section>

                            <section>
                                <!-- Search as Admin-->
                                <form action="http://www.cise.ufl.edu/~you/search_result_admin.php" method="post">
                                    <p>Search As Admin
                                        &nbsp;
                                        <select style="font-size:30px;" name="attr">
                                            <option value="MOVIE_ID">MOVIE_ID</option>
                                            <option value="TITLE">MOVIE TITLE</option>
                                            <option value="USER_ID">USER_ID</option>
                                            <option value="USERNAME">USERNAME</option>
                                            <option value="NAME">REAL NAME</option>
                                            <option value="ACTOR_ID">ACTOR_ID</option>
                                        </select>
                                        &nbsp;
                                        <input type="text" name="s_content" size="50" value="" />
                                        &nbsp;
                                        in table
                                        &nbsp;
                                        <select style="font-size:30px;" name="table">
                                            <option value="MOVIE">Movie</option>
                                            <option value="MUSER">User</option>
                                            <option value="ACTOR">Actor</option>
                                        </select> 
                                        <input  style="padding: 0.3px 46px; font-size: 0.8em;position:relative; left:30px;" class="button-big" type="submit" name="submit" value="GO ON !" />
                                    </p>
                                </form> 
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
                            <p>This page was last updated:  Apr-11 19:15 by GROUP 6.</p>
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
    </body>
</html>