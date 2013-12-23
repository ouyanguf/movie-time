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
        <title>MovieTime-Homepage</title>
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
                        <div class="6u">

                            <!-- Search -->
                            <p><form action="http://www.cise.ufl.edu/~you/search_result.php" method="post">
                                <p>Search&nbsp;&nbsp&nbsp;
                                    <input type="text" name="s_content" size="57" value="" />
                                </p>
                                <p>By&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    <select style="font-size:30px;" name="domain">
                                        <option value="title">Movie Title</option>
                                        <option value="r_year">Release Year&nbsp;&nbsp;&nbsp;</option>
                                        <option value="company">Company</option>
                                        <option value="genre">Genre</option>
                                        <option value="director">Director</option>
                                        <option value="actor">Actor</option>
                                    </select> 
                                    &nbsp;&nbsp;
                                    <input  style="padding: 0.3px 45px; font-size: 0.8em;position:relative; left:45px;" class="button-big" type="submit" name="submit" value="GO ON !" />
                                </p>
                            </form>   
                            </p>

                        </div>
                        <div class="6u">

                            <!-- Banner Image -->
                            <a href="display.php?MOVIE_ID=244366" class="bordered-feature-image"><img src="images/movie/244366.jpg" alt="" /></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div id="features-wrapper">
            <div id="features">
                <div class="5grid-layout">
                    <div class="row">
                        <div class="3u">

                            <!-- Feature #1 -->
                            <section>
                                <a href="display.php?MOVIE_ID=241101" class="bordered-feature-image"><img src="images/movie/241101.jpg" alt="" /></a>
                                <h2>Life of Pi</h2>
                                <p>
                                    A young man who survives a disaster at sea is hurtled into an epic journey of adventure and discovery.
                                    And an unexpected connection with a fearsome Bengal tiger.
                                </p>
                            </section>

                        </div>
                        <div class="3u">

                            <!-- Feature #2 -->
                            <section>
                                <a href="display.php?MOVIE_ID=238530" class="bordered-feature-image"><img src="images/movie/238530.jpg" alt="" /></a>
                                <h2>Lincoln</h2>
                                <p>
                                    When Civil War continues to rage,
                                    Lincoln struggles with carnage on the battlefield and as he fights with many inside his own cabinet on the decision to emancipate the slaves.
                                </p>
                            </section>

                        </div>
                        <div class="3u">

                            <!-- Feature #3 -->
                            <section>
                                <a href="display.php?MOVIE_ID=243610" class="bordered-feature-image"><img src="images/movie/243610.jpg" alt="" /></a>
                                <h2>Silver Linings Playbook</h2>
                                <p>
                                    After a stint in a mental institution, Pat moves back and tries to reconcile with his ex-wife.
                                    Things get more challenging when Pat meets Tif, a mysterious girl with problems of her own.
                                </p>
                            </section>

                        </div>
                        <div class="3u">

                            <!-- Feature #4 -->
                            <section>
                                <a href="display.php?MOVIE_ID=244367" class="bordered-feature-image"><img src="images/movie/244367.jpg" alt="" /></a>
                                <h2>Les Miserables</h2>
                                <p>
                                    Jean Valjean has been hunted by the ruthless policeman Javert after he breaks parole,
                                    agrees to care for factory worker Fantine's daughter, Cosette. The fateful decision changes their lives.
                                </p>
                            </section>

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

                            <!-- Rank by Deal: -->
                            <section>
                                <header>
                                    <h2>Deal of the week:</h2>											
                                </header>
                                <?php
//deals
                                $deal = "select movie_id,title,price,inventory,price*1.25 as d
                                        from movie 
										where inventory>100 and rownum<=10
                                        order by inventory desc, d asc";
										
										
                                $s_deal = oci_parse($conn, $deal);
								
                                oci_execute($s_deal);
                                echo "<table border=1>
                        <tr>
                      
                        <th align=left>TITLE</th>
						<th align=center>Deal</th>
                        <th align=right>Original</th>
						
                        </tr>
                        ";
                            
                                while (oci_fetch_object($s_deal) ) {
                                    $t = oci_result($s_deal, 'TITLE');
                                    $y = oci_result($s_deal, 'PRICE');
								    
									$x = number_format(oci_result($s_deal, 'D'), 2);
                                    $send = oci_result($s_deal, 'MOVIE_ID');
									
                                    echo "<tr>
                        
                        <td><a href=/~you/display.php?MOVIE_ID=$send>$t</a></td>
                        <td align=center>$y</td>
						<td align=right><strike>$x</strike></td>
                        </tr>";
						         
                                }
                                echo "</table>";
                                oci_free_statement($s_deal);
                                ?>

                            </section>

                      </div>
                         
                          <!-- Rank by user rating score -->
                           <div class="6u">
                            <section>
                                <header>
                                    <h2>Top rated</h2>										
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
                                while (oci_fetch_object($st1) and $i <= 12) {
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