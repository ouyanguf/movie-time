#!/usr/local/bin/php



<?php
session_start();
if (!session_is_registered(curuserid)) {
    $reg = 0;
    header("location:login.php");
} else {
    $reg = 1;
}
?>

<!DOCTYPE HTML>

<html>
    <head>
        <title>User Profile Page</title>
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
                        <div class="3u">

                            <!-- Sidebar -->
                            <section>
                                <header>
                                    <h2>What you may use</h2>
                                </header>
                                <form action="find_friend.php" method="post" id="searchfiendform">								<ul class="link-list">
                                        <li>Find your friend: <input type="text" name="friendname"/> <input style="padding: 1px 10px; font-size: 1em;" class="button-big" type="submit" value="search"/></li>
                                        <li><a href="/~you/friendlist.php">Your friend list</a></li>
                                        <li><a href="/~you/movierec.php">Recommendation for you</a></li>
                                        <li><a href="/~you/cart.php">Go to your cart</a></li>
                                        <li><a href="/~you/orderhistory.php">View past Purchase History</a></li>
                                        <li><a href="/~you/editprofile.php">Edit your profile</a></li>


                                        <li><a href="/~you/pastcomment.php">View past comments</a></li>										
                                    </ul>
                                </form>
                            </section>
                        </div>
                        <div class="9u mobileUI-main-content">

                            <!-- Main Content -->
                            <section>
                                <header>

                                    <?php
                                    $userid = $_SESSION['curuserid'];
                                    putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");

                                    $connection = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');

                                    if (!$connection) {
                                        echo "No Connection to Datebase!!</br>";
                                    }
                                    $q_check = "select * from Muser where user_id='$userid'";
                                    $statement = oci_parse($connection, $q_check);

                                    oci_execute($statement);
                                    $result = oci_fetch_array($statement, OCI_BOTH);

                                    if ($result) {

                                        //	 $result = array("6", "ysu", "ysu", "ysu@cise.ufl.edu", "Aug-06-1988", "125 SW 5th Terrace", "Gainesville", "FL", "32601", "ysu"); 

                                        echo" <h2>$result[2]</h2>
				<h3>Welcome to Your Movie Time Page!</h3>
				</header>
										
	<div class=\"profile\">									
	<img src=\"images/user/$userid.jpg\" alt=\"user defalut profile pic\" onError=\"this.src='images/user/default.jpg';\" width=\"239\" height=\"280\" />
    
	<div class=\"User info\" style=\"position:relative; left:300px; top:-230px;\">
    
    <p> User ID: $userid</p>	
    <p> Birthday: $result[4]</p>
    <p> Email: $result[3]</p>
    <p> Address: $result[5], $result[6], $result[7], $result[8] </p>
	
	";
                                    } else {
                                        echo"<h3>Sorry! The username/password is wrong!
        <p>
            <a href=http://www.cise.ufl.edu/~you/login.php>Please try again</a> or 
            <a href = http://www.cise.ufl.edu/~you/register.php>Register</a>!
        </p>
            </h3>";
                                    }
                                    ?>


                                    </div>
                                    </div>

                                    <div class="comment" style="position:relative; top:-170px;">
                                        <?php
                                        echo"
                                        <form action=\"addcomment.php\" method=\"post\" id=\"commentform\">
                                        <input type=\"hidden\" name=\"fromcomid\" value=\"$userid\" />
                                        <input type=\"hidden\" name=\"tocomid\" value=\"$userid\" />
                                        
                                            <textarea name=\"commenttext\" style=\"alignment-adjust:auto\" cols=\"100\" rows=\"4\" placeholder=\"Comment here...\"></textarea>
                                            <input style=\"padding: 3px 42px; font-size: 1.5em; vertical-align:middle;\" class=\"button-big\" type=\"submit\" value=\"submit comment\" id />
                                        </form>";

                                        $q_comtofriend = "select name, c_time, content from mcomment, muser where to_id = '$userid' and from_id = user_id";
                                        $statement_comtofriend = oci_parse($connection, $q_comtofriend);
                                        oci_execute($statement_comtofriend);

                                        if (!oci_fetch_object($statement_comtofriend)) {
                                            echo "<p>No comment yet. Any comment to your friend?</p>";
                                        } else {
                                            oci_execute($statement_comtofriend);
                                            echo "<table border=1>";
                                            $i = 1;
                                            while (oci_fetch_object($statement_comtofriend) and $i <= 100) {
                                                $fromuser = oci_result($statement_comtofriend, 'NAME');
                                                $content = oci_result($statement_comtofriend, 'CONTENT');
                                                $commenttime = oci_result($statement_comtofriend, 'C_TIME');

                                                echo "<tr>
                 	  <td> $fromuser: &nbsp; </td>
                  	  <td> $content &nbsp; </td>
					  <td> at $commenttime </td>
                       </tr>";
                                                $i++;
                                            }
                                            echo "</table>";
                                            //oci_free_statement($statement_comtofriend);
                                        }
                                        echo "</div>";
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
                                    </html></html>