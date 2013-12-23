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

$u_username = $_POST['uusername'];
$u_password = $_POST['upassword'];
$u_name = $_POST['uname'];

$u_email = $_POST['uemail'];
$u_street = $_POST['ustreet'];
$u_city = $_POST['ucity'];
$u_state = $_POST['ustate'];
$u_zip = $_POST['uzip'];
$up1 = $_POST['up1'];
$up2 = $_POST['up2'];
$up3 = $_POST['up3'];

putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");
$conn = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');
										
$q14 = "select * from muser where user_id = $userid";
$st14 = oci_parse($conn, $q14);
oci_execute($st14);
oci_fetch_object($st14);
											 
$resultUN = oci_result($st14, 'USERNAME');
$resultN = oci_result($st14, 'NAME');
$resultEA = oci_result($st14, 'EMAIL_ADDR');
$resultST = oci_result($st14, 'STREET');
$resultC = oci_result($st14, 'CITY');
$resultS = oci_result($st14, 'STATE');
$resultZ = oci_result($st14, 'ZIPCODE');
											 
$q15 = "select g_name from prefer where user_id = $userid and prank = 1";
$st15 = oci_parse($conn, $q15);
oci_execute($st15);
oci_fetch_object($st15);
											 
$resultP1 = oci_result($st15, 'G_NAME');
											 
$q16 = "select g_name from prefer where user_id = $userid and prank = 2";
$st16 = oci_parse($conn, $q16);
oci_execute($st16);
oci_fetch_object($st16);
											 
$resultP2 = oci_result($st16, 'G_NAME');
											 
$q17 = "select g_name from prefer where user_id = $userid and prank = 3";
$st17 = oci_parse($conn, $q17);
oci_execute($st17);
oci_fetch_object($st17);
											 
$resultP3 = oci_result($st17, 'G_NAME');
?>

<html>

    <head>
    <head>
        <title>Edit Profile</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <noscript><link rel="stylesheet" href="css/5grid/core.css" /><link rel="stylesheet" href="css/5grid/core-desktop.css" /><link rel="stylesheet" href="css/5grid/core-1200px.css" /><link rel="stylesheet" href="css/5grid/core-noscript.css" /><link rel="stylesheet" href="css/style.css" /><link rel="stylesheet" href="css/style-desktop.css" /></noscript>
        <script src="css/5grid/jquery.js"></script>
        <script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none&amp;mobileUI.titleBarHeight=55&amp;mobileUI.openerWidth=75&amp;mobileUI.openerText=&lt;"></script>
        <!--[if lte IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->
    </head>
</head>

<body>
    <?php
				
		 if($u_name OR $u_email OR $u_street OR $u_city OR $u_state OR $u_zip){
			$q3 = "update muser set name = '$u_name', email_addr = '$u_email', street = '$u_street', city = '$u_city', state = '$u_state', zipcode = '$u_zip' where user_id = $userid";
            $st3 = oci_parse($conn, $q3);
            oci_execute($st3);
            oci_free_statement($st3);
		 }
			
			if($u_password){
				
				$q4 = "update muser set password = '$u_password' where user_id = $userid";
                $st4 = oci_parse($conn, $q4);
                oci_execute($st4);
                oci_free_statement($st4);
			}
			
			if($up1){
				if($resultP1){
            $q10 = "update prefer set g_name = '$up1' where user_id = $userid and prank = 1";
            $st10 = oci_parse($conn, $q10);
            oci_execute($st10);
            oci_free_statement($st10);
			} else{
				$q1 = "insert into prefer values ($userid, '$up1', 1)";
                $st1 = oci_parse($conn, $q1);
                oci_execute($st1);
                oci_free_statement($st1);
			}
			}
			
			if($up2){
				if($resultP2){
            $q11 = "update prefer set g_name = '$up2' where user_id = $userid and prank = 2";
            $st11 = oci_parse($conn, $q11);
            oci_execute($st11);
            oci_free_statement($st11);
			} else{
				$q2 = "insert into prefer values ($userid, '$up2', 2)";
                $st2 = oci_parse($conn, $q2);
                oci_execute($st2);
                oci_free_statement($st2);
			}
			}

			if($up3){
				if($resultP3){
            $q13 = "update prefer set g_name = '$up3' where user_id = $userid and prank = 3";
            $st13 = oci_parse($conn, $q13);
            oci_execute($st13);
            oci_free_statement($st13);
			} else{
				$q5 = "insert into prefer values ($userid, '$up3', 3)";
                $st5 = oci_parse($conn, $q5);
                oci_execute($st5);
                oci_free_statement($st5);
			}
			}
    ?>

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
                            echo "<a href=#>Hi, There! | <a href=http://www.cise.ufl.edu/~you/log_out_session.php>LogOut</a>";
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
    </div>

    <!-- Content -->
    <div id="content-wrapper">
        <div id="content">
            <div class="5grid-layout">
                <div class="row">
                    <div class="4u">

                            <!-- Sidebar -->
                            <section>
                                <header>
                                    <h2>What you may use</h2>
                                </header>
                                <form action="find_friend.php" method="post" id="searchfiendform">								
                                    <ul class="link-list">
                                        <li>Find your friend: <input type="text" name="friendname"/> <input style="padding: 1px 10px; font-size: 1em;" class="button-big" type="submit" value="search"/></li>
                                        <li><a href="/~you/friendlist.php">Your friend list</a></li>
                                        <li><a href="/~you/movierec.php">Recommendation for you</a></li>
                                        <li><a href="/~you/cart.php">Go to your cart</a></li>
                                        <li><a href="/~you/orderhistory.php">View past Purchase History</a></li>

                                        <li><a href="/~you/pastcomment.php">View past comments</a></li>										
                                    </ul>
                                </form>
                            </section>
                        </div>

                    <div class="8u">

                        <!-- Main Content -->
                        <section>
                            <header>
                                <h2 style="text-align:center;">Edit Your Profile</h2>
                            </header>
                            
                            

                            <p>
                                <p style="position:relative; left: 200px; font-size: 1.2em;">
                                   Username:<br/>
                                   <?php echo $resultUN; ?>
                                </p>
                            <form action="http://www.cise.ufl.edu/~you/editprofile.php" method="post">
                               
                                <p style="position:relative; left: 200px; font-size: 1.2em;">Password:<br/>
                                    <input type="password" name="upassword" size="47" />
                                </p>
                                <p style="position:relative; left: 200px; font-size: 1.2em;">Full Name:<br/>
                                    <input type="text" name="uname" size="47" value="<?php echo $resultN; ?>" />
                                </p>         
                                <p style="position:relative; left: 200px; font-size: 1.2em;">Email:<br/>
                                    <input type="text" name="uemail" size="47" value="<?php echo $resultEA; ?>" />
                                </p> 
                                <p style="position:relative; left: 200px; font-size: 1.2em;">Your Movie Stytle:</br>
                                    First Choice:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="up1" style="width:12em;">
                                        <option value="null"></option>
                                        <option value="Music">Music</option>
                                        <option value="Documentary">Documentary</option>
                                        <option value="Comedy">Comedy</option>
                                        <option value="Animation">Animation</option>
                                        <option value="Drama">Drama</option>
                                        <option value="Western">Western</option>
                                        <option value="Fantasy">Fantasy</option>
                                        <option value="TV Classics">TV Classics</option>
                                        <option value="Thriller">Thriller</option>
                                        <option value="Mystery/Suspense">Mystery/Suspense</option>
                                        <option value="Horror">Horror</option>
                                        <option value="Foreign">Foreign</option>
                                        <option value="Action/Adventure">Action/Adventure</option>
                                        <option value="SciFi">SciFi</option>
                                        <option value="Sports">Sports</option>
                                        <option value="War">War</option>
                                        <option value="History Channel">History Channel</option>
                                        <option value="Dance/Ballet">Dance/Ballet</option>
                                    </select>
                                    </br>
                                    Second Choice:&nbsp;&nbsp;&nbsp;
                                    <select name="up2" style="width:12em;">
                                        <option value="null"></option>
                                        <option value="Music">Music</option>
                                        <option value="Documentary">Documentary</option> 
                                        <option value="Comedy">Comedy</option>
                                        <option value="Animation">Animation</option>
                                        <option value="Drama">Drama</option>
                                        <option value="Western">Western</option>
                                        <option value="Fantasy">Fantasy</option>
                                        <option value="TV Classics">TV Classics</option>
                                        <option value="Thriller">Thriller</option>
                                        <option value="Mystery/Suspense">Mystery/Suspense</option>
                                        <option value="Horror">Horror</option>
                                        <option value="Foreign">Foreign</option>
                                        <option value="Action/Adventure">Action/Adventure</option>
                                        <option value="SciFi">SciFi</option>
                                        <option value="Sports">Sports</option>
                                        <option value="War">War</option>
                                        <option value="History Channel">History Channel</option>
                                        <option value="Dance/Ballet">Dance/Ballet</option>
                                    </select>
                                    </br>
                                    Third Choice:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="up3" style="width:12em;">
                                        <option value="null"></option>
                                        <option value="Comedy">Comedy</option>
                                        <option value="Music">Music</option>
                                        <option value="Documentary">Documentary</option>
                                        <option value="Animation">Animation</option>
                                        <option value="Drama">Drama</option>
                                        <option value="Western">Western</option>
                                        <option value="Fantasy">Fantasy</option>
                                        <option value="TV Classics">TV Classics</option>
                                        <option value="Thriller">Thriller</option>
                                        <option value="Mystery/Suspense">Mystery/Suspense</option>
                                        <option value="Horror">Horror</option>
                                        <option value="Foreign">Foreign</option>
                                        <option value="Action/Adventure">Action/Adventure</option>
                                        <option value="SciFi">SciFi</option>
                                        <option value="Sports">Sports</option>
                                        <option value="War">War</option>
                                        <option value="History Channel">History Channel</option>
                                        <option value="Dance/Ballet">Dance/Ballet</option>
                                    </select>
                                </p>
                                <p style="position:relative; left: 200px; font-size: 1.2em;">Street:<br/>
                                    <input type="text" name="ustreet" size="47" value="<?php echo $resultST; ?>" />
                                </p>
                                <p style="position:relative; left: 200px; font-size: 1.2em;">City:<br/>
                                    <input type="text" name="ucity" size="47" value="<?php echo $resultC; ?>" />
                                </p>
                                <p style="position:relative; left: 200px; font-size: 1.2em;">State:<br/>
                                    <input type="text" name="ustate" size="47" value="<?php echo $resultS; ?>" />
                                </p>
                                <p style="position:relative; left: 200px; font-size: 1.2em;">Zip-code:<br/>
                                    <input type="text" name="uzip" size="47" value="<?php echo $resultZ; ?>" />
                                </p>

                                <p style="position:relative; left: 380px;">
                                    <input style="padding: 0.8px 42px; font-size: 1.5em;" class="button-big" type="submit" name="submit" value="Update" />
                                </p>
                            </form>
                            <?php oci_free_statement($st14); oci_close($conn); ?>
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
                        
                        <p>Copyright Â©2013 G6. All Rights Reserved.

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