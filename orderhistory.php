#!/usr/local/bin/php

<?php
putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");
$conn = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');
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
        <title>Order History</title>
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

        <div id="content-wrapper">
				<div id="content">
					<div class="5grid-layout">
						<div class="row">
							<div class="4u">
								
								<!-- Sidebar -->
									<section>
										<header>
											<header>
											  <h2>Your account</h2>
										  </header>
                                           <?php
										   $curuid = $_SESSION['curuserid'];
										    $q1 = "select COUNT(*), SUM(AMOUNT * SUBTOTAL) as TOTAL
                                                from MORDER
                                                where USER_ID = $curuid ";
                                            $st1 = oci_parse($conn, $q1);
                                            oci_execute($st1);
											oci_fetch($st1);
                                            $a = oci_result($st1, 'TOTAL');
											$b = oci_result($st1, 'COUNT(*)');
                                           
                             echo "<li><h3><em><strong>You have purchased $b Movie(s).</strong></em></h3></li> ";
											  
                                           
                             echo "<li><h3><em><strong>You have spent $ $a in total.</strong></em></h3></li> ";
                                          
										  oci_free_statement($st1);
											?>
                                            
                                            <h2>&nbsp;</h2></header>
									</section>
									<section>
										<header>
											<h2>More Top Picks for You</h2>
										</header>
										<ul class="link-list">
                                        
                                         <?php
                                            $q_get = "select M.MOVIE_ID,M.TITLE,AVG(R.SCORE) as avs
from  RATE R,MOVIE M,MORDER O
where M.GENRE in (select M.GENRE
                  from MORDER O,MOVIE M
                  where M.MOVIE_ID=O.MOVIE_ID and
                  O.USER_ID=$curuid) and
      M.MOVIE_ID not in (select MOVIE_ID
                         from MORDER
                         where USER_ID=$curuid) and
     R.MOVIE_ID=M.MOVIE_ID and
     ROWNUM<=100
group by m.title, m.movie_id
order by avs DESC";
                                                
                                            $st_get = oci_parse($conn, $q_get);
                                            oci_execute($st_get);
											while (oci_fetch_object($st_get)) 
											{
												$t = oci_result($st_get, 'TITLE');
												$send = oci_result($st_get, 'MOVIE_ID');
												echo"<li><td><h1><strong><a href=/~you/display.php?MOVIE_ID=$send>$t</a></strong></h1></td></li>";
											}
											oci_free_statement($st_get);
											 ?>
                                             
                                             
										
											<li></li>
										</ul>
									</section>

							</div>
							<div class="8u mobileUI-main-content">
								
								<!-- Main Content -->
											
							  <section>
                                    <h2>Your order history</h2>
									<h3>See what you've got!</h3>
								<header>
                                        <table width="708" height="48" border="1">
                                        <tr>
                                        <th width="70" ALIGN="LEFT"><h1><strong>No.</strong></h1></th>
                                        <th width="406" ALIGN="LEFT"><h1><strong>Items In History Orders</strong></h1></th>
                                        <th width="87" ALIGN="LEFT"><h1><strong>Price</strong></h1></th>
                                        <th width="117" ALIGN="LEFT"><h1><strong>Amount</strong></h1></th>
                                        <th width="110" ALIGN="LEFT"><h1><strong>Time</strong></h1></th>
                                        </tr>


                                        <tr> 
                                      
                                            <?php
                                            $q_get = "select M.MOVIE_ID,M.TITLE,O.SUBTOTAL,O.AMOUNT,TO_CHAR(O.TIME, 'DD-MON-YYYY HH24:MI:SS') TT
                                                from MORDER O,MOVIE M
                                                where O.USER_ID = $curuid and M.MOVIE_ID = O.MOVIE_ID";
                                                
                                            $st_get = oci_parse($conn, $q_get);
                                            oci_execute($st_get);
                                            $i_get = 1;
                                            while (oci_fetch_object($st_get)) {

                                                $t = oci_result($st_get, 'TITLE');
                                                $p = oci_result($st_get, 'SUBTOTAL');
                                                $a = oci_result($st_get, 'AMOUNT');
                                                $c = oci_result($st_get, 'TT');
												$send = oci_result($st_get, 'MOVIE_ID');
                                                echo "
                                                <tr>
                                                    <td><h1><strong>$i_get</strong></h1></td>
                                                    <td><h1><strong><a href=/~you/display.php?MOVIE_ID=$send>$t</a></strong></h1></td>
                                                    <td><h1><strong>$p</strong></h1></td>
                                                    <td><h1><strong>$a</strong></h1></td>
                                                    <td><h1><strong>$c</strong></h1></td>    
                                                                
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
                             
                                            </tr>
                                    
                                    </table>  
								</header>
										<p>&nbsp;</p>
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